<br /><h3>{$i18n->_("Ticket")} {if $ticket}#{$ticket->getIdTicket()}{/if} </h3><hr /><br />

<table>
    <tbody>
      {if $ticket}
      <tr>
			<td colspan="8"><h4>Resumen del Ticket</h4></td>
       </tr>
        <tr>
            <th>{$i18n->_("Status: ")}</th>
            <td>{$i18n->_($ticket->getStatusName())}{if $ticket->getIsStopped()} {$i18n->_("(Paused)")}{/if}</td>
            <th>{$i18n->_("Registered by: ")}</th>
            <td>{$registeredByUser->getFullname()}</td>
            <th>{$i18n->_('Register Date')}</th>
            <td>{$registerLog->getDateLog()}</td>
            <th>{$i18n->_('Assigned User')}</th>
            <td>{if $userAssigned}{$userAssigned->getFullname()}{/if}</td>
        </tr>
       <tr>
			<td colspan="8"><h4>Nivel de Servicio</h4></td>
       </tr>
        <tr>
            <th>Tiempo de {$i18n->_("Service Level: ")}</th>
            <td class="tip" title="Tiempo de Respuesta: {$responseTime->toHuman()} Tiempo de Resoluci&oacute;n: {$resolutionTime->toHuman()}">{$serviceLevelTime->toHuman()}</td>
        	<th>{$i18n->_("Time of Service: ")}</th>
            <td class="tip" title="Tiempo trabajado en base al horario del grupo de trabajo ">{$timeOfService->toHuman()}</td>
        	<th>D&iacute;as h&aacute;biles</th>
            <td class="tip" title="N&uacute;mero de d&iacute;as laborales del grupo de trabajo transcurridos hasta la fecha actual o el cierre del ticket">{$elapsedDays->toHuman()}</td>
            <th>D&iacute;as naturales</th>
            <td class="tip" title="N&uacute;mero de d&iacute;as naturales transcurridos desde la creaci&oacute; del ticket hasta la fecha actual o el cierre del ticket">{$elapsedNaturalDays->toHuman()}</td>
            
        </tr>
        <tr>
            <th>{$i18n->_("Percentage of Service: ")}</th>
            <td>{$percentageService} %</td>
            <th>{$i18n->_("Expiration Date: ")}</th>
            <td>{$expirationDate->get('yyyy-MM-dd HH:mm:ss')}</td>
          {if $timeToExpire->getSeconds() > 0}
            <th>{$i18n->_("Tiempo para que Expire: ")}</th>
            <td>{$expirationDate->get('yyyy-MM-dd HH:mm:ss')} ( {$timeToExpire->toHuman()} )</td>
          {else}
            <th>{$i18n->_("Expired Time: ")}</th>
            <td>{$expiredTime->toHuman()}</td>
          {/if}
          <td colspan="2"></td>
        </tr>
        {/if}
        <tr>
			<td colspan="8"><h4>Informaci&oacute;n del Empleado</h4></td>
       </tr>
        <tr>
            <th>{$i18n->_("Name: ")}</th>
            <td>{$employee->getFullName()}</td>
            <th>{$i18n->_("Employee Number: ")}</th>
            <td>{$employee->getIdEmployee()}</td>
            <th>{$i18n->_("Vip: ")}</th>
            <td>{if $employee->getIsVip()}{$i18n->_("Yes")}{else}{$i18n->_("No")}{/if}</td>
            <th>{$i18n->_("Status: ")}</th>
            <td>{$i18n->_($employee->getStatusEmployeeName())}</td>
        </tr>
        <tr>
            <th>{$i18n->_("Company: ")}</th>
            <td>{$company->getName()}</td>
            <th>{$i18n->_("Position: ")}</th>
            <td>{$position->getName()}</td>
            <th>{$i18n->_("Area: ")}</th>
            <td>{$area->getName()}</td>
            <th>{$i18n->_("Location: ")}</th>
            <td>{$location->getName()}</td>
        </tr>  
        <tr>
            <th>{$i18n->_("Phone Numbers: ")}</th>
            <td>{implode($phoneNumbers->toCombo(), ',')}</td>
            <th>{$i18n->_("Emails: ")}</th>
            <td>{implode($emails->toCombo(), ',')}</td>
            <td colspan="4"></td>
        </tr>
    </tbody>

</table>
<br /><br />
{if $ticket}
	{if $ticket->getStatusName() eq 'Reopen'}
	<div class="alert-message warning">{$i18n->_('To resolve this ticket again, you must reassign it.')}</div>
	{/if}
{/if}
<div id="tabs">
    <ul>
        <li><a href="#newTicketTab">{$i18n->_("Ticket")}</a></li>
      {if $ticket}
          {if !$ticket->getIsStopped() && in_array($ticket->getStatusName(), ['Read', 'Reopen', 'Assigned', 'Working'])}     
            {if in_array($ticket->getStatusName(), ['Assigned', 'Working'])}{$titleTab = $i18n->_('Reassign')}{else}{$titleTab = $i18n->_('Assign')}{/if}
            {if 'ticket/assign'|isAllowed}<li><a href="#assignTicketTab">{$titleTab}</a></li>{/if}
          {/if}
          {if !in_array($ticket->getStatusName(), ['Unread', 'Closed'])}
            {if 'activity/create'|isAllowed}<li><a href="#newActiivity">{$i18n->_("New Activity")}</a></li>{/if}
          {/if}
            <li><a href="{url controller=activity action=list id_ticket=$ticket->getIdTicket()}">{$i18n->_("Activities")}</a></li>
          {if !$ticket->getIsStopped() && $ticketMachine->isCappableByConditionName($ticket, "Resolve")}
            {if 'ticket/resolve'|isAllowed}<li><a href="#resolveTicketTab">{$i18n->_("Resolve")}</a></li>{/if}
          {/if}
            <li><a href="#attachments">{$i18n->_("Attachments")}</a></li>
            <li><a href="{url controller=ticket action=tracking id_ticket=$ticket->getIdTicket()}">{$i18n->_("Tracking")}</a></li>
      {/if}
    </ul>
  {if $ticket}
    {if !$ticket->getIsStopped() && in_array($ticket->getStatusName(), ['Read', 'Reopen', 'Assigned', 'Working'])}
        {if 'ticket/assign'|isAllowed}
        <div id="assignTicketTab">
            {include file="ticket/AssignForm.tpl"}
        </div>
        {/if}
    {/if}
    {if !in_array($ticket->getStatusName(), ['Unread', 'Closed'])}
       {if 'activity/create'|isAllowed}
         <div id="newActiivity">
            {include file="ticket/NewActivityForm.tpl"}
         </div>
       {/if}
    {/if}
     <div id="activities"></div>
    {if $ticketMachine->isCappableByConditionName($ticket, "Resolve")}
       {if 'ticket/resolve'|isAllowed}
          <div id="resolveTicketTab">
              {include file="ticket/ResolveForm.tpl"}
          </div>
       {/if}
    {/if}
    <div id="attachments">
        {include file="attachment/New.tpl"}
    </div>
    <div id="tracking"></div>
  {/if}
  
    <div id="newTicketTab">    
        {include file="ticket/EditForm.tpl"}
    </div>
    
</div>
<br />


