<div id="styledForm">
	<br>
	<h3>{$i18n->_('User')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/user/{$onsubmit}/{if $user['id_user']}id/{$user['id_user']}{/if}">
		<fieldset>
			<input name="status" value="{if $user['status']}{$user['status']}{else}1{/if}" id="status" type="hidden">
			<div class="clearfix">
				<div id="id_employee-label">
					<label for="id_employee" class="optional">{$i18n->_('Employee / Client')}</label>
				</div>
				<span class="input"> 
				{if $action eq 'new'}
					{html_options options=$employees name="id_employee" id="id_employee" selected=$user['id_employee'] class="required"}
				{else}
					{html_options options=$employees name="id_employee" id="id_employee" selected=$user['id_employee']}
				{/if}
				
				</span>
			</div>
			<div class="clearfix">
				<div id="username-label">
					<label for="username" class="required">{$i18n->_('Username')}</label>
				</div>
				<span class="input"> <input name="username" id="username"
					value="{$user['username']}" type="text" class="required">
				</span>
			</div>
			<div class="clearfix">
				<div id="password-label">
					<label for="password" class="optional">{$i18n->_('Password')}</label>
				</div>
				<span class="input"> 
					<input name="password" id="password" value="" type="password" class="validPassword ">
				</span>
			</div>
			<div class="clearfix">
				<div id="password_confirm-label">
					<label for="password_confirm" class="required">{$i18n->_('Password Confirm')}</label>
				</div>
				<span class="input"> 
					<input name="password_confirm" id="password_confirm" password-id="password" value="" type="password" class="passwordMatch ">
				</span>
			</div>
			<div class="clearfix">
				<div id="id_access_role-label">
					<label for="id_access_role" class="required">{$i18n->_('Branch')}</label>
				</div>
				<span class="input"> 
					{html_options options=$branches  name="id_branch" id="id_branch" selected=$user['id_branch']}
				</span>
			</div>
			<div class="clearfix">
				<div id="id_access_role-label">
					<label for="id_access_role" class="required">{$i18n->_('Channel')}</label>
				</div>
				<span class="input"> 
					{html_options options=$channels  name="id_channel" id="id_channel" selected=$user['id_channel']}
				</span>
			</div>			
			<div class="clearfix">
				<div id="id_access_role-label">
					<label for="id_access_role" class="required">{$i18n->_('AccessRole')}</label>
				</div>
				<span class="input"> 
					{html_options options=$accessRoles  name="id_access_role" id="id_access_role" selected=$user['id_access_role'] class="required"}
				</span>
			</div>
			<div class="clearfix">
				<div id="group-label">
					<label for="group" class="optional">{$i18n->_('Groups')}</label>
				</div>
				<span class="input">
					{html_options options=$groups name="group[]" id="group" selected=$userGroups multiple}
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