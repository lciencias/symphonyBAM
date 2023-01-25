<span style="text-align:center;color:#ff0000;" id="errorDeposit"></span>
<input type="hidden" name="idInfTransaction" id="idInfTransaction" value="0">
<input type="hidden" name="typeDeposit" id="typeDeposit" value="1">
		
<table class="zebra-striped sinBorder" id="" >
	<tr>
		<td width=25%">{$i18n->_("Amount claimed")}</td>
		<td><span id="amountDepositedModal{$tab}"></span></td>
	</tr>
	<tr>
		<td width=25%">{$i18n->_("Date of operation")}</td>
		<td><span id="dateDepositedModal{$tab}"></span></td>
	</tr>
	<tr>
		<td width=25%">{$i18n->_("Attachment file")}</td>
		<td><button id="descargarpartialModal{$tab}" name="descargarpartialModal{$tab}" target="_blank" class="btn btn-default descargarpartialModal" style="display:none;" value="0">{$i18n->_('Download')}</button></td>
	</tr>
</table>