<form method="POST" action="" class="filter-form">
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" /></td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Field')}<div style="float: right;">{if 'field/new'|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $fields as $field}
                <tr>
                <td>{$field->getIdField()}</td>
                    <td>{$field->getName()}</td>
                    <td>{$i18n->_($field->getStatusName())}</td>
                    <td>{if 'field/edit'|isAllowed}<a href="{$baseUrl}/field/edit/id/{$field->getIdField()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $field->isActive()}
                        {if 'field/delete'|isAllowed}<a href="{$baseUrl}/field/delete/id/{$field->getIdField()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'field/reactivate'|isAllowed}<a href="{$baseUrl}/field/reactivate/id/{$field->getIdField()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
