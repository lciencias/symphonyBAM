
<form method="POST" action="">
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Accessrole')}</td>
            <td>{html_options name=id_access_role id=id_access_role options=$accessRoles}</td>
            <td>{$i18n->_('Username')}</td>
            <td><input type="text" name="username" id="username" value="{$post['username']}" class="span3" /></td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options options=$statuses name=status id=status selected=$post['statuses']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Users')}<div style="float: right;">{if "user/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('User')}</th>
                <th>{$i18n->_('Role')}</th>
                <th>{$i18n->_('Group')}</th>
                <th>{$i18n->_('Last accessed')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $users as $user}
                <tr>
                    <td>{$user->getFullname()}</td>
                    <td>{$user->getUserName()}</td>
                    <td>{$accessRoles[$user->getIdAccessRole()]}</td>
                    <td>{$groups[$user->getIdUser()]}</td>
                    <td>{$userLog[$user->getIdUser()]}</td>
                    <td>{$i18n->_($user->getStatusName())}</td>
                    <td>{if "user/edit"|isAllowed}<a href="{$baseUrl}/user/edit/id/{$user->getIdUser()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $user->getStatus()==1}
                        {if "user/delete"|isAllowed}<a href="{$baseUrl}/user/delete/id/{$user->getIdUser()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}</td>
                    {else}
                        {if "user/reactivate"|isAllowed}<a href="{$baseUrl}/user/reactivate/id/{$user->getIdUser()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}</td>
                    {/if}
                    <td>{if "user/tracking"|isAllowed}<a href="{$baseUrl}/user/tracking/id/{$user->getIdUser()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
