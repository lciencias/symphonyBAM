
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Type')}</td>
            <td>{html_options options=$types selected=$post['type'] name=type id=type}</td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options options=$statuses selected=$post['status'] name=status id=status}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Resolution')}<div style="float: right;">{if "resolution/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Type')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $resolutions as $resolution}
                <tr>
                    <td>{$resolution->getIdResolution()}</td>
                    <td>{$resolution->getName()}</td>
                    <td>{$i18n->_($resolution->getTypeName())}</td>
                    <td>{$i18n->_($resolution->getStatusName())}</td>
                    <td>{if "resolution/edit"|isAllowed}<a href="{$baseUrl}/resolution/edit/id/{$resolution->getIdResolution()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $resolution->isActive()}
                        {if "resolution/delete"|isAllowed}<a href="{$baseUrl}/resolution/delete/id/{$resolution->getIdResolution()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "resolution/reactivate"|isAllowed}<a href="{$baseUrl}/resolution/reactivate/id/{$resolution->getIdResolution()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "resolution/tracking"|isAllowed}<a href="{$baseUrl}/resolution/tracking/id/{$resolution->getIdResolution()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
