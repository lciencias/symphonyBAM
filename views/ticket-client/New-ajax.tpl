<div id="botonRegresar" style="display:none;position:absolute !important; right:0px; top:135px; z-index:100000 !important;">
<button class="btn danger large" id="cancel2" name="cancel2">{$i18n->_('Regresar Inicio')}</button>
</div>
<div id="clientInformationTable" style="display : none">
	<!-- <div >{$i18n->_('Client Information')}</div><br> -->	
	<table style="width:35%;border:1px solid #fff;" class="tdleft sinBorder">
		<tr><td class="encabezado" colspan="2">{$i18n->_('Client Information')}</td></tr>
		<tr>
			<td><strong>{$i18n->_('Name')}</strong></td>
			<td class="name"></td>		
		</tr>
		<tr>
			<td><strong>{$i18n->_('Client Number')}</strong></td>
			<td class="clientNumber"></td>		
		</tr>
		</table>
		<span id="titutlo"><center><h4>{$i18n->_('Validation Client')}</h4></center></span>
		<table width="100%" id="que" class="sinBorder" >
		<tr class="sinBorder">
			<td class="tdcenter" width="40%">&nbsp;</td>
			<td class="tdcenter">
			<table width="100%">
				<tr class="sinBorder">
					<td class="cuadro tdcenter" id="c-1">&nbsp;&nbsp;</td>
					<td class="tdcenter">&nbsp;</td>
					<td class="cuadro tdcenter" id="c-2">&nbsp;&nbsp;</td>
					<td class="tdcenter">&nbsp;</td>
					<td class="cuadro tdcenter" id="c-3">&nbsp;&nbsp;</td>
					<td class="tdcenter">&nbsp;</td>
					<td class="cuadro tdcenter" id="c-4">&nbsp;&nbsp;</td>
					<td class="tdcenter">&nbsp;</td>
					<td class="cuadro tdcenter" id="c-5">&nbsp;&nbsp;</td>
				</tr>
			</table>
			</td>
			<td class="tdcenter" width="40%" >&nbsp;</td>
		</tr>
		<tr class="sinBorder">
			<td colspan="2" class="tdright" id="preguntas"></td>
			<td class="tdcenter" width="40%">
				<button name="correcto"   id="correcto"    class="btn large success">{$i18n->_('Correct')}</button>
				&nbsp;
				<button name="incorrecto" id="incorrecto"  class="btn large danger">{$i18n->_('Wrong')}</button>	
				&nbsp;
				<!--  <button name="cancel" id="cancel"  class="btn large default">{$i18n->_('Cancel')}</button>-->
			</td>
		</tr>
	</table>	
</div>
{***********ENCABEZADO PARA CUANDO NO SELECCIONEN PREGUNTAS ***************}
<div id="clientInformationTableSP" style="display : none">
	<!-- <div >{$i18n->_('Client Information')}</div><br> -->	
	<table style="width:35%;border:1px solid #fff;" class="tdleft sinBorder">
		<tr><td class="encabezado" colspan="2">{$i18n->_('Client Information')}</td></tr>
		<tr>
			<td><strong>{$i18n->_('Name')}</strong></td>
			<td class="name"></td>		
		</tr>
		<tr>
			<td><strong>{$i18n->_('Client Number')}</strong></td>
			<td class="clientNumber"></td>		
		</tr>
	</table>
</div>


{*TABLA QUE AGRUPA A TODOS LOS CLIENTES*}
<table id="compactClientsTable" class="zebra-striped table" style="display : none">
	<tr id="compactClientsRow" style="display : none">
		<td><strong>{$i18n->_('Client Number')}</strong></td>
		<td class="clientNumber"></td>
		<td><strong>{$i18n->_('Name')}</strong></td>
		<td class="name"></td>
		<td><a class="btn showAccountsBotton">{$i18n->_('New Ticket')}</a></td>
	</tr>
</table>


{*BOTON PARA CARGAR LA LAS CUENTAS DE LOS CLIENTES*}
<table id="InformationClientTable" style="width:70%;border:1px solid #fff;display : none;" class="tdleft sinBorder" >
	<tr>
		<td width="100%" class="encabezado" colspan="4">{$i18n->_('Client Information')}</td>
	</tr>
	<tr>
		<td width="25%"><strong>{$i18n->_('Name')}</strong></td>
		<td width="75%" class="name" colspan="3"></td>			
	</tr>
	<tr>
		<td width="25%"><strong>{$i18n->_('Client Number')}</strong></td>
		<td width="75%" class="clientNumber" colspan="3"></td>
			
	</tr>
	<tr>
	<td width="25%"></td>
	<td width="50%" colspan="2" class="tdcenter">
		<table width="40%">
			<tr class="sinBorder">
				<td style="width:16px;heigth:16px;border:2px solid #000;" id="r-1">&nbsp;&nbsp;</td>
				<td style="width:16px;heigth:16px;border:0px solid #FFF;">&nbsp;</td>
				<td style="width:16px;heigth:16px;border:2px solid #000;" id="r-2">&nbsp;&nbsp;</td>
				<td style="width:16px;heigth:16px;border:0px solid #FFF;">&nbsp;</td>
				<td style="width:16px;heigth:16px;border:2px solid #000;" id="r-3">&nbsp;&nbsp;</td>
				<td style="width:16px;heigth:16px;border:0px solid #FFF;">&nbsp;</td>
				<td style="width:16px;heigth:16px;border:2px solid #000;" id="r-4">&nbsp;&nbsp;</td>
				<td style="width:16px;heigth:16px;border:0px solid #FFF;">&nbsp;</td>
				<td style="width:16px;heigth:16px;border:2px solid #000;" id="r-5">&nbsp;&nbsp;</td>
			</tr>
		</table>
	</td><td></td>
	</tr>
	<tr style="background-color:#ff0000;color:#ffffff;text-align:center;">
		<td style="width:25%" colspan="2">{$i18n->_("Account")}</td>
		<td style="width:25%" style="text-align:left;">{$i18n->_('Account type')}</td>
		<td style="width:50%" style="text-align:left;">{$i18n->_("Products")}</td>
	</tr>
</table>


{*ENCABEZADOS DE CUENTAS*}
<table id="headerProductos" style="width:100%;display:none;" class="table">
	<tr style="background-color:#ff0000;color:#ffffff;text-align:center;">
		<td style="width:5%"></td>
		<td style="width:20%">{$i18n->_("Account")}</td>
		<td style="width:25%">{$i18n->_("Account type")}</td>
		<td style="width:50%">{$i18n->_("Products")}</td>
		
	</tr>
</table>


{*TABLA PARA LA INFO DE LAS CUENTAS*}
<table class="table" id="accountInformationTable" style="width:100%;display : none">
	<tr>	
		<td width= "5%"><input type="radio" name="accountNumber" id="" value="" class="accountNumbers"/></td>
		<td width="20%" style="text-align:left;font-size:14px;font-weight:bold;" class="account" ></td>
		<td width="25%" style="text-align:left;font-size:14px;font-weight:bold;" class="nmTypes"></td> 
		<td width="50%" style="text-align:left;font-size:14px;font-weight:bold;" id="" class="nmProducts"></td>
	</tr>
</table>



{*ERROR*}
<div 
	id="messageDiv" 
	style="text-align : center; display : none" 
	error-message="{$i18n->_('An error ocurred during the request, please try it again or try to log in again')}" 
	no-information-message="{$i18n->_('No information found')}" 
	no-account-message="{$i18n->_('No Accounts found')}"
	null-message="{$i18n->_('You must fill at least one field')}"
>
	<h4 id="message"></h4><br>
</div>




{*LOADER*}
<div 
id="loader" 
style="text-align : center; display : none" 
client-information-message="{$i18n->_('Getting Client Information...')}"
client-account-message="{$i18n->_('Getting Account Information...')}" 
required-fields-message="{$i18n->_('Getting Required Fields...')}"
required-documents-message="{$i18n->_('Getting Required Documents...')}"
>
	<img src="{$baseUrl}/images/misc/loaders/loading.gif"><br><span id="message"></span>
	<br><br>
</div>



{*FIELD*}
<div id="requiredField" class="clearfix" style=" display : none">
	<div>
		<label for="" class="label-name "></label>
	</div>
	<span class="input"> 
		<input type="text" name="" id="" class="name-required-field regExFields span4">
	</span>
</div>

{*DOCUMENT*}
<div id="requiredDocument" class="clearfix" style=" display : none">
	<div>
		<label for="" class="label-name "></label>
	</div>
	<span class="input"> 
		<input type="file" name="" id="" class="name-required-document  span4">
		&nbsp;
		<button type="button" name="" id="" class="clear-required-field  clear" style="width:40px;">{$i18n->_('-')}</button>
	</span>
</div>




{*INFORMACION DEL CLIENTE*}
<div id="accountClientInformationTable" style="display : none">
	<table style="width:100%;border:1px solid #fff;" class="tdleft sinBorder">
		<tr>
		<td class="encabezado" colspan="4">{$i18n->_('Client Information')}</td></tr>		
		<tr>
			<td><strong>{$i18n->_('Name')}</strong></td>
			<td class="name"></td>
			<td><strong>{$i18n->_('Type of ticket')}</strong></td>
			<td>{html_options name=id_ticket_type id=id_ticket_type options=$ticketTypes selected=$params['id_ticket_type'] style="width:180px;height:28px;border:1px solid #e5e5e5;"}</td>
		</tr>
		<tr>
			<td><strong>{$i18n->_('Client Number')}</strong></td>
			<td class="clientNumber"></td>
			<td><strong>{$i18n->_('Canal')}</strong></td>
			<td>{html_options name=id_channel id=id_channel options=$channels selected=$params['id_channel'] style="width:180px;height:28px;border:1px solid #e5e5e5;"}</td>
			
		</tr>
		<tr>
			<td><strong>{$i18n->_('Account Number')}</strong></td>
			<td class="accountNumber"></td>
			<td><strong>{$i18n->_('Branch')}</strong></td>
			<td>{html_options options=$branches name="id_origin_branch" id="id_origin_branch" selected=$params['id_origin_branch'] style="width:180px;height:28px;border:1px solid #e5e5e5;"}</td>
		</tr>
		<tr>
			<td><strong>{$i18n->_('Account type')}</strong></td>
			<td class="typeAccount"></td>
			<td><strong>{$i18n->_('Branch Report')}</strong></td>
             <td>{html_options options=$branches name="id_reported_branch" id="id_reported_branch" selected=$params['id_reported_branch'] style="width:180px;height:28px;border:1px solid #e5e5e5;"}</td>			
		</tr>
		<tr>
			<td><strong>{$i18n->_('Product')}</strong></td>
			<td class="product"></td>
			<td><strong>{$i18n->_('Motive')}</strong></td>			
			<td>{html_options options=$reasons name="id_reason" id="id_reason" selected=$params['id_reason'] style="width:180px;height:28px;border:1px solid #e5e5e5;"}</td>
		</tr>		
		<tr>
			<td><strong>{$i18n->_('Card number')}</strong></td>
			<td class="cardNumber"></td>			
			<td><strong>{$i18n->_('Period')}</strong></td>			
            <td></td>
		</tr>
		<tr>
			<td><strong>{$i18n->_('From')}</strong></td>
			<td><input type="text" name="start_date" id="start_date" value="{$params['start_date']}" class="datepicker validDates span3 required"/></td>
			<td><strong>{$i18n->_('Until')}</strong></td>		
		    <td><input type="text" name="end_date" id="end_date" value="{$params['end_date']}" class="datepicker validDates span3 required"/></td>			
		</tr>
		<tr>
		<td class="tdright" colspan="4">
			<button name="regresaProductos" id="regresaProductos" class="btn danger regresaProductos">{$i18n->_('Go back')}</button>
			&nbsp;&nbsp;
			<button name="aceptaTicket" id="aceptaTicket" class="btn primary">{$i18n->_('Aceptar')}</button>
		</td></tr>
		</tr>
	</table>
</div>

<div id="newTicketTab2" style="display : none">
	<table style="width:100%;border:1px solid #fff;" class="tdleft sinBorder">
		<tr>
		<td class="encabezado" colspan="6">{$i18n->_('Client Information')}</td></tr>		
		<tr>
			<td><strong>{$i18n->_('Name')}</strong></td>
			<td class="name"></td>
			<td><strong>{$i18n->_('Client Number')}</strong></td>
			<td class="clientNumber"></td>
			<td><strong>{$i18n->_('Account Number')}</strong></td>
			<td class="accountNumber"></td>			
		</tr>
		<tr>
			<td><strong>{$i18n->_('Account type')}</strong></td>
			<td class="typeAccount"></td>
			<td><strong>{$i18n->_('Product')}</strong></td>
			<td class="product"></td>
			<td><strong>{$i18n->_('Card number')}</strong></td>
			<td class="cardNumber"></td>						
		</tr>
	</table>
</div>
