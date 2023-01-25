{* <div id="styledForm"> <br /> <h3>{$i18n->_('Group')}</h3>{$form}*}
<div id="styledForm">
	<br>
	<h3>{$i18n->_('Group')}</h3>
	<form class="" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/group/{if $action eq 'new'}create{else}update/id/{$group->getIdGroup()}{/if}">
		<input name="status" value="{$group->getStatus()}" id="status" type="hidden">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input"> 
					<input name="name" id="name" value="{$group->getName()}" type="text">
				</span>
			</div>
			<div class="clearfix">
				<div id="id_user-label">
					<label for="id_user" class="required">{$i18n->_('Responsible')}</label>
				</div>
				<span class="input"> 
					{html_options options=$users id="id_user" name="id_user" class="span4" selected=$group->getIdUser()} 
				</span>
			</div>
			<div class="clearfix">
				<div id="id_workweek-label">
					<label for="id_workweek" class="required">{$i18n->_('Schedule')}</label>
				</div>
				<span class="input"> 
					{html_options options=$workweeks id="id_workweek" name="id_workweek" class="span4" selected=$group->getIdWorkweek()}
				</span>
			</div>
			{if $action eq 'edit'}
			<h3>Miembros</h3>
			<table>
				<tr>
					<th class="center ">{$i18n->_('Assign Tickets to:')}</th>
					<th class="center ">{$i18n->_('Name')}</th>
					<th class="center ">{$i18n->_('Username')}</th>
				</tr>
				{foreach $groupUsers as $groupUser}
				<tr>
					<td class="center "><input type="radio" name="id_user_assigned_for_tickets" value="{$groupUser->getIdUser()}" {if $groupUser->getIdUser() eq $group->getIdUserAssignedForTickets()}checked{/if}></td>
					<td class="center ">{$groupUser->getFullName()}</td>
					<td class="center ">{$groupUser->getUserName()}</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="2" class="center ">{$i18n->_('Este grupo no tiene miembros')}</td>
				</tr>
				{/foreach}
				
			</table>	
			{/if}
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
