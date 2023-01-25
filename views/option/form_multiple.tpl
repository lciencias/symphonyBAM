
	<a href="#" id="addOption"><img src="{$baseUrl}/images/template/icons/add.png" class="tip" title="{$i18n->_('Add.')}" />{$i18n->_('Add.')}</a>
	<div id="inputContainer">
		{foreach from=$option->getValue() key=i item=value}
		      <span>
			     <a href="#" class="removeOption"><img src="{$baseUrl}/images/template/icons/delete.png" class="tip" title="{$i18n->_('Add.')}" /></a>
			     <input type="text" name="value[]" id="value{$i}" value="{$value}" class="required" style="display: inline;" /><br />
			  </span>
		{/foreach}
	</div>
