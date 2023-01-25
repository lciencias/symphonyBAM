<script type="text/javascript"> 
    var baseUrl = "{$baseUrl}";
    var language = "{$language}"; 
    var controller = "{$controller}";
    var action = "{$action}";
</script>

<script type="text/javascript" src="{$baseUrl}/js/i18n.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery.dcmegamenu.1.3.3.min.js"></script> 
<script type="text/javascript" src="{$baseUrl}/bootstrap/js/bootstrap-twipsy.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery.treeview.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/jquery.gritter.min.js"></script>
{if $language == 'es'}
<script type="text/javascript" src="{$baseUrl}/js/plugins/localization/messages_es.js"></script>
{/if}
<script type="text/javascript" src="{$baseUrl}/js/app.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/cloner.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/scripts.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/rules.js"></script>
<!--  se añaden para el tablesorter -->

<script type="text/javascript" src="{$baseUrl}/js/plugins/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" src="{$baseUrl}/js/plugins/tablesorter/jquery.tablesorter.widgets.js"></script>
<!-- fin de tablesorter -->
{foreach $scripts as $script}
<script type="text/javascript" src="{$baseUrl}/js/{$script}"></script>
{/foreach}