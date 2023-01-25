<!-- <style>
.table-fixed thead {
  width: 97%;
}
.table-fixed tbody {
  height: 230px;
  width:100%;
  overflow-y: auto;
  overflow-x: scroll;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td, .table-fixed thead > tr> th {
  float: left;
  border-bottom-width: 0;
}
</style> -->
<script type="text/javascript" src="{$baseUrl}/js/modules/ticket-client/tableSorter.js"></script>
<form id="elementsForm" method="post" >
    <input type="hidden" value="{$urlpaginador}" id="urlpag" name="urlpag">
    <input type="hidden" value="{$idregs}"        name="idregs" id="idregs" >
	<input type="hidden" value="{$total}" name="total"  id="total" >
	<input type="hidden" value="{$page}"  name="page" 	id="page" >
    <input type="hidden" name="ordenP" id="ordenP" value="{$params['orden']}">	
	<input type="hidden" name="headP" id="headP" value="{$params['head']}">
    
{if $total > 0}    
        <table class="tablesorter table table-fixed" id="myTableAjax">           
		 	<thead>
				<tr style="background-color: #152d5e;color: #fff;text-align:center;">
					<th class="head" id="Tconsec" style="cursor:pointer;">{$i18n->_('#')}</th>
					<th class="head" id="Tfolio">{$i18n->_('Folio')}</th>
					<th class="head" id="Tdassign">{$i18n->_('Date of assignment')}</th>
					<th class="head" id="Texpiration">{$i18n->_('Date of expiration')}</th>
					<th class="head" id="Tnumber">{$i18n->_('Client Number')}</th>
					<th class="head" id="Taccount">{$i18n->_('Account Number')}</th>
					<th class="head" id="Tproduct">{$i18n->_('Product')}</th>
					<th class="head" id="Ttype">{$i18n->_('Type')}</th>
					<th class="head" id="Tchannel">{$i18n->_('Channel')}</th>
					<th class="head" id="Tcategory">{$i18n->_('Category')}</th>
					<th class="head" id="Tobranch">{$i18n->_('Origin Branch')}</th>
					<th class="head" id="Trbranch">{$i18n->_('Reported Branch')}</th>
					<th class="head" id="Tregister">{$i18n->_('Register By')}</th>
					<th class="head" id="TassTo">{$i18n->_('Assigned to')}</th>
					<th class="head" id="Tcost">{$i18n->_('Cost')}</th>
					<th class="head" id="Tstatus">{$i18n->_('Status')}</th>
					<th class="head" id="acciones" colspan="2">{$i18n->_('Actions')}</th>
				</tr>
			</thead>
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
				<td>{$ticket['created']|date_format:"%Y-%m-%d"}</td>
				<td>{$ticket['expiration_date']|date_format:"%Y-%m-%d %H:%M"}</td>
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
				<td>
					{if "ticket-client/edit"|isAllowed}
						<a href="{url action=edit id=$ticket['id_ticket_client']}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>
					{/if}
				</td>
            	<td>
					{if "ticket-client/tracking"|isAllowed}
            			<a href="{url action=tracking id=$ticket['id_ticket_client']}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>
					{/if}
            </td>				
			</tr>
			{/foreach}
            </tbody>
        </table>      
        {include file='layout/Pager.tpl' paginator=$paginator}
{else}
    <br><br><center><p style="font-size:14px;font-weight:bold;">No se encuentran resultados</p></center><br><br> 
{/if}            
</form>