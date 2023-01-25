<input type="hidden" name="idTransactionPayment" id="idTransactionPayment" value="0">
<input type="hidden" name="idPermisoPayment" id="idPermisoPayment" value="0">
<b><span id="nmTransaction"></span></b><br><br>
<table class="bordered-table">
	<tbody>
		<tr>
			<td width="35%" style="background-color:#eeeeee;">{$i18n->_('Payment in good faith')}:</td>
			<td width="65%" class="good_faith_amount">
			</td>
		</tr>
		<tr>
			<td style="background-color:#eeeeee;">{$i18n->_('Date of subscription')}:</td>
			<td class="good_faith_date">
			</td>
		</tr>
		<tr>
			<td style="background-color:#eeeeee;">{$i18n->_('T24 Registration')}:</td>
			<td class="good_faith_payment">					
		</tr>
		{if "ticket-client/good-faith-amount"|isAllowed}
			{*if $flagGoodFaith*}
				<tr>
				<td>			
					<button class="btn success abonoBuenaFeBoton" id="abonoBuenaFeBoton-{$tab}" name="abonoBuenaFeBoton-{$tab}">{$i18n->_('Good Feeder Credit Application')}</button></td>
					<td class="">
					<input type="text" name="good_faith_payment_request{$tab}" id="good_faith_payment_request{$tab}" maxlength="15" class="form-control numerico good_faith_payment_request" value="" style="display:none;">
						&nbsp;&nbsp;
					<button name="buttonAbonoBuenaFe-{$tab}" id="buttonAbonoBuenaFe-{$tab}" class="btn success buttonAbonoBuenaFe" style="display:none;"> {$i18n->_('Save payment in good faith')}</button>
				</td>
				</tr>
			{*/if*}
		{/if}
		{if "ticket-client/good-faith-amount-request"|isAllowed}
			{*if $flagFolioGoodFaith*}
			<tr>
				<td>
				<button class="btn info rabonoBuenaFeBoton" id="rbonoBuenaFeBoton-{$tab}" name="rbonoBuenaFeBoton-{$tab}">{$i18n->_('Register Good faith bonus')}</button></td>			
				<td class="">
					<input type="text" name="good_faith_delivery_request{$tab}" id="good_faith_delivery_request{$tab}" maxlength="20" class="form-control alfanumerico good_faith_delivery_request" value="" style="display:none;">			
					&nbsp;&nbsp;
					<button name="buttonFolioBuenaFe-{$tab}" id="buttonFolioBuenaFe-{$tab}" class="btn info buttonFolioBuenaFe" style="display:none;"> {$i18n->_('Save Good faith bonus')}</button>	
				</td>
			</tr>
			{*/if*}		
		{/if}
	</tbody>
</table>