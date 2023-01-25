<div id="newActivityTab">
<div class="styledForm" style="width: 90% !important;">
<form action="{$baseUrl}/activity/create" method="post" class="validate">
<input type="hidden" name="id_ticket_client" value="{$ticketClient['id_ticket_client']}"/>
{if !empty($ticketClient['assigned_to'])}
	
	<div class="clearfix">
		<div>
			<label for="id_user" class="required">{$i18n->_('User Assigned :')}</label>
		</div>
		<span class="input">{$ticketClient['assigned_to']}</span>
	</div>
{/if}

	{*<div class="clearfix">
		<div>
			<label for="start_date" class="required">{$i18n->_('Start Date: ')}</label>
		</div>
		<div>
			<input name="start_date" id="start_date" value=""
				class="datetimepicker required" type="text">
		</div>
	</div>
	<div class="clearfix">
		<div>
			<label for="end_date" class="required">{$i18n->_('End Date: ')}</label>
		</div>
		<div>
			<input name="end_date" id="end_date" value=""
				class="datetimepicker required" type="text">
		</div>
	</div>*}
	<div class="clearfix">
		<div>
			<label for="note" class="required">{$i18n->_('Activity :')}</label>
		</div>
		<div>
			<textarea name="note" id="note" cols="80" rows="5" class="required"></textarea>
		</div>
	</div>
	<div class="actions">
		<input name="send" id="send" value="{$i18n->_('Save')}" class="btn primary"
			type="submit">
	</div>
</form>
</div>
</div>
