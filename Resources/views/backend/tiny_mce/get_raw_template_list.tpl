var tinyMCETemplateList = new Array(
// Name, URL, Description
{foreach $templates as $template}
    ["{$template.name|escape:javascript}", "data:text/html;base64,{$template.content|base64_encode}", "{$template.description|escape:javascript}"]
{/foreach}
);
