<div id="styledForm">
	<br>
	<h3>{$i18n->_('Field')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/field/{if $action eq 'edit'}update{else}create{/if}" class="validate">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input">
					{if $action eq 'edit'}
					<input name="id_field" id="id_field" value="{$field['id_field']}" type="hidden">
					{/if}
					<input name="name" id="name" value="{$field['name']}" type="text" class="required">
				</span>
			</div>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Validators')}</label>
				</div>
				<span class="input">
					<input name="reg_ex" id="reg_ex" value="{$field['reg_ex']}" type="text" class="">
					{html_options options=$reguralExpressions id="reguralExpressions" name="reguralExpressions" class="span4" selected=$field['reg_ex']}
				</span>
			</div>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Sample')}</label>
				</div>
				<span class="input">
					<input name="sample" id="sample" value="{$field['sample']}" type="text" class="">
				</span>
			</div>
			<div class="actions">
				<input id="send" value="{$i18n->_('Save')}" class="btn primary" type="submit">
				<button aria-disabled="false" role="button" name="cancel" id="cancel" type="button" class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">{$i18n->_('Cancel')}</span>
				</button>
			</div>
		</fieldset>
	</form>
</div>