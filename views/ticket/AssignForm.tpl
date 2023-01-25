<div class="styledForm" style="width: 90% !important;">
    <form action="{url action=assign}" method="post" class="validate">
        <input type="hidden" name="id_ticket" id="id_ticket" value="{$ticket->getIdTicket()}" />
        <fieldset>
        
            {if $assignment}
            
            <div class="clearfix">
                 <div><label for="id_user" class="required">{$i18n->_("User Assigned")} :</label></div>
                 <span class="input">{$userAssigned->getFullname()}</span>
             </div>
            
            {/if}
        
            <div class="clearfix">
                 <div><label for="id_user" class="required">{$i18n->_("User: ")}</label></div>
                 {if $userAssigned}{$post['id_user'] = $userAssigned->getIdUser()}{/if}
                 <span class="input">{html_options options=$usersInGroup name=id_user id=id_user selected=$post['id_user']}</span>
             </div>
        
            <div class="actions">
                {if $ticket}{if in_array($ticket->getStatusName(), ['Assigned', 'Working'])}{$titleTab = $i18n->_('Reassign')}{else}{$titleTab = $i18n->_('Assign')}{/if}{/if}
                <input type="submit" name="send" id="send" value="{$titleTab}" class="btn primary" />
            </div>
        
        </fieldset>
    </form>
</div>