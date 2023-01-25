<script type="text/javascript" src="{$baseUrl}/js/modules/employee/company_combos.js"></script>
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tfoot class="actions">
            <tr>
                <th colspan="6" class="center">
                     <input type="submit" class="btn primary" value="{$i18n->_('Filter')}" />
                     <input type="submit" name="toExcel" class="btn" value="{$i18n->_('Download')}" />
                </th>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <td>{$i18n->_('Company')}</td>
                <td>{html_options name=id_company class='span4' id=id_company options=$companies selected=$post['id_company']}</td>
                <td>{$i18n->_('Category')}</td>
                <td><div id="categorySelect">{include file='ticket/Filter-category.tpl'}</div></td>
                <td>{$i18n->_('Status')}</td>
                <td>{html_options name=status id=status options=$statuses selected=$post['status'] class="span4"}</td>
            </tr>
            <tr>    
                <td>{$i18n->_('Location')}</td>
                <td>{html_options name=id_location class='span4' id=id_location options=$locations selected_id=$post['id_location'] ajax_url={url action=json controller=location firstOption=$i18n->_('All')}}</td>
                <td>{$i18n->_('Area')}</td>
                <td>{html_options name=id_area id=id_area class='span4' options=$areas selected_id=$post['id_area'] ajax_url={url action=json controller=area firstOption=$i18n->_('All')}}</td>
                <td>{$i18n->_('Channel')}</td>
                <td>{html_options name=id_channel id=id_channel options=$channels selected=$post['id_channel'] class="span4"}</td>
            </tr>
            <tr>
                <td>{$i18n->_('Register Date')}</td>
                <td colspan="3">
                    {$i18n->_('From')}: <input type="text" name="start_created_date" id="start_created_date" value="{$post['start_created_date']}" class="datetimepicker span4" />
                    {$i18n->_('To')}: <input type="text" name="end_created_date" id="end_created_date" value="{$post['end_created_date']}" class="datetimepicker span4" />
                </td>
            </tr>
        </tbody>
    </table>
</form>