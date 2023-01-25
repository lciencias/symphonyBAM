<div id="styledForm">
	<br>
	<h3>{$i18n->_('Edit Password')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/user/update-password/id/{$user['id_user']}">
		<fieldset>
			<div class="clearfix">
				<div id="password-label">
					<label for="password" class="optional">{$i18n->_('Password')}</label>
				</div>
				<span class="input"> 
					<input name="password" id="password" value="" type="password" class="validPassword required">
				</span>
			</div>
			<div class="clearfix">
				<div id="password_confirm-label">
					<label for="password_confirm" class="required">{$i18n->_('Password Confirm')}</label>
				</div>
				<span class="input"> 
					<input name="password_confirm" id="password_confirm" password-id="password" value="" type="password" class="passwordMatch required">
				</span>
			</div>
			<div class="actions">

				<input name="send" id="send" value="{$i18n->_('Save')}" class="btn primary"
					type="submit">

				<button aria-disabled="false" role="button" name="cancel"
					id="cancel" type="button"
					class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">{$i18n->_('Cancel')}</span>
				</button>
			</div>
		</fieldset>
	</form>
</div>