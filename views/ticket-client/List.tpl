
{include file="ticket-client/List-filter.tpl"}
<div id="resultsInformationContainer" style="overflow-y: auto;overflow-x: auto; background-color: #fff;width: 100%;height: auto;">
<table class="tablesorter tablesorter-bootstrap table table-bordered table-striped" id="myTable">
	<thead>
		<tr>
			<th>{$i18n->_('#')}</th>
			<th>{$i18n->_('Folio')}</th>
			<th>{$i18n->_('Date of assignment')}</th>
			<th>{$i18n->_('Date of expiration')}</th>
			<th>{$i18n->_('Client Number')}</th>
			<th>{$i18n->_('Account Number')}</th>
			<th>{$i18n->_('Product')}</th>
			<th>{$i18n->_('Type')}</th>
			<th>{$i18n->_('Channel')}</th>
			<th>{$i18n->_('Category')}</th>
			<th>{$i18n->_('Origin Branch')}</th>
			<th>{$i18n->_('Reported Branch')}</th>
			<th>{$i18n->_('Register By')}</th>
			<th>{$i18n->_('Assigned to')}</th>
			<th>{$i18n->_('Cost')}</th>
			<th>{$i18n->_('Status')}</th>		
			<th colspan="6">{$i18n->_('Actions')}</th>
		</tr>
	</thead>
	{if $tickets|@count eq 10}
	<tfoot>
		<tr>
			<th class="tablesorter" id="tc-id_ticket_client">{$i18n->_('#')}</th>
			<th class="tablesorter" id="tc-folio">{$i18n->_('Folio')}</th>
			<th class="tablesorter" id="tc-created">{$i18n->_('Date of assignment')}</th>
			<th class="tablesorter" id="tc-expiration_date">{$i18n->_('Date of expiration')}</th>
			<th class="tablesorter" id="tc-client_number">{$i18n->_('Client Number')}</th>
			<th class="tablesorter" id="tc-account_number">{$i18n->_('Account Number')}</th>
			<th class="tablesorter" id="tc-id_product">{$i18n->_('Product')}</th>
			<th class="tablesorter" id="tc-id_ticket_type">{$i18n->_('Type')}</th>
			<th class="tablesorter" id="tc-id_channel">{$i18n->_('Channel')}</th>
			<th class="tablesorter" id="tc-id_client_category">{$i18n->_('Category')}</th>
			<th class="tablesorter" id="tc-id_origin_branch">{$i18n->_('Origin Branch')}</th>
			<th class="tablesorter" id="tc-id_reported_branch">{$i18n->_('Reported Branch')}</th>
			<th class="tablesorter" id="tc-id_user">{$i18n->_('Register By')}</th>
			<th>{$i18n->_('Assigned to')}</th>
			<th>{$i18n->_('Cost')}</th>
			<th class="tablesorter" id="tc-status">{$i18n->_('Status')}</th>
			<th colspan="2">{$i18n->_('Actions')}</th>
		</tr>		
	</tfoot>
	{/if}	
	<tbody>
		{foreach $tickets as $ticket}
		<tr>
			<td>{$ticket['id_ticket_client']}</td>			
			<td>
				{if $ticket['folio']|trim != null && $ticket['folio']|trim != ""}
					{$ticket['folio']}
				{else}
				 	<span style="color:#152d5e;font-weight:bold;">{$ticket['folio_prev']}</span>		
				{/if}
			</td>
			<td>{$ticket['created']|date_format:"%d-%m-%Y"}</td>
			<td>{$ticket['expiration_date']|date_format:"%d-%m-%Y"}</td>
			<td>{$ticket['client_number']}</td>
			<td>{$ticket['account_number']}</td>
			<td>{$products[$ticket['id_product']]}</td>
			<td>{$ticket['ticket_type']}</td>
			<td>{$ticket['channel']}</td>
			<td>{$ticket['category']}</td>
			<td>{$ticket['origin_branch']}</td>
			<td>{$ticket['reported_branch']}</td>
			<td>{$ticket['register_by']}</td>
			<td>{$ticket['assigned_to']}</td>
			<td>{$tAmounts[$ticket['id_ticket_client']]|string_format:"%.2f"}</td>
			<td>{$i18n->_($ticket['status'])}</td>		
			<td>{if "ticket-client/edit"|isAllowed}
				<a href="{url action=edit id=$ticket['id_ticket_client']}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}{/if}</a>
			</td>
            <td>{if "ticket-client/tracking"|isAllowed}
            	<a href="{url action=tracking id=$ticket['id_ticket_client']}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}{/if}</a>
            </td>
		</tr>
		{/foreach}
	</tbody>
</table>
{include file='layout/Pager.tpl' paginator=$paginator}
</div>
