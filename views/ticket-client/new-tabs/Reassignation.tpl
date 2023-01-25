<div id="assignTicketTab3">
<div class="styledForm" style="width: 90% !important;">
<form method="post" action="{$baseUrl}/ticket-client/reassign" class="validate">
<input type="hidden" name="id" value="{$ticketClient['id_ticket_client']}"/>
{if !empty($ticketClient['assigned_to'])}
	
	{*<div class="clearfix">
		<div>
			<label for="id_user" class="required">{$i18n->_('User Assigned :')}</label>
		</div>
		<span class="input">{$ticketClient['assigned_to']}</span>
	</div>*}
{/if}

	<div class="clearfix">
		<div>
			<label for="id_user" class="required">{$i18n->_('Usuario a Reasignar: ')}</label>
		</div>
		<span class="input">
			{html_options options=$comboTo name="id_user" id="id_user" selected=$userAssigned class="required"}
		</span>
	</div>
        <div class="clearfix">
		<div>
			<label for="note" class="required">{$i18n->_('Activity :')}</label>
		</div>
		<div>
			<textarea name="note" id="note" cols="80" rows="5" class="required"></textarea>
		</div>
	</div>        
	<div class="actions">
		<input id="send" value="{$i18n->_('Reassign')}" class="btn primary" type="submit">
	</div>
</form>
</div>
</div>