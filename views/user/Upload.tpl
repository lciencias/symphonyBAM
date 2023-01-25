<div id="styledForm">
<br /><h3>{$i18n->_('Upload Users')}</h3>

{if $errors}
<div class="alert-message error">
    {foreach $errors as $error}
        {$error}<br />
    {/foreach}
</div>
{/if}

<form class="validate" enctype="multipart/form-data" method="post" action="">
    <fieldset>
        <div class="clearfix ">
            <label for="name" class="required">{$i18n->_('File')}</label>
            <div class="input">
                <input type="file" name="file" id="file" class="required" />
            </div>
            
        </div>
        
        <div class="actions">
            <input type="submit" name="send" id="send" value="{$i18n->_('Upload')}" class="btn primary">
            <input type="button" name="cancel" id="cancel" value="{$i18n->_('Cancel')}" class="btn">
        </div>
        
    </fieldset>
</form>
</div>
