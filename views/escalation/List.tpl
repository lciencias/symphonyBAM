
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
        <caption><h3>{$i18n->_('Escalations')}<div style="float: right;">{if "escalation/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $escalations as $escalation}
                <tr>
                    <td>{$escalation->getIdEscalation()}</td>
                    <td>{$escalation->getName()}</td>
                    <td>{$i18n->_($escalation->getStatusName())}</td>
                    <td>{if "escalation/edit"|isAllowed}<a href="{$baseUrl}/escalation/edit/id/{$escalation->getIdEscalation()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $escalation->isActive()}
                        {if "escalation/delete"|isAllowed}<a href="{$baseUrl}/escalation/delete/id/{$escalation->getIdEscalation()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "escalation/reactivate"|isAllowed}<a href="{$baseUrl}/escalation/reactivate/id/{$escalation->getIdEscalation()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "escalation/tracking"|isAllowed}<a href="{$baseUrl}/escalation/tracking/id/{$escalation->getIdEscalation()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
