
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Responsible')}</td>
            <td>{html_options name=id_user id=id_user options=$users selected=$post['id_user']}</td>
            <td>{$i18n->_('Schedule')}</td>
            <td>{html_options name=id_workweek id=id_workweek options=$workweeks selected=$post['id_workweek']}</td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options name=status id=status options=$statuses selected=$post['status']}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Group')}<div style="float: right;">{if "group/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Responsible')}</th>
                <th>{$i18n->_('Schedule')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $groups as $group}
                <tr>
                    <td>{$group->getIdGroup()}</td>
                    <td>{$group->getName()}</td>
                    <td>{$users[$group->getIdUser()]}</td>
                    <td>{$workweeks[$group->getIdWorkweek()]}</td>
                    <td>{$i18n->_($group->getStatusName())}</td>
                    <td>{if "group/edit"|isAllowed}<a href="{$baseUrl}/group/edit/id/{$group->getIdGroup()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $group->isActive()}
                        {if "group/delete"|isAllowed}<a href="{$baseUrl}/group/delete/id/{$group->getIdGroup()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "group/reactivate"|isAllowed}<a href="{$baseUrl}/group/reactivate/id/{$group->getIdGroup()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "group/tracking"|isAllowed}<a href="{$baseUrl}/group/tracking/id/{$group->getIdGroup()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
