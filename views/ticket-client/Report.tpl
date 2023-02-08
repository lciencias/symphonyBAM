<h3>{$i18n->_('Ticket Client Report')}</h3>
<br><br>
<form method="POST" action="" class="validate">
<!--<form method="POST" action="http://10.14.2.254/ticket/r27/" class="validate" target="_blank">-->
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
            <tr>
                <td>{$i18n->_('Start Date')}</td>
                <td><input type="text" name="start_date" id="start_date" value="{$params['start_date']}" class="datepicker validDates span3 required"/></td>
                <td>{$i18n->_('End Date')}</td>
                <td><input type="text" name="end_date" id="end_date" value="{$params['end_date']}" class="datepicker validDates span3 required"/></td>
                <th rowspan="5" style="vertical-align: middle;"><input type="submit" name="search" class="btn primary" value="{$i18n->_('Filter')}" /></th>
            <tr>
        </tbody>
    </table>
</form>