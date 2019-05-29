<?php

use SheAdvancedTinyMce\Models\TinyMce\Template;
use Shopware\Components\CSRFWhitelistAware;

class Shopware_Controllers_Backend_TinyMce extends Shopware_Controllers_Backend_ExtJs implements CSRFWhitelistAware
{
    public function preDispatch()
    {
        $this->View()->addTemplateDir($this->container->getParameter('she_advanced_tiny_mce.plugin_dir') . '/Resources/views');
        if (!in_array($this->Request()->getActionName(), ['getRawTemplateList'])) {
            parent::preDispatch();
        }
    }

    public function getWhitelistedCSRFActions()
    {
        return ['getRawTemplateList'];
    }

    /**
     * @return Shopware\Components\Model\ModelManager
     */
    public function getModelManager()
    {
        return Shopware()->Models();
    }

    /**
     * @return Shopware\Components\Model\ModelRepository
     */
    public function getTemplateRepository()
    {
        return $this->getModelManager()->getRepository(Template::class);
    }

    public function getTemplateListAction()
    {
        $repository = $this->getTemplateRepository();
        $query = $repository->queryBy(
            (array) $this->Request()->getParam('filter', []),
            (array) $this->Request()->getParam('order', []),
            (int) $this->Request()->getParam('limit', 30),
            (int) $this->Request()->getParam('start', 0)
        );
        $this->View()->assign([
            'success' => true,
            'total' => $this->getModelManager()->getQueryCount($query),
            'data' => $query->getArrayResult(),
        ]);
    }

    public function saveTemplateAction()
    {
        $manager = $this->getModelManager();
        $data = $this->Request()->getPost();
        $data = isset($data[0]) ? array_pop($data) : $data;
        $repository = $this->getTemplateRepository();
        /** @var $model Template */
        $model = null;

        if (!empty($data['id'])) {
            $model = $repository->find($data['id']);
        } else {
            $model = $repository->getClassName();
            $model = new $model();
            $manager->persist($model);
        }

        $model->fromArray($data);
        $manager->flush();

        $data['id'] = $model->getId();

        $this->View()->assign([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function deleteTemplateAction()
    {
        $manager = $this->getModelManager();
        $id = $this->Request()->getParam('id');
        $repository = $this->getTemplateRepository();
        $model = $repository->find($id);
        $manager->remove($model);
        $manager->flush();
        $this->View()->assign([
            'success' => true,
        ]);
    }

    public function getRawTemplateListAction()
    {
        $repository = $this->getTemplateRepository();
        $queryBuilder = $repository->createQueryBuilder('t');
        $queryBuilder->select([
            't.name',
            't.description',
            't.content',
        ]);
        $query = $queryBuilder->getQuery();
        $templates = $query->getArrayResult();
        $this->View()->assign([
            'templates' => $templates,
        ]);
    }
}
