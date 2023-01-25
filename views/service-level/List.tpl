
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options options=$statuses selected=$post['status'] name=status id=status}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Service Levels')}<div style="float: right;">{if "service-level/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Response Time')}</th>
                <th>{$i18n->_('Resolution Time')}</th>
                <th>{$i18n->_('Duration')}</th>
                <th>{$i18n->_('Note')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $serviceLevels as $serviceLevel}
                <tr>
                    <td>{$serviceLevel->getName()}</td>
                    
                    <td>{$serviceLevel->getResponseDuration()->toHuman()} ({$serviceLevel->getFormatedResponseTime()})</td>
                    <td>{$serviceLevel->getResolutionDuration()->toHuman()} ({$serviceLevel->getFormatedResolutionTime()})</td>
                    <td>{$serviceLevel->getDuration()->toHuman()}</td>
                    <td>{$serviceLevel->getNote()}</td>
                    <td>{$i18n->_($serviceLevel->getStatusName())}</td>
                    <td>{if "service-level/edit"|isAllowed}<a href="{$baseUrl}/service-level/edit/id/{$serviceLevel->getIdServiceLevel()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $serviceLevel->isActive()}
                        {if "service-level/delete"|isAllowed}<a href="{$baseUrl}/service-level/delete/id/{$serviceLevel->getIdServiceLevel()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "service-level/reactivate"|isAllowed}<a href="{$baseUrl}/service-level/reactivate/id/{$serviceLevel->getIdServiceLevel()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "service-level/tracking"|isAllowed}<a href="{$baseUrl}/service-level/tracking/id/{$serviceLevel->getIdServiceLevel()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
