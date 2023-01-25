<h1>{$i18n->_('Error')} {$code}</h1>

<div class="alert-message error">{$message}</div>

{if $debugMessage}
    
    <p><strong>{$file}</strong></p>
    <div id="ExceptionDetail">
        {$debugMessage}
    </div>

{/if}