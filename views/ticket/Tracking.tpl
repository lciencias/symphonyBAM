<table class="zebra-striped bordered-table">
    <caption><h3>{$i18n->_('Tracking')}</h3></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>{$i18n->_('User')}</th>
            <th>{$i18n->_('Event Type')}</th>
            <th>{$i18n->_('Date')}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {$i = 1}
        {foreach $ticketLogs as $log}
            <tr>
                 <td>{$i++}</td>
                 <td>{$users[$log->getIdUser()]}</td>
                 {if $log->isStatusChange()}
                 <td>{$i18n->_($log->getChangedToName())}</td>
                 {else}
                 <td>{$i18n->_($log->getEventTypeName())}</td>
                 {/if}
                 <td>{$log->getDateLog()}</td>
                 <td>{$log->getNote()}</td> 
            </tr>
        {/foreach}
        {if $assignments}
            <tr>
                 <td colspan="5" class="center">{$i18n->_('Resolutions')}</td>
            </tr>
        {/if}
        {foreach $assignments as $assignment}
            <tr>
                 <td colspan="5"><pre>{$assignment->getNote()}</pre></td> 
            </tr>
        {/foreach}
    </tbody>
</table>
    