
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options options=$statuses name=status id=status selected=$post['status']}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Companies')}<div style="float: right;">{if "company/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $companies as $company}
                <tr>
                    <td>{$company->getIdCompany()}</td>
                    <td>{$company->getName()}</td>
                    <td>{$i18n->_($company->getStatusName())}</td>
                    <td>{if "company/edit"|isAllowed}<a href="{$baseUrl}/company/edit/id/{$company->getIdCompany()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    {if $company->isActive()}
                        <td>{if "company/delete"|isAllowed}<a href="{$baseUrl}/company/delete/id/{$company->getIdCompany()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}</td>
                    {else}
                        <td>{if "company/reactivate"|isAllowed}<a href="{$baseUrl}/company/reactivate/id/{$company->getIdCompany()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}</td>
                    {/if}
                    <td>{if "company/tracking"|isAllowed}<a href="{$baseUrl}/company/tracking/id/{$company->getIdCompany()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
