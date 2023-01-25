<div id="assignTab">
<div class="styledForm" style="width: 90% !important;">
<form method="post" action="{$baseUrl}/ticket-client/assign" class="validate">
<input type="hidden" name="id" value="{$ticketClient['id_ticket_client']}"/>
{if !empty($ticketClient['assigned_to'])}
	
	<div class="clearfix">
		<div>
			<label for="id_user" class="required">{$i18n->_('User Assigned :')}</label>
		</div>
		<span class="input">{$ticketClient['assigned_to']}</span>
	</div>
{/if}

	<div class="clearfix">
		<div>
			<label for="id_user" class="required">{$i18n->_('User: ')}</label>
		</div>
		<span class="input">
			{html_options options=$users name="id_user" id="id_user" selected=$userAssigned class="required"}
		</span>
	</div>
	<div class="actions">
		<input id="send" value="{$i18n->_('Reassign')}" class="btn primary" type="submit">
	</div>
</form>
</div>
</div>