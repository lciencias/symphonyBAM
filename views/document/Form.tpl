<div id="styledForm">
	<br>
	<h3>{$i18n->_('Document')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/document/{if $action eq 'edit'}update{else}create{/if}">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input">
					{if $action eq 'edit'}
					<input name="id_document" id="id_document" value="{$document['id_document']}" type="hidden">
					{/if}
					<input name="name" id="name" value="{$document['name']}" type="text" class="required">
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