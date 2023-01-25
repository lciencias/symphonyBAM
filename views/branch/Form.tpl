<div id="styledForm">
	<br>
	<h3>{$i18n->_('Sucursal')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded" method="post" action="{$baseUrl}/branch/{if $action eq 'edit'}update{else}create{/if}">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input">
					{if $action eq 'edit'}
					<input name="id_branch" id="id_branch" value="{$branch->getIdBranch()}" type="hidden">
					{/if}
					<input name="name" id="name" value="{$branch->getName()}" type="text" class="required" readonly>
				</span>
			</div>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="">{$i18n->_('State')}</label>
				</div>
				<span class="input">
					{html_options options=$states name="id_country_state" id="id_country_state" class="span4 required" selected=$branch->getidCountryState() disabled}
				</span>
			</div>
                                <div class="clearfix">
				<div id="name-label">
					<label for="address">{$i18n->_('Address')}</label>
				</div>
				<span class="input">
					<input name="address" id="address" value="{$branch->getAddress()}" type="text" readonly>
				</span>
			</div>
                        <div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Schedule')}</label>
				</div>
				<span class="input">
					<input name="scheduled" id="scheduled" value="{$branch->getScheduled()}" type="text" readonly>
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