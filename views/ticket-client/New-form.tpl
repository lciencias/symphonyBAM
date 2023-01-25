<!-- fin de tablesorter -->
<form id="getClientInformationForm" action="" method = "post">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <input type="hidden" name="pcorrectas" id="pcorrectas" value="0" />
    <input type="hidden" name="icorrectas" id="icorrectas" value="0" />
    <input type="hidden" name="npreguntas" id="npreguntas" value="" />
    <input type="hidden" name="accountTmp" id="accountTmp" value="" />
    <input type="hidden" name="branchUser" id="branchUser" value="{$branchUser}" />
    <input type="hidden" name="canalUser" id="canalUser" value="{$canalUser}" />
    <input type="hidden" name="idsTransacciones" id="idsTransacciones" value="">
	<input type="hidden" name="orden" id="orden" value="{$params['orden']}">	
	<input type="hidden" name="head" id="head" value="{$params['head']}">
    
    {if "ticket-client/question"|isAllowed}
	    <input type="hidden" name="permisoPreguntas" id="permisoPreguntas" value="1">
    {else}
    	<input type="hidden" name="permisoPreguntas" id="permisoPreguntas" value="0">
    {/if}       
    <table>
        <tbody class="actions">
            <tr style="background-color:#fff;">
                <td><input type="button"  class="btn large success" name="notClient" id="notClient" value="{$i18n->_('Is not customer')}"></td>
                <td colspan="7"></td>
            </tr>
            <tr style="background-color:#fff;">
                <td>{$i18n->_('Account Number')}</td>
                <td><input type="text" name="account" id="account" value="{$post['account']}" class="span3"/></td>
                <td>{$i18n->_('Client Number')}</td>
                <td><input type="text" name="clientNumber" id="clientNumber" value="{$post['clientNumber']}" class="span3"/></td>
                <td>{$i18n->_('RFC')}</td>
                <td><input type="text" name="rfc" id="rfc" value="{$post['employee_fullname']}" class="span3"/></td>
                <td width="10%" style="vertical-align: middle;">
                <input type="button" id="search" class="btn primary live" value="{$i18n->_('Filter')}" />
                </td>                
                <td width="5%" style="border:0px solid #FFFFFF;">
                	{if $params['findBD'] != 1}
                		<a href="#" id="control"><img id="imgControl" src="{$baseUrl}/images/template/plugins/tablesorter/down.jpg" width="25" height="25"></a>
                	{else}
                		<a href="#" id="control"><img id="imgControl" src="{$baseUrl}/images/template/plugins/tablesorter/up.jpg" width="25" height="25"></a>
                	{/if}
                	<input type="hidden" id="controlVal" value="0">
                </td>                
			</tr>
			<tr style="background-color:#e5e5e5;">
                <td>{$i18n->_('Name')}</td>
                <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3"/></td>
                <td>{$i18n->_('Last name')}</td>
                <td><input type="text" name="last_name" id="last_name" value="{$post['last_name']}" class="span3"/></td>                
                <td>{$i18n->_('Middle Name')}</td>
                <td><input type="text" name="middle_name" id="middle_name" value="{$post['middle_name']}" class="span3"/></td>
                <td width="10%" style="vertical-align: middle;">
                	<input type="button" id="clear" class="btn primary" value="{$i18n->_('Clear')}" />
                </td>
                <td width="5%" >&nbsp;</td>
            </tr>
           </tbody>
        </table>
		<table class="table masfiltros" >
			<tbody>            
            	<tr style="background-color:#fff;"> 
	            	<td>{$i18n->_('Folio')}</td>
    	            <td><input type="text" name="folio" id="folio" value="{$params['folio']}" class="span3"/></td>            
        	        <td>{$i18n->_('Type')}</td>
            	    <td>{html_options name=id_ticket_type id=id_ticket_type options=$ticketTypes selected=$params['id_ticket_type'] class=span3}</td>
                	<td>{$i18n->_('Status')}</td>
                	<td>{html_options name=status id=status options=$statuses selected=$params['status'] class=span3}</td>
	            	<td>{$i18n->_('Channel')}</td>
                	<td>{html_options name=id_channel id=id_channel options=$channels selected=$params['id_channel'] class=span3}</td>
                	<td>{$i18n->_('Category')}</td>
                	<td>{html_options options=$clientCategories name="id_client_category" id="id_client_category" selected=$params['id_client_category'] class="span3"}</td>
	            </tr>
    	        <tr style="background-color:#e5e5e5;">
            	<td>{$i18n->_('Origin Branch')}</td>
                <td>{html_options options=$branches name="id_origin_branch" id="id_origin_branch" selected=$params['id_origin_branch'] class="span3"}</td>
                <td>{$i18n->_('Reported Branch')}</td>
                <td>{html_options options=$branches name="id_reported_branch" id="id_reported_branch" selected=$params['id_reported_branch'] class="span3"}</td>
            	<td>{$i18n->_('Registered by')}</td>
                <td>{html_options name=id_user id=id_user options=$users  class=span3}</td>
                <td>{$i18n->_('Assigned to')}</td>
                <td>{html_options name=id_user_assigned id=id_user_assigned options=$users selected=$params['id_user_assigned'] class=span3}</td>
                <td colspan="2">
                <input type="hidden" name="findBD" id="findBD" value="{$params['findBD']}">
                <input type="submit" id="searchBD" class="btn primary" value="{$i18n->_('Search in database')}" /></td>
	            </tr>            
    	    </tbody>
	    </table>
</form>
<div id="errorWsContainer" style="text-align : center; display : none"><h4 id="message"></h4></div>
<div id="clientInformationContainer"></div>
<div id="resultsInformationContainer" class="fixedHeaderTable" style="overflow-y: auto;overflow-x: auto; background-color: #fff;width: 100%;height:auto;">
	<table class="tablesorter tablesorter-bootstrap table-fixed;" id="myTable">
 	<thead>
			<tr>
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
		<tbody id="tbodyId">
			{foreach $tickets as $ticket}
				{if $color[$ticket['id_ticket_client']] != ''}
					<tr style="background-color:{$color[$ticket['id_ticket_client']]};">
				{else}
					<tr>
				{/if}
				<td>{$ticket['id_ticket_client']}</td>
				<td>
				{if $ticket['folio']|trim != null && $ticket['folio']|trim != ""}
					{$ticket['folio']}
				{else}
				 <span style="color:#152d5e;font-weight:bold;">{$ticket['folio_prev']}</span>				
				{/if}
				</td>
				<td>{$ticket['created']|date_format:"%d-%m-%Y"}</td>
				{if $ticket['status'] != 'Read'}
					<td>{$ticket['expiration_date']|date_format:"%d-%m-%Y"}</td>
				{else}
					<td></td>
				{/if}
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

<div id="my-modal-new" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Partial Transaction Information')}</h3>
	</div>
	<div class="modal-body">
		<span style="text-align:center;color:#ff0000;" id="errorDeposit"></span>
		<input type="hidden" name="idInfTransaction" id="idInfTransaction" value="0">
		<input type="hidden" name="typeDeposit" id="typeDeposit" value="1">
		
		<table class="zebra-striped sinBorder masDatosTrans" id="tablaMasdatos" >
			<tr>
				<td width=25%">{$i18n->_("Amount claimed")}</td>
				<td>&nbsp;-&nbsp;<input type="text" name="amountDeposited" id="amountDeposited" value="" class="form-control numerico required"></td>
			</tr>
			<tr>
				<td width=25%">{$i18n->_("Date of operation")}</td>
				<td>&nbsp;&nbsp;&nbsp;<input type="text" name="dateDeposited" id="dateDeposited" value="{$params['dateDeposited']}" class="datepicker validDates span3 required"></td>
			</tr>
			<tr>
				<td width=25%">{$i18n->_("Attachment file")}</td>
				<td><input type="file" name="fileDeposited" id="fileDeposited" class="form-control required">
				&nbsp;<button id="descargarpartial" name="descargarpartial" target="_blank" class="btn btn-default" style="display:none;" value="0">{$i18n->_('Download')}</button></td>
			</tr>
		</table>
	</div>
	<div class="modal-footer">
		<button class="btn default" id="closeWindow" name="closeWindow">{$i18n->_('Close')}</button>
		&nbsp;&nbsp;
		<button class="btn success" id="saveDeposit" name="saveDeposit">{$i18n->_('Save')}</button>
	</div>
</div>