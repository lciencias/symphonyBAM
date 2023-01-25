<div id="resolveTab">
<div class="styledForm" style="width: 90% !important;">
<form action="{$baseUrl}/ticket-client/resolve" method="post" class="validate" enctype="multipart/form-data">
<!-- <input type="hidden" name="rclientDataJson"   id="rclientDataJson"  value='{$clientDataJson}'>
<input type="hidden" name="rtransactionsJson" id="rtransactionsJson" value='{$transactionsJson}'> -->

<input type="hidden" name="id" value="{$ticketClient['id_ticket_client']}"/>
	<div class="clearfix">
		<div>
		{if $ticketClient['ticket_type'] eq 'Aclaración'}
			<label for="id_user" class="required">{$i18n->_('Dictum')}: </label>
		{else}
			<label for="id_user" class="required">{$i18n->_('Resolution: ')}</label>
		{/if}
		</div>
		<span class="input">
			{html_options options=$clientResolutions name="id_client_resolution" id="id_client_resolution" class="required span4"}
		 </span>
	</div>

	<div class="clearfix">
		<div>
			<label for="note" class="required">{$i18n->_('Description: ')}</label>
		</div>
		<span class="input"><textarea name="note" id="note" class="required" style="width: 503px; height: 105px;"></textarea>
		</span>
	</div>
	{if $ticketClient['ticket_type'] eq 'Aclaración'}
		<div class="clearfix">
			<div>
				<label for="note" class="required">{$i18n->_('Amount')}: </label>
			</div>
			<span class="input"><span id="rrecovered">{$amountTransactions}</span>
				<input type="hidden" name="recovery_amount" id="recovery_amount" value="{$amountTransactions}"/>
			</span>
		</div>
		<div class="clearfix">
			<div>
				<label for="note" class="required">{$i18n->_('Recovered')}: </label>
			</div>
			<span class="input">
				{html_options options=$boolean name="is_recovered_amount" id="is_recovered_amount" class="required span4"}
			</span>
		</div>

	{/if}
	<div class="clearfix">
		<div>
			<label for="note" class="required">{$i18n->_('Dictum: ')}</label>
		</div>
		<span class="input">
			<input type="file" name="file" class="{if $ticketClient['ticket_type'] != 'Aclaración'}required{/if}"/>
		</span>
	</div>
	
	<div class="actions">
		<input id="send" value="{$i18n->_('Resolve')}" class="btn primary" type="submit">
	</div>
</form>
</div>
</div>