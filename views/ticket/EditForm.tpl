<script type="text/javascript" src="{$baseUrl}/js/modules/category/list.js"></script>

<div class="styledForm" style="width: 90% !important;">
     <form action="{url action=$actionForm}" method="post" class="validate">
     <input type="hidden" name="id_employee" id="id_employee" value="{$employee->getIdEmployee()}" />
     <input type="hidden" name="id_company" id="id_company" value="{$employee->getIdCompany()}" />
   {if $ticket}
     <input type="hidden" name="id_ticket" id="id_ticket" value="{$ticket->getIdTicket()}" />
   {/if}
     <fieldset>
             
         <div class="clearfix">
             <div><label for="id_ticket_type" class="required">{$i18n->_("Ticket Type: ")}</label></div>
             <span class="input">{html_options options=$ticketTypes name=id_ticket_type selected=$post['id_ticket_type'] id=id_ticket_type class="span4 required"}</span>
         </div>
         
         <div class="clearfix">
             <div><label for="id_channel" class="required">{$i18n->_("Channel: ")}</label></div>
             <span class="input">{html_options options=$channels name=id_channel id=id_channel selected=$post['id_channel'] class="span4 required"}</span>
         </div>
         
         <div class="clearfix" style="display : none">
             <div><label for="id_impact" class="required">{$i18n->_("Impact: ")}</label></div>
             <span class="input">{html_options options=$impacts name=id_impact id=id_impact selected=1 class="span4 "}</span>
         </div>
         
         <div class="clearfix" style="display : none">
             <div><label for="id_priority" class="required">{$i18n->_("Priority: ")}</label></div>
             <span class="input">{html_options options=$priorities name=id_priority id=id_priority selected=1 class="span4 "}</span>
         </div>
         
         <div class="clearfix">
             <div><label for="scheduled_date" class="">{$i18n->_("Date and Hour: ")}</label></div>
             <span class="input"><input type="text" class="datetimepicker span4" maxlength="16" id="scheduled_date" name="scheduled_date" value="{substr($post['scheduled_date'], 0, 16)}" {if $isShow}readonly="readonly"{/if}/></span>
         </div>
         
       <table>
	       <tbody>
		        <tr>
		            <td><label for="id_category" class="required">{$i18n->_("Category: ")}</label><td>
		            <td> </div><span class="input"><div style="width: 500px; max-height: 500px;  text-align: left; overflow: auto;">{render_categories nestedCategories=$nestedCategories renderer=select selected=$post['id_category']}</span></td>
		          
		        </tr>
	        </tbody>
      </table>
    
         <div class="clearfix">
             <div><label for="description" class="required">{$i18n->_("Description: ")}</label></div>
             <span class="input"><textarea name="description" id="description" class="required"  style="width: 503px; height: 105px;" {if $isShow}readonly="readonly"{/if}>{$post['description']}</textarea></span>
         </div>
             
         <div class="actions">
         
         {if !$ticket || ( $ticket && !in_array($ticket->getStatusName(), ['Closed']) )}
             {if !$isShow}<button class="btn primary" name="send" id="send">{icon src=disk}{$i18n->_('Save')}</button>{/if}
         {/if}      
             
             <button id="cancel" type="button" class="btn">{icon src=arrow_undo}{$i18n->_('Back')}</button>
             
           {if $ticket}
                 {if $ticketMachine->isCappableByConditionName($ticket, "Cancel")}
                    {if "ticket/cancel"|isAllowed}<a href="{url action=cancel id_ticket=$ticket->getIdTicket()}" id="cancelTicket" class="btn confirm" data-confirm-title="{$i18n->_('Cancel Ticker')}" data-confirm-message="{$i18n->_('This ticket will be canceled. Are you sure?')}">{icon src=cancel}{$i18n->_('Cancel Ticket')}</a>{/if}
                  {/if}
                  {if $ticketMachine->isCappableByConditionName($ticket, "Work")}
                    {if "ticket/working"|isAllowed}<a href="{url action=working id_ticket=$ticket->getIdTicket()}" id="" class="btn">{icon src=working}{$i18n->_('Working')}</a>{/if}
                  {/if}
                  {if $ticketMachine->isCappableByConditionName($ticket, "Read")}
                    {if "ticket/read"|isAllowed}<a href="{url action=read id_ticket=$ticket->getIdTicket()}" id="" class="btn">{icon src=email_open}{$i18n->_('Mark as Read')}</a>{/if}
                  {/if}
                  {if $ticketMachine->isCappableByConditionName($ticket, "Open")}
                    {if "ticket/reopen"|isAllowed}<a href="{url action=reopen id_ticket=$ticket->getIdTicket()}" id="" class="btn">{icon src="arrow_rotate_anticlockwise"}{$i18n->_('Reopen')}</a>{/if}
                  {/if}
                  {if $ticketMachine->isCappableByConditionName($ticket, "Close")}
                    {if "ticket/close"|isAllowed}<a href="{url action=close id_ticket=$ticket->getIdTicket()}" id="" class="btn">{icon src=accept}{$i18n->_('Close Ticket')}</a>{/if}
                  {/if}
                {if !in_array($ticket->getStatusName(), ['Unread', 'Closed'])}
                  {if $ticket->getIsStopped()}
                    {if "ticket/resume"|isAllowed}<a href="{url action=resume id_ticket=$ticket->getIdTicket()}" class="btn">{icon src=control_play_blue}{$i18n->_('Resume')}</a>{/if}
                  {else}
                    {if "ticket/pause"|isAllowed}<a href="{url action=pause id_ticket=$ticket->getIdTicket()}" class="btn">{icon src=control_pause_blue}{$i18n->_('Pause')}</a>{/if}
                  {/if}
                {/if}
           {/if}
         </div>
         
     </fieldset>
     </form>
 </div>  