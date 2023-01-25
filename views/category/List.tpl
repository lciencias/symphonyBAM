
<form method="POST" action="{$baseUrl}/category/list">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Company')}</td>
            <td>{html_options options=$companies name=id_company id=id_company selected=$requestParams['id_company']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

{if $company}
    <h3>{$company->getName()}</h3>
    {if 'category/new'|isAllowed}<a href="{$baseUrl}/category/new/id_company/{$company->getIdCompany()}">{$i18n->_('New Category')} {icon src=new}</a>{/if}
    <br /><br /><br />
{/if}

{if $nestedCategories}
    {render_categories nestedCategories=$nestedCategories renderer=list}
{/if}

<script type="text/javascript" src="{$baseUrl}/js/modules/category/list.js"></script>