<div id="styledForm">
	<br>
	<h3>{$i18n->_('Resolution')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/client-resolution/{if $action eq 'edit'}update{else}create{/if}">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input">
					{if $action eq 'edit'}
					<input name="id_client_resolution" id="id_client_resolution" value="{$clientResolution['id_client_resolution']}" type="hidden">
					{/if}
					<input name="name" id="name" value="{$clientResolution['name']}" type="text" class="required">
				</span>
			</div>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Type')}</label>
				</div>
				<span class="input">
					{html_options options=$types name=type id=type selected=$clientResolution['type'] class="required"}
				</span>
			</div>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Code')}</label>
				</div>
				<span class="input">
					<input name="code" id="code" value="{$clientResolution['code']}" type="text" class="required" maxlength="20">
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