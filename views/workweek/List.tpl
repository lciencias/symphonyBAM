
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
        <caption><h3>{$i18n->_('Schedules')}<div style="float: right;">{if "workweek/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $workweeks as $workweek}
                <tr>
                    <td>{$workweek->getIdWorkweek()}</td>
                    <td>{$workweek->getName()}</td>
                    <td>{$i18n->_($workweek->getStatusName())}</td>
                    <td>{if "workweek/edit"|isAllowed}<a href="{$baseUrl}/workweek/edit/id/{$workweek->getIdWorkweek()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $workweek->isActive()}
                        {if "workweek/delete"|isAllowed}<a href="{$baseUrl}/workweek/delete/id/{$workweek->getIdWorkweek()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "workweek/reactivate"|isAllowed}<a href="{$baseUrl}/workweek/reactivate/id/{$workweek->getIdWorkweek()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "workweek/tracking"|isAllowed}<a href="{$baseUrl}/workweek/tracking/id/{$workweek->getIdWorkweek()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
