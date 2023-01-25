{if $ticketClient['status'] eq 'Reopen'}
<div class="alert-message warning">{$i18n->_('To resolve this ticket again, you must reassign it')}</div>
{/if}
<div id="newForm" 
{if $action eq 'new'}
style="display : none"
{/if}
>
	<div id="tabs">
		<ul>
			<li><a href="#newTicketTab">{$i18n->_('Ticket')}</a></li>
	{if $action neq 'new'}
		{if 'ticket-client/assign'|isAllowed}
			{if !$ticketClient['is_stopped'] && in_Array($ticketClient['status'], ['Reopen', 'Assigned', 'Working','Read'])}
				{if $assignable}
					<li><a href="#assignTab">{$i18n->_('Reassign')}</a></li>
				{/if}
			{/if}
		{/if}
		{if !in_array($ticketClient['status'], ['Unread', 'Closed','Resolved'])}
			{if 'activity/create'|isAllowed}
				<li><a href="#newActivityTab">{$i18n->_('New Activity')}</a></li>
			{/if}
		{/if}
			<li><a href="#activitiesTab">{$i18n->_('Log Activities')}</a></li>
		{if 'ticket-client/resolve'|isAllowed}
			{if $ticketMachine['Resolve']}
				<li><a href="#resolveTab">{$i18n->_('Resolve')}</a></li>
			{/if}
		{/if}
		{*if 'ticket-client/tracking'|isAllowed*}
			<!-- <li><a href="#trackingTab">{$i18n->_('Tracking')}</a></li>-->
		{*/if*}
        {if $assignable}
        	{if !in_array($ticketClient['status'], ['Resolved'])}
        		{if 'ticket-client/reassign'|isAllowed}
            		<li><a href="#assignTicketTab3">{$i18n->_('Realizar comentario')}</a></li>
            	{/if}
	            {*if 'ticket-client/comments'|isAllowed*}
	            	<!-- <li><a href="#commentsTab">{$i18n->_('Comments')}</a></li>-->
	            {*/if*}
            {/if}
		{/if}
	{/if}
	</ul>
	{include file="ticket-client/new-tabs/Ticket.tpl"}
    {if $assignable}
    	{if !in_array($ticketClient['status'], ['Resolved'])}
        	{if 'ticket-client/reassign'|isAllowed}
        		{include file="ticket-client/new-tabs/Reassignation.tpl"}
			{/if}
		{/if}
	{/if}
	{if $action neq 'new'} 
		{if 'ticket-client/assign'|isAllowed}
			{if !$ticketClient['is_stopped'] && in_Array($ticketClient['status'], ['Reopen', 'Assigned', 'Working','Read'])}
				{if $assignable}
				    {if !in_array($ticketClient['status'], ['Resolved'])}
    					{if 'ticket-client/reassign'|isAllowed}
	                    	{include file="ticket-client/new-tabs/Reassign.tpl"}
						{/if}
					{/if}
				{/if}
			{/if}
		{/if}
		{if !in_array($ticketClient['status'], ['Unread', 'Closed','Resolved'])}
			{if 'activity/create'|isAllowed}
				{include file="ticket-client/new-tabs/New-activity.tpl"}
			{/if}
		{/if}
		{include file="ticket-client/new-tabs/Activities.tpl"}
		
		{if $ticketMachine['Resolve']}
			{if 'ticket-client/resolve'|isAllowed}
				{include file="ticket-client/new-tabs/Resolve.tpl"}				
			{/if}
		{/if}			
	{/if}
	</div>
</div>