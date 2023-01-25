{foreach $requiredFields as $requiredField}
<div class="clearfix">
	<div>
		<label for="" class="label-name ">{$requiredField['name']}</label>
	</div>
	<span class="input"> 
		<input type="text" name="requiredFields[{$requiredField['id_field']}]" id="" value="{$ticketClientFields[$requiredField['id_field']]}" rule="{$requiredField['reg_ex']}" placeholder="{$i18n->_('Sample: ')}{$requiredField['sample']}" class="name-required-field span4 regExFields">
	</span>
</div>
{/foreach}