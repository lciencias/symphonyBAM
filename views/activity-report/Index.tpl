{include file="activity-report/Filter.tpl"}

{if $reportData}

    <br /><br />
    <div class="row">
        {foreach $stats as $category => $stat}
        <div class="span3">
            <h5>{$category}</h5>
            <ul>
                {foreach $stat as $name => $duration}    
                    <li>{$name}: {$duration->toHuman()}</li>
                {/foreach}            
            </ul>
        </div>
        {/foreach}
    </div>
    <br /><br />

    <table class="zebra-striped bordered-table">
        <thead>
            <tr>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Location')}</th>
                <th>{$i18n->_('Area')}</th>
                <th>{$i18n->_('Registered By')}</th>
                <th>{$i18n->_('Register Date')}</th>
                <th>{$i18n->_('Ticket #')}</th>
                <th>{$i18n->_('Ticket Type')}</th>
                <th>{$i18n->_('Category')}</th>
                <th>{$i18n->_('Group')}</th>
                <th>{$i18n->_('Channel')}</th>
                <th>{$i18n->_('Status')}</th>
                <th>{$i18n->_('Assigned User')}</th>
                <th>{$i18n->_('Activity Date')}</th>
                <th>{$i18n->_('Activity Finished')}</th>
                <th>{$i18n->_('Duration')}</th>
                <th>{$i18n->_('Description')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $reportData as $row}
                <tr>
                    <td>{$row['company.name']}</td>
                    <td>{$row['location.name']}</td>
                    <td>{$row['area.name']}</td>
                    <td>{$row['user.fullname']}</td>
                    <td>{$row['ticket.created']}</td>
                    <td>{$row['ticket.id_ticket']}</td>
                    <td>{$row['ticket_type.name']}</td>
                    <td>{$row['category.name']}</td>
                    <td>{$row['group.name']}</td>
                    <td>{$row['channel.name']}</td>
                    <td>{$row['ticket.status_name']}</td>
                    <td>{$row['assignedUser.fullname']}</td>
                    <td>{$row['activity.start_date']}</td>
                    <td>{$row['activity.end_date']}</td>
                    <td>{$row['activity.duration']}</td>
                    <td>{$row['activity.note']}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
                
{/if}

<script type="text/javascript" src="{$baseUrl}/js/modules/ticket/list.js"></script>
