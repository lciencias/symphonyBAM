<div class="styledForm" style="width: 90% !important;">
    <form action="{url action=resolve}" method="post" class="validate">
        <input type="hidden" name="id_ticket" id="id_ticket" value="{$ticket->getIdTicket()}" />
        <fieldset>
                
            <div class="clearfix">
                 <div><label for="id_user" class="required">{$i18n->_("Resolution: ")}</label></div>
                 <span class="input">{html_options options=$resolutions name=id_resolution id=id_resolution class="required span4" selected=$post['id_resolution']}</span>
             </div>
             
             <div class="clearfix">
                 <div><label for="note" class="required">{$i18n->_("Description: ")}</label></div>
                 <span class="input"><textarea name='note' id="note" class="required" style="width: 503px; height: 105px;"></textarea></span>
             </div>
        
            <div class="actions">
                <input type="submit" name="send" id="send" value="{$i18n->_('Resolve')}" class="btn primary" />
            </div>
        
        </fieldset>
    </form>
</div>