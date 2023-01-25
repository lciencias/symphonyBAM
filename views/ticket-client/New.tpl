{if !$errorStatus}
	<h3>{$i18n->_('Ticket Client')}
	{if $action neq 'new'}  {$i18n->_('Folio')}
{*		{if $ticketClient['folio']*}
                {if $ticketClient['folio']|trim != null && $ticketClient['folio']|trim != ""}
			{$ticketClient['folio']}
		{else}
			<span style="color:#152d5e;font-weight:bold;">{$ticketClient['folio_prev']}</span>		
		{/if}
	{/if}
	</h3>
	{if $action eq 'new'}
	{include file="ticket-client/New-form.tpl"}
	{/if}
	<div id="clientInformationContainer">
	{if $action neq 'new'}
	{include file="ticket-client/Ticket-summary.tpl"}
	{/if}
	</div>
	<br>
	{include file="ticket-client/New-tabs.tpl"}
	{if $action eq 'new'}
	{include file="ticket-client/New-ajax.tpl"}
	{/if}
{else}
	<div class="alert-message error">{$errorMessage}</div>
	<div class="center">
		<a class="btn btn-primary" href="{$baseUrl}/{$controller}/{$action}/id/{$id}"><img src="{$baseUrl}/images/template/icons/arrow_refresh.png"> <strong>{$i18n->_('Refresh')}</strong></a>
	</div>
{/if}