{if !$params['mine']}{include file="ticket/Filter.tpl"}{/if}

{if $tickets}
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Tickets')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Employee')}</th>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Category')}</th>
                <th>{$i18n->_('Ticket Type')}</th>
                <th>{$i18n->_('Channel')}</th>
                <th>{$i18n->_('Registered by')}</th>
                <th>{$i18n->_('Register Date')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="6">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $tickets as $ticket}
                <tr>
                    <td>{$ticket->getIdTicket()}</td>
                    <td>{$employees[$ticket->getIdEmployee()]}</td>
                    <td>{$allCompanies[$ticket->getIdCompany()]}</td>
                    <td>{$categories[$ticket->getIdCategory()]}</td>
                    <td>{$allTicketTypes[$ticket->getIdTicketType()]}</td>
                    <td>{$allChannels[$ticket->getIdChannel()]}</td>
                    <td>{$registeredUsers[$ticket->getIdUser()]}</td>
                    <td>{if isset($registerLogs[$ticket->getIdTicket()])}{$registerLogs[$ticket->getIdTicket()]->getDateLog()}{/if}</td>
                    <td>{$i18n->_($ticket->getStatusName())}</td>
                    <td>{if "ticket/edit"|isAllowed}<a href="{url action=edit id_ticket=$ticket->getIdTicket()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}{/if}</a></td>
                    <td>{if "ticket/show"|isAllowed}<a href="{url action=show id_ticket=$ticket->getIdTicket()}" class="btn">{icon class=tip src=eye title=$i18n->_('Show')}{/if}</a></td>
                    <td>{if "ticket/tracking"|isAllowed}<a href="{url action=tracking id_ticket=$ticket->getIdTicket()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}{/if}</a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}

{include file='layout/Pager.tpl' paginator=$paginator}

<script type="text/javascript" src="{$baseUrl}/js/modules/ticket/list.js"></script>
