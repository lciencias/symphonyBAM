
<div id="clientInformationTable">
	<input type="hidden" name="clientDataJson"   id="clientDataJson"  value='{$clientDataJson}'>
	<input type="hidden" name="transactionsJson" id="transactionsJson" value='{$transactionsJson}'>
	<input type="hidden" name="documentsJson" id="documentsJson" value='{$documentsJson}'>
	<input type="hidden" name="resolutionsTypeJson" id="resolutionsTypeJson" value='{$clientResolutionsType}'>
	<input type="hidden" name="id_transaction" id="id_transaction" value='0'>
	<input type="hidden" name="id_transactionId" id="id_transactionId" value='0'>	
	<input type="hidden" name="fecha_transaction" id="fecha_transaction" value="">
	<table >
		<tr>
			<td><strong>{$i18n->_('Client Number')}</strong></td>
			<td>{$ticketClient['client_number']}</td>
			<td><strong>{$i18n->_('Account Number')}</strong></td>
			<td>{$ticketClient['account_number']}</td>
			<td><strong>{$i18n->_('Account type')}</strong></td>
			<td>{$ticketClient['account_type']}</td>
			<td><strong>{$i18n->_('Card number')}</strong></td>
			<td>{$ticketClient['no_card']}</td>					
		</tr>
		<tr>
			<td><strong>{$i18n->_('Name')}</strong></td>
			<td colspan="3">{$ticketClient['name_client']}</td>
			<td><strong>{$i18n->_('Product')}</strong></td>
			<td>{$products[$ticketClient['id_product']]}</td>
			<td>
			{if $ticketClient['folio_condusef']|trim != null && $ticketClient['folio_condusef']|trim != ''}
				<strong>{$i18n->_('Folio Condusef')}</strong>
			{/if}
			</td>					
			<td>
			{if $ticketClient['folio_condusef'] != ''}
				{$ticketClient['folio_condusef']}
			{/if}

			</td>					
		</tr>

		<tr>
			<td colspan="8"><h4>{$i18n->_('Ticket Summary')}</h4></td>
		</tr>
		<tr>
			<td><strong>{$i18n->_('Status:')}</strong></td>
			<td class="externalNumber">{$i18n->_($ticketClient['status'])}</td>
			<td><strong>{$i18n->_('Registered by:')}</strong></td>
			<td class="internalNumber">{$ticketClient['register_by']}</td>
			<td><strong>{$i18n->_('Register Date:')}</strong></td>
			<td class="state">{$ticketClient['created']|date_format:"%d-%m-%Y %H:%M:%S"}</td>
			<td><strong>{$i18n->_('Assigned User:')}</strong></td>
			<td class="town">{$ticketClient['assigned_to']}</td>
		</tr>
		<tr>
			<td colspan="8"><h4>{$i18n->_('Service level')}</h4></td>
		</tr>
		 <tr>
            <th>Tiempo de {$i18n->_("Service Level: ")}</th>
            <td class="tip" title="Tiempo de Respuesta: {$responseTime->toHuman()} Tiempo de Resoluci&oacute;n: {$resolutionTime->toHuman()}">{$serviceLevel->toHuman()}<br>({$serviceLevel->getDurationInHours()}hrs)</td>
        	<th>{$i18n->_("Time of Service: ")}</th>
            <td class="tip" title="Tiempo trabajado en horas en base al horario del grupo de trabajo ">{$timeOfService}<br></td>
        	<th>D&iacute;as h&aacute;biles</th>
            <td class="tip" title="N&uacute;mero de d&iacute;as laborales del grupo de trabajo transcurridos hasta la fecha actual o el cierre del ticket">{$elapsedDays->toHuman()}</td>
            <th>D&iacute;as naturales</th>
            <td class="tip" title="N&uacute;mero de d&iacute;as naturales transcurridos desde la creaci&oacute; del ticket hasta la fecha actual o el cierre del ticket">{$elapsedNaturalDays->toHuman()}</td>
            
        </tr>
        <tr>
            <th>{$i18n->_("Percentage of Service: ")}</th>
            <td>{$percentageOfService} %</td>
            <th>{$i18n->_("Expiration Date: ")}</th>
            <td>{$expirationDateS}</td>
            {if $timeToExpire->getSeconds() > 0}
            <th>{$i18n->_("Tiempo para que Expire: ")}</th>
            <td class="tip" title="Las horas totales de expiraci&oacute;n son {$timeToExpire->getDurationInHours()} y solo se toman en cuenta las horas del horario de trabajo del usuario asignado">{$timeToExpireS}</td>
          {else}
            <th>{$i18n->_("Expired Time: ")}</th>
            <td>{$expiredTime->toHuman()}</td>
          {/if}
          <td colspan="2"></td>
        </tr>
        </table><br>
        <table>
        {if $action != "edit"}
	        <tr>
	        	<td colspan="8"><h4>{$i18n->_('Customer Information')}</h4></td>
			</tr>
			<tr>
				<td><strong>{$i18n->_('Client Number:')}</strong></td>
				<td class="clientNumber">{$clientData['client_number']}</td>
				<td><strong>{$i18n->_('Name:')}</strong></td>
				<td class="name">{$clientData['name']}</td>
				<td><strong>{$i18n->_('RFC:')}</strong></td>
				<td class="rfc">{$clientData['rfc']}</td>
				<td><strong>{$i18n->_('Birthday:')}</strong></td>
				<td class="birthday">{$clientData['birthday']}</td>
			</tr>
			<tr>
				<td><strong>{$i18n->_('Home Phone:')}</strong></td>
				<td class="homePhone">{$clientData['home_phone']}</td>
				<td><strong>{$i18n->_('Office Phone:')}</strong></td>
				<td class="officePhone">{$clientData['office_phone']}</td>
				<td><strong>{$i18n->_('Mobile Phone:')}</strong></td>
				<td class="mobilePhone">{$clientData['mobile_phone']}</td>
				<td><strong>{$i18n->_('Street:')}</strong></td>
				<td class="street">{$clientData['street']}</td>
			</tr>
			<tr>
				<td><strong>{$i18n->_('External Number:')}</strong></td>
				<td class="externalNumber">{$clientData['external_number']}</td>
				<td><strong>{$i18n->_('Internal Number:')}</strong></td>
				<td class="internalNumber">{$clientData['internal_number']}</td>
				<td><strong>{$i18n->_('State:')}</strong></td>
				<td class="state">{$clientData['state']}</td>
				<td><strong>{$i18n->_('Town:')}</strong></td>
				<td class="town">{$clientData['town']}</td>
			</tr>
			<tr>
				<td><strong>{$i18n->_('Colony:')}</strong></td>
				<td class="colony">{$clientData['colony']}</td>
				<td><strong>{$i18n->_('Zip Code:')}</strong></td>
				<td class="zipCode">{$clientData['zip_code']}</td>
			</tr>
		{/if}
		{if $transactions|@count > 0}
				<tr>
					<td colspan="13"><h4>{$i18n->_('Customer Transaction Information')}</h4></td>
				</tr>
				<tr>
					<td colspan="2"><strong>{$i18n->_('Date and Time of Transaction')}</strong></td>
					<td colspan="2"><strong>{$i18n->_('Número de tarjeta')}</strong></td>
					<!--   <td colspan="2"><strong>{$i18n->_('ATM or Trade Name')}</strong></td>-->
					<td><strong>{$i18n->_('Amount in M.N.')}</strong></td>
					<td colspan="2"><strong>{$i18n->_('Reference')}</strong></td>
					<td colspan="2"><strong>{$i18n->_('Número de afiliación')}</strong></td>
					<td colspan="2"><strong>{$i18n->_('Type of Clasification')}</strong></td>
					<td colspan="2" align="center"><strong>{$i18n->_('Detail')}</strong></td>					
				</tr>
			{assign var=tipoAut value=0}
			{foreach $transactions as $tmp}
				<tr>
					<td colspan="2">{$tmp['transaction_date']|date_format:"%d-%m-%Y"}</td>
					<td colspan="2">{$no_card}</td>
					<td style="text-align:right;">{$tmp['amount']|number_format:2:".":","}</td>
					<td style="text-align:center;" colspan="2">
					{if $tmp['reference'] eq 'null'}
						N/A
					{else}
						{$tmp['reference']}
					{/if}
					</td>
					<td style="text-align:center;" colspan="2">
					{if $tmp['afiliation'] eq 'null'}
						N/A
					{else}
						{$tmp['afiliation']}
					{/if}
					</td>
					<td colspan="2">
						{if $typeTransactions[$tmp['type']] != ''}
							{$typeTransactions[$tmp['type']]}							
						{else}
							<span>{$i18n->_('Sin tipo')}</span>
						{/if}
					</td>
					<td>
						{if "ticket-client/view-button-more"|isAllowed}
						<button class="btn success transacciones" id="{$tmp['id_ticket_client_transaction']}|{$tmp['type']+0}|{$tmp['transaction_date']}|{$tmp['idT24']}|{$flagsGoodArray[$tmp['id_ticket_client_transaction']]}|{$flagsGoodFolioArray[$tmp['id_ticket_client_transaction']]}" name="{$tmp['id_ticket_client_transaction']}-{$tmp['type']+0}">{$i18n->_('More')}</button>
						{/if}
					</td>
					<td>
						{*if "ticket-client/view-button-more"|isAllowed*}
							<!--<button class="btn primary createAbonoBuenFe " id="{$tmp['id_ticket_client_transaction']}|{$tmp['type']+0}|{$tmp['transaction_date']}|{$tmp['idT24']}|{$flagsGoodArray[$tmp['id_ticket_client_transaction']]}" name="{$tmp['id_ticket_client_transaction']}-{$tmp['type']+0}">{$i18n->_('Payment')}</button>-->
						{*/IF*}
						{*if "ticket-client/good-faith-amount-request"|isAllowed*}
							<!--<button class="btn primary createAbonoFolioBuenFe " id="{$tmp['id_ticket_client_transaction']}|{$tmp['type']+0}|{$tmp['transaction_date']}|{$tmp['idT24']}|{$flagsGoodFolioArray[$tmp['id_ticket_client_transaction']]}" name="{$tmp['id_ticket_client_transaction']}-{$tmp['type']+0}">{$i18n->_('Folio')}</button>-->					
						{*/if*}
						
					</td>
				</tr>
			{/foreach}
		{/if}		
		{if $reopens|@count > 0}
			<tr>
				<td colspan="13"><h4>{$i18n->_('Payment in good faith')}</h4></td>
			</tr>
			{foreach $reopens as $tmp}
			<tr>
				<td colspan="2">{$i18n->_('Payment in good faith')}:</td>
				<td colspan="2">{$tmp['good_faith_amount']}</td>				
				<td colspan="2">{$i18n->_('Date of subscription')}:</td>
				<td colspan="2">{$tmp['good_faith_date']|date_format:"%d-%m-%Y"}</td>
				<td colspan="2">{$i18n->_('T24 Registration')}:</td>
				<td colspan="2">{$tmp['good_faith_payment']}</td>
				<td></td>
			</tr>
			{/foreach}			
		{/if}
		
		<tr>
			<td colspan="3" class="tdright"><span id="errorPrint"></span></td>
			<td colspan="10" class="tdright">
				{if "ticket-client/view-button-amortization"|isAllowed  && $mostrarAmortizacion eq 1}
					<button class="btn danger" id="amortizacion" name="amortizacion">{$i18n->_('See amortization table')}</button>&nbsp;&nbsp;
				{/if}
				{if "ticket-client/view-button-state-account"|isAllowed}
					{if $transactions|@count > 0}	
					<button class="btn danger" id="edoCuenta" name="edoCuenta">{$i18n->_('View Account Status')}</button>&nbsp;&nbsp;			
					{/if}
				{/if}
				<button class="btn primary" id="print" name="print">{$i18n->_('To print')}</button>
				&nbsp;&nbsp;
				<button class="btn success" id="sendMail" name="sendMail" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true" >{$i18n->_('Send format')}</button></td>
		</tr>
		
	</table>
</div>


{*Modal para solicitar el correo*}
<div id="my-modal" class="modal hide fade in" style="display: none;">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Confirm e-mail')}</h3>
	</div>
	<div class="modal-body">
		<p>{$i18n->_('Email')}:&nbsp;&nbsp;<input type="text" placeholder="Email" name="emailClient" id="emailClient" value="{$emailTicket}" class="xlarge required"/></p>
		<p><span id="validaEmail"></span></p>
	</div>
	<div class="modal-footer">
		<button class="btn default" id="closeWindow" name="closeWindow">{$i18n->_('Close')}</button>
		<button class="btn success" id="sendFormat" name="sendFormat">{$i18n->_('Send')}</button>
	</div>
</div>


{* Modal sin type 0*}
<div id="my-modal-0" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Sin Tipo')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks0" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home0',0,0);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks0" onclick="openCity(event, 'profile0',1,0);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks0 partialTmp0" style="display:none;" onclick="openCity(event, 'partition0',2,0);"><strong>{$i18n->_('Partitions')}</strong></a></li>
		</ul>
		<div class="pill-content">
			<div class="active tabcontent0" id="home0">
			 {include file="ticket-client/new-tabs/SinTipo.tpl"}
			</div>
			<div class="tabcontent0" id="profile0">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="0"}
			</div>
			<div class="tabcontent0" id="partition0">
			{include file="ticket-client/new-tabs/Partitions.tpl" tab="0"}
			</div>
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow0" name="closeWindow0">{$i18n->_('Close')}</button>
		<!-- <button class="btn success saveInformation" id="saveInformation-0" name="saveInformation-0">{$i18n->_('Save')}</button> -->
		<button class="btn info verLog" style="display:none;"; id="verLog-0" name="verLog-0">{$i18n->_('See Log')}</button>
	</div>
</div>

{* fin modal sin type*}

{* Modal para type 1*}
<div id="my-modal-1" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3><span id="tit">{$i18n->_('ATM')}</span></h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks1" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'profile1',0,1);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks1" style="background-color:#57a957;color:#fff;"  onclick="openCity(event, 'messages1',1,1);"><strong>{$i18n->_('Detail of the transaction')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks1 partialTmp1" style="display:none;" onclick="openCity(event, 'partition1',2,1);"><strong>{$i18n->_('Partitions')}</strong></a></li>
		</ul>
		<div class="pill-content">
			<div id="profile1" class="active tabcontent1">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="1"}
			</div>
			<div id="messages1" class="tabcontent1">
				<table class="bordered-table">					
					<tbody>
						<tr>
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Status')}:</td>
							<td width="25%" class="status"></td>							
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Reverso')}:</td>
							<td width="25%" class="reverso"></td>
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Motivo rechazo')}:</td>
							<td class="motivoRech"></td>
							<td style="background-color:#eeeeee;">{$i18n->_('Monto reverso')}:</td>
							<td class="montoRech"></td>
						</tr>
						<tr>
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Sobrante')}:</td>
							<td width="25%" class="sobrante"></td>
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Caseta de rechazo')}:</td>
							<td width="25%" class="caseta"></td>
						</tr>
						<tr>
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Monto Entregado')}:</td>
							<td width="25%" class="montoEntregado"></td>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('50')}:</td>
							<td class="billetes50"></td>						
							<td style="background-color:#eeeeee;">{$i18n->_('100')}:</td>
							<td class="billetes100"></td>
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('200')}:</td>
							<td class="billetes200"></td>						
							<td style="background-color:#eeeeee;">{$i18n->_('500')}:</td>
							<td class="billetes500"></td>
						</tr>
						
					</tbody>
				</table>
			</div>
			<div class="tabcontent1" id="partition1">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="1"}
			</div>			
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>						
		<button class="btn success saveInformation" id="saveInformation-1" name="saveInformation-1">{$i18n->_('Save')}</button>
		<button class="btn info verLog"  id="verLog-1" name="verLog-1">{$i18n->_('See Log')}</button>
	</div>
</div>
{*Fin del modal 1*}
{* ******************************************************************************************** *}
{* Modal para type 2*}
<div id="my-modal-2" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Transferencia SPEI')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks2" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home2',0,2);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks2" onclick="openCity(event, 'profile2',1,2);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks2 partialTmp2" style="display:none;" onclick="openCity(event, 'partition2',2,2);"><strong>{$i18n->_('Partitions')}</strong></a></li>
		</ul>
		<div class="pill-content">
			<div class="active tabcontent2" id="home2">
			 {include file="ticket-client/new-tabs/Spei.tpl"}
			</div>
			<div class="tabcontent2" id="profile2">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="2"}
			</div>
			<div class="tabcontent2" id="partition2">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="2"}
			</div>			
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-2" name="saveInformation-2">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 2*}
{* ******************************************************************************************** *}
{* Modal para type 3*}
<div id="my-modal-3" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Transferencia Cuentas Internas')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks3" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home3',0,3);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks3" onclick="openCity(event, 'profile3',1,3);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks3 partialTmp3" style="display:none;" onclick="openCity(event, 'partition3',2,3);"><strong>{$i18n->_('Partitions')}</strong></a></li>  			
		</ul>
		<div class="pill-content">
			<div class="active tabcontent3" id="home3">
			 {include file="ticket-client/new-tabs/Deposito.tpl"}
			</div>
			<div class="tabcontent3" id="profile3">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="3"}
			</div>
			<div class="tabcontent3" id="partition3">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="3"}
			</div>			
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-3" name="saveInformation-3">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 3*}
{* ******************************************************************************************** *}
{* Modal para type 4*}
<div id="my-modal-4" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Pago Interbancario Tarjeta de Crédito')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks4" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home4',0,4);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks4" onclick="openCity(event, 'profile4',1,4);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks4 partialTmp4" style="display:none;" onclick="openCity(event, 'partition4',2,4);"><strong>{$i18n->_('Partitions')}</strong></a></li>
		</ul>
		<div class="pill-content">
			<div class="active tabcontent4" id="home4">
			 {include file="ticket-client/new-tabs/Interbancario.tpl"}
			</div>
			<div class="tabcontent4" id="profile4">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="4"}
			</div>
			<div class="tabcontent4" id="partition4">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="4"}
			</div>						
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-4" name="saveInformation-4">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 4*}
{* ******************************************************************************************** *}
{* Modal para type 5*}
<div id="my-modal-5" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Pago de Servicios')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks5" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home5',0,5);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks5" onclick="openCity(event, 'profile5',1,5);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks5 partialTmp5" style="display:none;" onclick="openCity(event, 'partition5',2,5);"><strong>{$i18n->_('Partitions')}</strong></a></li>  			
		</ul>
		<div class="pill-content">
			<div class="active tabcontent5" id="home5">
			 {include file="ticket-client/new-tabs/Servicios.tpl"}
			</div>
			<div class="tabcontent5" id="profile5">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="5"}
			</div>
			<div class="tabcontent5" id="partition5">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="5"}
			</div>					
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-5" name="saveInformation-5">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 5*}
{* ******************************************************************************************** *}
{* Modal para type 6*}
<div id="my-modal-6" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Depósito de Cheque')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks6" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home6',0,6);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks6" onclick="openCity(event, 'profile6',1,6);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks6 partialTmp6" style="display:none;" onclick="openCity(event, 'partition6',2,6);"><strong>{$i18n->_('Partitions')}</strong></a></li>  			
		</ul>
		<div class="pill-content">
			<div class="active tabcontent6" id="home6">
			 {include file="ticket-client/new-tabs/PagoCheque.tpl"}
			</div>
			<div class="tabcontent6" id="profile6">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="6"}
			</div>
			<div class="tabcontent6" id="partition6">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="6"}
			</div>						
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-6" name="saveInformation-6">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 6*}
{* ******************************************************************************************** *}
{* Modal para type 7*}
<div id="my-modal-7" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Pago de Cheque')}</h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks7" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home7',0,7);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks7" onclick="openCity(event, 'profile7',1,7);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks7 partialTmp7" style="display:none;" onclick="openCity(event, 'partition7',2,7);"><strong>{$i18n->_('Partitions')}</strong></a></li>  			
		</ul>
		<div class="pill-content">
			<div class="active tabcontent7" id="home7">			
			 {include file="ticket-client/new-tabs/DepositoCheque.tpl"}
			</div>
			<div class="tabcontent7" id="profile7">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="7"}
			</div>
			<div class="tabcontent7" id="partition7">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="7"}
			</div>						
		</div>		
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<button class="btn success saveInformation" id="saveInformation-7" name="saveInformation-7">{$i18n->_('Save')}</button>
	</div>
</div>
{*Fin del modal 7*}
{* ******************************************************************************************** *}
{* Modal para type 8*}
<div id="my-modal-8" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3><span id="tit">{$i18n->_('Movimientos con Tarjeta de Débito')}</span></h3>
	</div>
	<div class="modal-body">
		 <ul class="tabs" data-tabs="tabs" >
  			<li class="active"><a href="javascript:void(0)" class="tablinks8" style="background-color:#57a957;color:#fff;" onclick="openCity(event, 'home',0,8);"><strong>{$i18n->_('Transaction Information')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks8" onclick="openCity(event, 'profile',1,8);"><strong>{$i18n->_('Payment in good faith')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks8" onclick="openCity(event, 'messages',2,8);"><strong>{$i18n->_('Controversy')}</strong></a></li>
  			<li><a href="javascript:void(0)" class="tablinks8" onclick="openCity(event, 'settings',3,8);"><strong>{$i18n->_('Request to pay')}</strong></a></li>
			<li><a href="javascript:void(0)" class="tablinks8 partialTmp8" style="display:none;" onclick="openCity(event, 'partition8',4,8);"><strong>{$i18n->_('Partitions')}</strong></a></li>  			  		
		</ul>
		<div class="pill-content">
			<div class="active tabcontent8" id="home">
				{include file="ticket-client/new-tabs/Information.tpl"}
			</div>
			<div id="profile" class="tabcontent8">
				{include file="ticket-client/new-tabs/Amount.tpl" tab="8"}
			</div>
			<div id="messages" class="tabcontent8">
				<table class="bordered-table">					
					<tbody>
						<tr>
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Reason code')}:</td>							
								{if "ticket-client/view-module-controversy"|isAllowed}
									<td width="25%" >{html_options options=$ControlReasons name=id_controversy_reason id=id_controversy_reason class="span4 required" selected=$ticketClient['id_controversy_reason']}</td>
								{else}
								<td width="25%" class="controversy_reason"></td>
								{/if}
							</td>							
							<td width="25%" style="background-color:#eeeeee;">{$i18n->_('Direct charge')}:</td>
							{if "ticket-client/view-module-controversy"|isAllowed}
							<td width="25%" class="">
								{html_options options=$chargeBackD name=id_controversy_chargeback_d id=id_controversy_chargeback_d class="span4 required" selected=$params['id_controversy_chargeback_d']}
							</td>
							{else}
							<td class="controversy_chargeback_d"></td>
							{/if}
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Type of reason')}:</td>
							{if "ticket-client/view-module-controversy"|isAllowed}
							<td class="">
								<input type="text" name="type" id="type" value="{$params['type']}" class="form-control required" readonly="true" maxlength="99" />								
							</td>
							{else}
							<td class="type"></td>
							{/if}
							<td style="background-color:#eeeeee;">{$i18n->_('Trad charge')}:</td>
							{if "ticket-client/view-module-controversy"|isAllowed}
							<td class="">
								{html_options options=$chargeBackT name=id_controversy_chargeback_t id=id_controversy_chargeback_t class="span4 required" selected=$params['id_controversy_chargeback_t']}
							</td>
							{else}
							<td class="controversy_chargeback_t"></td>
							{/if}
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Debit time')}:</td>
							{if "ticket-client/view-module-controversy"|isAllowed}
							<td>
								<input type="text" name="debit_time" id="debit_time" value="{$params['debit_time']}" class="form-control required" readonly="true" maxlength="149" />
							</td>
							{else}
							<td class="debit_time"></td>
							{/if}
							<td colspan="2" style="background-color:#fff;color:#ff0000" id="errorControversia">&nbsp;</td>
						</tr>
						<tr>
						<td colspan="4"><br /><br />
						 <ul class="tabs" data-tabs="tabs" >
					  			<li class="active"><a href="javascript:void(0)" class="tablinksm" style="background-color:#57a957;color:#fff;" onclick="openCity2(event, 'condiciones',0);"><strong>{$i18n->_('Terms')}</strong></a></li>
  								<li><a href="javascript:void(0)" class="tablinksm" onclick="openCity2(event, 'documentos',1);"><strong>{$i18n->_('Supporting documents')}</strong></a></li>
  								<li><a href="javascript:void(0)" class="tablinksm" onclick="openCity2(event, 'representacion',2);"><strong>{$i18n->_('Conditions for representation')}</strong></a></li>
						</ul>
						<div class="pill-content">
							<div class="active tabcontentm" id="condiciones">{$i18n->_('Terms')}</div>
							<div class="tabcontentm" id="documentos">{$i18n->_('Documents')}</div>
							<div class="tabcontentm" id="representacion">{$i18n->_('Representation')}</div>
						</div>
						</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="settings" class="tabcontent8">
				<table class="bordered-table">
					<tbody>
					{if "ticket-client/view-module-payment"|isAllowed}
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Application date')}:</td>
							<td class=""><input type="text" name="payment_request_date" id="payment_request_date" value="{$params['payment_request_date']}" class="datepicker validDates span3 required" readonly="true" maxlength="10" /></td>
							<td style="background-color:#eeeeee;">{$i18n->_('Delivery Payment')}:</td>
							<td class=""><select name="accepted_payment" id="accepted_payment" class="span4 required"><option value="">Seleccione</option><option value="1">Si</option><option value="0">No</option></select></td>
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Deadline')}:</td>
							<td class=""><input type="text" name="payment_delivery_date" id="payment_delivery_date" value="{$params['payment_delivery_date']}" class="datepicker validDates span3 required" readonly="true"  maxlength="10" /></td>
							<td style="background-color:#eeeeee;">{$i18n->_('Accepted Payment')}:</td>
							<td class=""><select name="delivery_payment" id="delivery_payment" class="span4 required"><option value="">Seleccione</option><option value="1">Si</option><option value="0">No</option></select></td>
						</tr>
						<tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Upload Payment')}:</td>
							<td class=""><input type="file" name="file_payment" id="file_payment" value="{$params['file_payment']}" class="form-control required"/></td>
							<td colspan="2"><span class="download8"></span></td>
						</tr>						
						{else}
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Application date')}:</td>
							<td class="payment_request_date"></td>
							<td style="background-color:#eeeeee;">{$i18n->_('Delivery Payment')}:</td>
							<td class="accepted_payment"></td>
						</tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Deadline')}:</td>
							<td class="payment_delivery_date"></td>
							<td style="background-color:#eeeeee;">{$i18n->_('Accepted Payment')}:</td>
							<td class="delivery_payment"></td>
						</tr>
						<tr>
						<tr>
							<td style="background-color:#eeeeee;">{$i18n->_('Pagare')}:</td>
							<td class="file_payment" id="#file_payment"></td>
							<td colspan="2"><span class="download8"></span></td>
						</tr>												
						{/if}
					</tbody>
				</table>
			</div>
			<div class="tabcontent8" id="partition8">
				{include file="ticket-client/new-tabs/Partitions.tpl" tab="8"}
			</div>			
		</div>	
	</div>	
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>						
		<button class="btn success saveInformation"  id="saveInformation-8" name="saveInformation-8">{$i18n->_('Save')}</button>
		<button class="btn info verLog"  id="verLog-8" name="verLog-8">{$i18n->_('See Log')}</button>
	</div>
</div>
{*Fin del modal 8*}


{* Modal para abono*}
<div id="my-modal-abono" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Payment in good faith')}</h3>
	</div>
	<div class="modal-body">	
		<input type="hidden" name="idTransactionPayment" id="idTransactionPayment" value="0">
		<input type="hidden" name="idPermisoPayment" id="idPermisoPayment" value="0">
		<b><span id="nmTransaction"></span></b><br>
		{include file="ticket-client/new-tabs/Amount.tpl" tab="8"}	
	</div>
	<div class="modal-footer">
		<span class="errorDeposit"></span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		<!--<button class="btn success saveInformation" id="saveInformation-3" name="saveInformation-3">{$i18n->_('Save')}</button>-->
	</div>
</div>
{*Fin del modal abono*}


{*Modal para ver log*}
<div id="my-modal-log" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" id="closeLog" href="#">×</a>
		<h3>{$i18n->_('Log')}</h3>
	</div>
	<div class="modal-body">
		<input type="hidden" id="noTab" name="noTab" value="">
		<div id="tableLog"></div>		
	</div>
	<div class="modal-footer">
		<button class="btn default closeLog" id="closelog" name="closelog">{$i18n->_('Close')}</button>
	</div>
</div>

{*fin de ver log*}


{* **modal numero de cuenta* *}
<div id="my-modal-cuenta" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Account status')}</h3>
	</div>
	<div class="modal-body">
		<table style="width=100%;border:0px;">
			<tr>
				<td width="50%">
					<table class="table">
						<tr class="tituloedoCuenta"><td colspan="2">{$i18n->_('Consultation period')}</td></tr>
						<tr>
							<td>{$i18n->_('Period')}</td>
							<td>{html_options options=$periods name="period_edo" id="period_edo" selected=$params['period'] class="span4"}</td>
						</tr>
						<tr>
							<td>{$i18n->_('From')}</td>
							<td><input type="text" name="start_date_edo" id="start_date_edo" value="{$params['start_date_edo']}" class="datepicker validDates span3"/></td>
						</tr>
						<tr>
							<td>{$i18n->_('Until')}</td>
							<td><input type="text" name="end_date_edo" id="end_date_edo" value="{$params['end_date_edo']}" class="datepicker validDates span3"/></td>
						</tr>
					</table>
				</td>
				<td width="50%">
					<table class="table bordered">
						<tr class="tituloedoCuenta"><td colspan="2">{$i18n->_('Statement Information')}</td></tr>
						<tr><td colspan="2" id="resultados"></td></tr>
					</table>
				</td>
			</tr>
		</table>
	</div>	
	<div class="modal-footer">
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>
		&nbsp;&nbsp;
		<button class="btn success" name="bottonEdoCuenta" id="bottonEdoCuenta">{$i18n->_('Search for motions')}</button>						
	</div>
</div>


{* fin modal amortizacion *}
{* **modal numero de amortizacion* *}
<div id="my-modal-amortizacion" class="modal hide fade in" style="display: none;width:80%;height:auto;left:400px;">
	<div class="modal-header" style="background-color:#E5E5E;">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Amortization')}</h3>
	</div>
	<div class="modal-body" id="cuerpo">
	</div>	
	<div class="modal-footer">
		<button class="btn default closeWindows" id="closeWindow8" name="closeWindow8">{$i18n->_('Close')}</button>						
	</div>
</div>
{* fin modal amortizacion *}


<div id="my-modal-reopen" class="modal hide fade in" style="display: none;width:60%;height:auto;left:500px;">
	<div class="modal-header">
		<a class="close" href="#">×</a>
		<h3>{$i18n->_('Reopen')}</h3>
	</div>
	<div class="modal-body">
		<table class="bordered-table">
			<tbody>
				<tr>					
					<td width="30%">{$i18n->_('Channel')}:</td>
					<td width="70%">
	    	         	{html_options options=$channelReopen name="idChannelT" id="idChannelT" class="span4 required" selected=$userChannel}	
						<span id="rChannel"></span>
					</td>
				</tr>
				<tr>
					<td class="reng3Condusef" width="30%">{$i18n->_('Folio Condusef')}:</td>
					<td class="reng3Condusef" width="70%"><input type="text" placeholder="Folio Condusef" name="folioCondusefT" id="folioCondusefT" value="" class="xlarge required alfanumerico"/>
						<span id="rfolioCondusef"></span>
					</td>
				</tr>
			</tbody>
		</table>		
	</div>	
	<div class="modal-footer">
		<button class="btn default" id="closeWindowf" name="closeWindowf">{$i18n->_('Close')}</button>
		<button class="btn success" id="sendFolioCondusef" name="sendFolioCondusef">{$i18n->_('Save')}</button>
	</div>
</div>
