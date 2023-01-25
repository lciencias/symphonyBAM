
<h3>{$i18n->_('Client Categories')}</h3>
<br>
<form  action="{$baseUrl}/category/list" class="filter-form">
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Ticket Type')}</td>
            <td>{html_options options=$ticketTypes name=id_ticket_type id=id_ticket_type selected=$idTicketType}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>
{if $idTicketType}
<a href="{$baseUrl}/client-category/new/id_ticket_type/{$idTicketType}">{$i18n->_('New Category')}<img src="{$baseUrl}/images/template/icons/new.png"/></a>
<br>
<br>
<br>
{/if}    

{if $nestedCategories}
    {render_client_categories nestedCategories=$nestedCategories renderer=list}
{/if}

<script type="text/javascript" src="{$baseUrl}/js/modules/category/list.js"></script>