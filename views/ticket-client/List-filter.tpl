<form method="POST" action="" class="validate">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
            <tr>
                <td>{$i18n->_('Folio')}</td>
                <td><input type="text" name="folio" id="folio" value="{$params['folio']}" class="span3"/></td>
                <td>{$i18n->_('Account Number')}</td>
                <td><input type="text" name="account_number" id="account_number" value="{$params['account_number']}" class=span3/></td>
                <td>{$i18n->_('Type')}</td>
                <td>{html_options name=id_ticket_type id=id_ticket_type options=$ticketTypes selected=$params['id_ticket_type'] class=span3}</td>
                <th rowspan="5" style="vertical-align: middle;"><input type="submit" name="search" class="btn primary" value="{$i18n->_('Filter')}" /></th>
            <tr>
            </tr>
                <td>{$i18n->_('Status')}</td>
                <td>{html_options name=status id=status options=$statuses selected=$params['status'] class=span3}</td>
	            <td>{$i18n->_('Channel')}</td>
                <td>{html_options name=id_channel id=id_channel options=$channels selected=$params['id_channel'] class=span3}</td>
                <td>{$i18n->_('Category')}</td>
                <td>{html_options options=$clientCategories name="id_client_category" id="id_client_category" selected=$params['id_channel'] class="span3"}</td>
            </tr>
            <tr>
                <td>{$i18n->_('Origin Branch')}</td>
                <td>{html_options options=$branches name="id_origin_branch" id="id_origin_branch" selected=$params['id_origin_branch'] class="span3"}</td>
                <td>{$i18n->_('Reported Branch')}</td>
                <td>{html_options options=$branches name="id_reported_branch" id="id_reported_branch" selected=$params['id_reported_branch'] class="span3"}</td>
            	<td>{$i18n->_('Registered by')}</td>
                <td>{html_options name=id_user id=id_user options=$users selected=$params['id_user'] class=span3}</td>
            </tr>
            {if $action neq 'my-tickets'}
            <tr>
            	<td>{$i18n->_('Assigned to')}</td>
                <td>{html_options name=id_user_assigned id=id_user_assigned options=$users selected=$params['id_user_assigned'] class=span3}</td>
                <td colspan="4"></td>
            </tr>
            {/if}
        </tbody>
    </table>
</form>