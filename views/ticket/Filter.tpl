

<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
            <tr>
                <td>{$i18n->_('Ticket Number')}</td>
                <td><input type="text" name="id_ticket" id="id_ticket" value="{$post['id_ticket']}" class=span3/></td>
                <td>{$i18n->_('Employee')}</td>
                <td><input type="text" name="employee_fullname" id="employee_fullname" value="{$post['employee_fullname']}" class=span3/></td>
                <td>{$i18n->_('Type')}</td>
                <td>{html_options name=id_ticket_type id=id_ticket_type options=$allOption+$ticketTypes selected=$post['id_ticket_type'] class=span3}</td>
                <th rowspan="4" style="vertical-align: middle;"><input type="submit" name="search" class="btn primary" value="{$i18n->_('Filter')}" /></th>
            <tr>
            </tr>
                <td>{$i18n->_('Status')}</td>
                <td>{html_options name=status id=status options=$statuses selected=$post['status'] class=span3}</td>
                <td>{$i18n->_('Channel')}</td>
                <td>{html_options name=id_channel id=id_channel options=$allOption+$channels selected=$post['id_channel'] class=span3}</td>
            	<td>{$i18n->_('Company')}</td>
                <td>{html_options name=id_company id=id_company options=$companies selected=$post['id_company'] class=span3}</td>
            </tr>
            <tr>
                <td>{$i18n->_('Category')}</td>
                <td><div id="categorySelect">{include file='ticket/Filter-category.tpl'}</div></td>
                <td>{$i18n->_('Registered by')}</td>
                <td>{html_options name=id_user id=id_user options=$users selected=$post['id_user'] class=span3}</td>
            	<td>{$i18n->_('Assigned to')}</td>
                <td>{html_options name=id_user_assigned id=id_user_assigned options=$users selected=$post['id_user_assigned'] class=span3}</td>
            </tr>
            <tr>
                <td>{$i18n->_('Location')}</td>
                <td>{html_options name=id_location id=id_location options=$locations selected=$post['id_location'] class=span3}</td>
                <td colspan="8"></td>
            </tr>
        </tbody>
    </table>
</form>
