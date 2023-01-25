
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
            <td>{$i18n->_('Products')}</td>
            <td>{html_options name=id_product id=id_product options=$optionProducts}</td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options name=status id=status options=$statuses selected=$post['status']}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
         </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Reasons')}<div style="float: right;">{if 'reasons/new'|isAllowed}<a href="{url action=create}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Products')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $reasons as $reason}
                <tr>
                    <td>{$reason->getIdReason()}</td>
                    <td>{$reason->getName()}</td>
                    <td>{if $listProducts[$reason->getIdReason()]} 
                        {assign var="expl" value=$listProducts[$reason->getIdReason()]}
                          {', '|implode:$expl}
                        {/if}</td>
                    <td>{$i18n->_($reason->getStatusName())}</td>
                    <td>{if 'reasons/edit'|isAllowed}<a href="{$baseUrl}/reasons/edit/id/{$reason->getIdReason()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $reason->isActive()}
                        {if 'reasons/delete'|isAllowed}<a href="{$baseUrl}/reasons/delete/id/{$reason->getIdReason()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'reasons/reactivate'|isAllowed}<a href="{$baseUrl}/reasons/reactivate/id/{$reason->getIdReason()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
{*                    <td>{if 'reasons/tracking'|isAllowed}<a href="{$baseUrl}/reasons/tracking/id/{$reason->getIdReason()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>*}
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
