
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
            <tr>
                <td>{$i18n->_('Name')}</td>
                <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
                <td>{$i18n->_('Status')}</td>
                <td>{html_options name=status id=status options=$statuses selected=$post['status']}</td>
        
                <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
            </tr>

        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Access Role')}{if 'access-role/new'|isAllowed}<div style="float: right;"><a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a></div>{/if}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="4">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $accessRoles as $accessRole}
                <tr>
                    <td>{$accessRole->getIdAccessRole()}</td>
                    <td>{$accessRole->getName()}</td>
                    <td>{$i18n->_($accessRole->getStatusName())}</td>
                    <td>{if 'access-role/edit'|isAllowed}<a href="{$baseUrl}/access-role/edit/id/{$accessRole->getIdAccessRole()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $accessRole->isActive()}
                        {if 'access-role/delete'|isAllowed}<a href="{$baseUrl}/access-role/delete/id/{$accessRole->getIdAccessRole()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'access-role/reactivate'|isAllowed}<a href="{$baseUrl}/access-role/reactivate/id/{$accessRole->getIdAccessRole()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if 'access-role/tracking'|isAllowed}<a href="{$baseUrl}/access-role/tracking/id/{$accessRole->getIdAccessRole()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                    <td>{if 'auth/permissions'|isAllowed}<a href="{$baseUrl}/auth/permissions/id_access_role/{$accessRole->getIdAccessRole()}" class="btn">{icon class=tip src=key title=$i18n->_('Permissions')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
