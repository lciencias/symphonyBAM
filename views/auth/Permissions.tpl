

<br />
<form action="{url action='update-permissions'}" method="post">
    <input type="hidden" name="id_access_role" value="{$accessRole->getIdAccessRole()}" />
    <table style="width: 60%;" class="center zebra-striped bordered-table">
      <caption><h3>{$i18n->_("Permissions for the Role")} {$accessRole->getName()}</h3></caption>
      <thead>
          <tr>
              <th>{$i18n->_("Module")}</th>
              <th>{$i18n->_("Action")}</th>
              <th>{$i18n->_("Allow")}</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
              <td colspan="3" class="center">
              	<input type="submit" value="{$i18n->_('Save')}" class="btn primary" />
              	<input type="button" value="{$i18n->_('Cancel')}" class="btn cancel" />
              </td>
          </tr>
      </tfoot>
      <tbody>
      {foreach $groupedActions as $module => $actions}
          <tr>
            <th colspan="3">{$i18n->_($module)}</th>
          </tr>
          {foreach $actions as $action}
           {$actionName = $action->getTagAction()}
          <tr>
            <td></td>
            <td>{$i18n->_($actionName)}</td>
            <td><input type="checkbox" name="permissions[{$module}][{$actionName}]" value="1" {if $permissions[$module][$actionName] == 1}checked="checked"{/if} /></td>
          </tr>
          {/foreach}
      {/foreach}
      </tbody>
      
    </table>
<br />

</form>