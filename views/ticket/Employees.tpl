
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="fullname" id="fullname" value="{$post['fullname']}" class="span3" /></td>
            <td>{$i18n->_('Company')}</td>
            <td>{html_options name=id_company class="span4" id=id_company options=$companies selected=$post['id_company']}</td>
            <td>{$i18n->_('Area')}</td>
            <td>{html_options name=id_area id=id_area options=$areas selected=$post['id_area'] class="span4"}</td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options options=$statuses name=status_employee id=status_employee selected=$post['status_employee'] class="span4"}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Employee')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Location')}</th>
                <th>{$i18n->_('Area')}</th>
                <th>{$i18n->_('Position')}</th>
                <th>{$i18n->_('Vip')}</th>
                <th>{$i18n->_('Status')}</th>
                <th>{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $employees as $employee}
                <tr>
                    <td>{$employee->getIdEmployee()}</td>
                    <td>{$employee->getFullName()}</td>
                    <td>{$companies[$employee->getIdCompany()]}</td>
                    <td>{$locations[$employee->getIdLocation()]}</td>
                    <td>{$areas[$employee->getIdArea()]}</td>
                    <td>{$positions[$employee->getIdPosition()]}</td>
                    <td>{if $employee->getIsVip()}{$i18n->_('Yes')}{else}{$i18n->_('No')}{/if}</td>
                    <td>{$i18n->_($employee->getStatusEmployeeName())}</td>
                    <td>{if "ticket/new"|isAllowed}<a href="{$baseUrl}/ticket/new/id_employee/{$employee->getIdEmployee()}" class="btn">{icon class=tip src=note_add title=$i18n->_('New Ticket')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
