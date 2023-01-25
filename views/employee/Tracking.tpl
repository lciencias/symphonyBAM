    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Tracking')}</h3></caption>
        <thead>
            <tr>
                <th>#</th>
                <th>{$i18n->_('User')}</th>
                <th>{$i18n->_('Event Type')}</th>
                <th>{$i18n->_('Date')}</th>
            </tr>
        </thead>
        <tbody>
            {$i = 1}
            {foreach $employeeLogs as $log}
                <tr>
                     <td>{$i++}</td>
                     <td>{$users[$log->getIdUser()]}</td>
                     <td>{$i18n->_($log->getEventTypeName())}</td>
                     <td>{$log->getDateLog()}</td> 
                </tr>
            {/foreach}
        </tbody>
    </table>
    