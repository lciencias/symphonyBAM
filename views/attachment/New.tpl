{include file="attachment/List.tpl"}

{if 'attachment/create'|isAllowed}
<div id="styledForm">
    <form class="validate" enctype="multipart/form-data" method="post" action="{url controller=attachment action=create}">
        <input type="hidden" name="id_ticket" value="{$ticket->getIdTicket()}" id="id_ticket" />
        <fieldset>
        
            <div class="clearfix">
                <div id="file_label"><label for="file" class="required">{$i18n->_('Attachment')}</label></div>
                <span class="input"><input type="file" name="file" id="file" /></span>
            </div>

            <div class="actions">
                <input type="submit" name="send" id="send" value="{$i18n->_('Upload')}" class="btn primary">
                <button name="cancel" id="cancel" type="button" class="btn">{$i18n->_('Cancel')}</button>
            </div>
            
        </fieldset>
    </form>
</div>  
{/if}
