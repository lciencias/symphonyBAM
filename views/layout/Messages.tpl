<br />

{if $error && $environment != 'Prod'}<div class="alert-message error">{$error}</div>{/if}
{if $ok && $environment != 'Prod'}<div class="alert-message success">{$ok}</div>{/if}
{if $warning && $environment != 'Prod'}<div class="alert-message warning">{$warning}</div>{/if}
<div id="dialog-confirm" title="Empty the recycle bin?" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span class="message">These items will be permanently deleted and cannot be recovered. Are you sure?</span></p>
</div>
