<form method="POST" action="" class="filter-form">
    
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" /></td>
            <td>{$i18n->_('Name')}</td>
            <td>{html_options options=$types name="type" id="type" selected=$params['type']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Resolutions for Client Tickets')}<div style="float: right;">{if 'client-resolution/new'|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Type')}</th>
                <th>{$i18n->_('Code')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $clientResolutions as $clientResolution}
                <tr>
                <td>{$clientResolution->getIdClientResolution()}</td>
                    <td>{$clientResolution->getName()}</td>
					<td>{$i18n->_($clientResolution->getTypeName())}</td>
					<td>{$i18n->_($clientResolution->getCode())}</td>
                    <td>{$i18n->_($clientResolution->getStatusName())}</td>
                    <td>{if 'client-resolution/edit'|isAllowed}<a href="{$baseUrl}/client-resolution/edit/id/{$clientResolution->getIdClientResolution()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $clientResolution->isActive()}
                        {if 'client-resolution/delete'|isAllowed}<a href="{$baseUrl}/client-resolution/delete/id/{$clientResolution->getIdClientResolution()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'client-resolution/reactivate'|isAllowed}<a href="{$baseUrl}/client-resolution/reactivate/id/{$clientResolution->getIdClientResolution()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
