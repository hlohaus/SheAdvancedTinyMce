{block name="backend/base/header/javascript"}
{$smarty.block.parent}
<script type="text/javascript">
    Shopware.form.field.TinyMCE.setGlobalSettings({
{if !empty($tinyMceConfig.useThemeAdvancedButtons)}

        theme_advanced_buttons1: "{$tinyMceConfig.themeAdvancedButtons1|strip|replace:" ":""|escape:javascript}",
        theme_advanced_buttons2: "{$tinyMceConfig.themeAdvancedButtons2|strip|replace:" ":""|escape:javascript}",
        theme_advanced_buttons3: "{$tinyMceConfig.themeAdvancedButtons3|strip|replace:" ":""|escape:javascript}",
        theme_advanced_buttons4: "{$tinyMceConfig.themeAdvancedButtons4|strip|replace:" ":""|escape:javascript}",
{/if}
{if !empty($tinyMceConfig.usePlugins)}
        plugins: "{$tinyMceConfig.plugins|strip|replace:" ":""|escape:javascript}",
{/if}
{if !empty($tinyMceConfig.useExtendedValidElements)}
        extended_valid_elements : "{$tinyMceConfig.extendedValidElements|strip|replace:" ":""|escape:javascript}",
{/if}
{if !empty($tinyMceConfig.useHtml5Schema)}
        schema: "html5",
{/if}
{if !empty($tinyMceConfig.useContentCss)}
        content_css: "{link file=$tinyMceConfig.contentCss fullPath}?_dc=" + new Date().getTime(),
{/if}
{if !empty($tinyMceConfig.useStyleFormats)}
        style_formats: [
            {$tinyMceConfig.styleFormats}
        ],
{/if}
{if !empty($tinyMceConfig.useInvalidElements)}
        invalid_elements: "{$tinyMceConfig.invalidElements|escape:javascript}",
{/if}
        skin_variant : "{if !empty($tinyMceConfig.skinVariant)}{$tinyMceConfig.skinVariant}{else}shopware{/if}",
        template_external_list_url: "{url controller=tinyMce action=getRawTemplateList}?__csrf_token=" + Ext.CSRFService.getToken()
    });
</script>
{/block}