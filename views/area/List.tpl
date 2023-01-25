
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Company')}</td>
            <td>{html_options name=id_company id=id_company options=$companies selected=$post['id_company']}</td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options name=status id=status options=$statuses selected=$post['status']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Area')}<div style="float: right;">{if 'area/new'|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $areas as $area}
                <tr>
                <td>{$area->getIdArea()}</td>
                    <td>{$companies[$area->getIdCompany()]}</td>
                    <td>{$area->getName()}</td>
                    <td>{$i18n->_($area->getStatusName())}</td>
                    <td>{if 'area/edit'|isAllowed}<a href="{$baseUrl}/area/edit/id/{$area->getIdArea()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $area->isActive()}
                        {if 'area/delete'|isAllowed}<a href="{$baseUrl}/area/delete/id/{$area->getIdArea()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'area/reactivate'|isAllowed}<a href="{$baseUrl}/area/reactivate/id/{$area->getIdArea()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if 'area/tracking'|isAllowed}<a href="{$baseUrl}/area/tracking/id/{$area->getIdArea()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
