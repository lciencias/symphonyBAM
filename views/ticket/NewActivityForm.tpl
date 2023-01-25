<div class="styledForm" style="width: 90% !important;">
    <form action="{url controller=activity action=create}" method="post" class="validate">
        <input type="hidden" name="id_ticket" id="id_ticket" value="{$ticket->getIdTicket()}" />
        <input type="hidden" name="id_base_ticket" id="id_base_ticket" value="{$ticket->getIdBaseTicket()}" />
        <fieldset>
        
            {if $assignment}
            
            <div class="clearfix">
                 <div><label for="id_user" class="required">{$i18n->_("User Assigned")} :</label></div>
                 <span class="input">{$userAssigned->getFullname()}</span>
             </div>
            
            {/if}
        
            <div class="clearfix">
                 <div><label for="start_date" class="required">{$i18n->_("Start Date: ")}</label></div>
                 <div><input type="text" name="start_date" id="start_date" value="" class="datetimepicker" /></div>
            </div>
            <div class="clearfix">
                 <div><label for="end_date" class="required">{$i18n->_("End Date: ")}</label></div>
                 <div><input type="text" name="end_date" id="end_date" value="" class="datetimepicker" /></div>
            </div>
            <div class="clearfix">
                 <div><label for="note" class="required">{$i18n->_("Activity")} :</label></div>
                 <div><textarea name="note" id="note" cols="80" rows="5"></textarea></div>
            </div>
            <div class="actions">
                <input type="submit" name="send" id="send" value="{$i18n->_("Save")}" class="btn primary" />
            </div>
        
        </fieldset>
    </form>
</div>