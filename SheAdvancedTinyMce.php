<?php

namespace SheAdvancedTinyMce;

use Doctrine\ORM\Tools\SchemaTool;
use SheAdvancedTinyMce\Models\TinyMce\Template;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class SheAdvancedTinyMce extends Plugin
{
    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $schemaTool = new SchemaTool($this->container->get('models'));
        $schemaTool->updateSchema(
            $this->getClassesMetaData(),
            true // make sure to use the save mode
        );
    }

    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context)
    {
        if ($context->keepUserData()) {
            return;
        }
        $schemaTool = new SchemaTool($this->container->get('models'));
        $schemaTool->dropSchema(
            $this->getClassesMetaData()
        );
    }

    private function getClassesMetaData()
    {
        return [
            $this->container->get('models')->getClassMetadata(Template::class),
        ];
    }
}
