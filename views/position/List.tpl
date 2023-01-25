
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
        <caption><h3>{$i18n->_('Position')}<div style="float: right;">{if "position/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $positions as $position}
                <tr>
                    <td>{$position->getIdPosition()}</td>
                    <td>{$position->getName()}</td>
                    <td>{$companies[$position->getIdCompany()]}</td>
                    <td>{$i18n->_($position->getStatusName())}</td>
                    <td>{if "position/edit"|isAllowed}<a href="{$baseUrl}/position/edit/id/{$position->getIdPosition()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $position->isActive()}
                        {if "position/delete"|isAllowed}<a href="{$baseUrl}/position/delete/id/{$position->getIdPosition()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "position/reactivate"|isAllowed}<a href="{$baseUrl}/position/reactivate/id/{$position->getIdPosition()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "position/tracking"|isAllowed}<a href="{$baseUrl}/position/tracking/id/{$position->getIdPosition()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
