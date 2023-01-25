<div id="styledForm">
	<br>
	<h3>{$i18n->_('Sucursal')}</h3>
	<form class="" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/required-field/{if $action eq 'edit'}update{else}create{/if}">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Nombre')}</label>
				</div>
				<span class="input">
					{if $action eq 'edit'}
					<input name="id_required_field" id="id_required_field" value="{$requiredField['id_required_field']}" type="hidden">
					{/if}
					<input name="name" id="name" value="{$requiredField['name']}" type="text">
				</span>
				
			</div>
			<div class="actions">
				<input id="send" value="{$i18n->_('Guardar')}" class="btn primary" type="submit">
				<button aria-disabled="false" role="button" name="cancel" id="cancel" type="button" class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">{$i18n->_('Cancelar')}</span>
				</button>
			</div>
		</fieldset>
	</form>
</div>