
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Parameters')}</h3></caption>
        <thead>
            <tr>
                <th>#</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Description')}</th>
                <th>{$i18n->_('Value')}</th>
                <th>{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $options as $option}
                <tr>
                    <td>{$option->getIdOption()}</td>
                    <td>{$i18n->_($option->getName())}</td>
                    <td>{$i18n->_($option->getDetail())}</td>
                    <td>
	                    {if $option->getType() == 1} {include file="option/list_simple.tpl"} {/if}
	                    {if $option->getType() == 2} {include file="option/list_multiple.tpl"} {/if}
	                    {if $option->getType() == 3} {include file="option/list_yes_no.tpl"} {/if}
	                    {if $option->getType() == 4} {include file="option/list_select.tpl"} {/if}
                    </td>
                    <td><a href="{$baseUrl}/option/edit/id/{$option->getIdOption()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
