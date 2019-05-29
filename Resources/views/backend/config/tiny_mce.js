//{namespace name=backend/config/view/tinymce}

//{block name="backend/config/controller/form"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Config.model.form.TinyMce', {
    extend: 'Ext.data.Model',
    fields: [
        { name:'id', type:'int' },
        { name:'name', type:'string' },
        { name:'description', type:'string', useNull:true },
        { name:'content', type:'string', useNull:true }
    ]
});
Ext.define('Shopware.apps.Config.store.form.TinyMce', {
    model: 'Shopware.apps.Config.model.form.TinyMce',
    remoteSort: true,
    remoteFilter: true,
    pageSize: 1000,
    proxy: {
        type: 'ajax',
        url: '{url controller=tinyMce action=getTemplateList}',
        api: {
            create: '{url controller=tinyMce action=saveTemplate}',
            update: '{url controller=tinyMce action=saveTemplate}',
            destroy: '{url controller=tinyMce action=deleteTemplate}'
        },
        reader: {
            type: 'json',
            root: 'data',
            totalProperty:'total'
        }
    }
});
Ext.define('Shopware.apps.Config.view.form.TinyMce', {
    extend: 'Ext.tab.Panel',
    alias: 'widget.config-form-sheadvancedtinymce',

    layout: 'fit',
    activeTab: 0,
    deferredRender: false,

    initComponent: function () {
        var me = this;

        Ext.applyIf(me, {
            items: me.getItems()
        });

        me.callParent(arguments);
    },

    getStore: function () {
        return Ext.create('Shopware.apps.Config.store.form.TinyMce');
    },

    getItems: function () {
        var me = this;
        return [
            me.getConfigForm(),
            me.getFieldForm()
        ];
    },

    getConfigForm: function () {
        var me = this;
        return {
            xtype: 'config-main-form',
            title: '{s name=tinymce/config/title}Settings{/s}',
            shopStore: me.shopStore,
            formRecord: me.formRecord
        };
    },

    getFieldForm: function () {
        var me = this;
        return {
            xtype: 'config-base-form',
            title: '{s name=tinymce/form/title}Templates{/s}',
            items: [{
                xtype: 'config-base-table',
                region: 'center',
                border: false,
                sortableColumns: false,
                store: me.getStore(),
                searchField: 'name',
                columns: me.getColumns()
            }, {
                xtype: 'config-base-detail',
                items: me.getFormItems()
            }]
        };
    },

    getColumns: function () {
        var me = this;
        return [{
            dataIndex: 'name',
            text: '{s name=tinymce/table/name}Title{/s}',
            flex: 1
        }, {
            dataIndex: 'description',
            text: '{s name=tinymce/table/description}Description{/s}',
            flex: 1
        }];
    },

    getFormItems: function () {
        var me = this;
        return [{
            name: 'name',
            fieldLabel: '{s name=tinymce/detail/name}Title{/s}',
            allowBlank: false
        }, {
            name: 'description',
            fieldLabel: '{s name=tinymce/detail/description}Description{/s}'
        }, {
            xtype: 'displayfield',
            fieldLabel: '{s name=tinymce/detail/content}Content{/s}',
            style: 'padding-bottom: 5px'
        }, {
            xtype: 'codemirror',
            name: 'content',
            mode: 'htmlmixed',
            anchor: '100%',
            height: '240px',
            hideLabel: true,
            fieldLabel: '{s name=tinymce/detail/content}Content{/s}'
        }];
    }
});
//{/block}