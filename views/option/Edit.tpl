<form action="{url action=update}" method="post" class="validate">
    <input type="hidden" name="idOption" value="{$option->getIdOption()}" />
<div class="center" align="center">
    
    
    <table>
        <tbody>
            <tr>
                <th><label for="name">{$i18n->_('Option')}:</label></th>
                <td>{$i18n->_($option->getName())}</td>
            </tr>
            <tr>
                <th><label for="detail">{$i18n->_('Description')}</label></th>
                <td>{$i18n->_($option->getDetail())}</td>
            </tr>
            <tr>
                <th><label for="value">{$i18n->_('Value')}</label></th>
                <td>
                    {if $option->getType() == 1} {include file="option/form_simple.tpl"} {/if}
                    {if $option->getType() == 2} {include file="option/form_multiple.tpl"} {/if}
                    {if $option->getType() == 3} {include file="option/form_yes_no.tpl"} {/if}
                    {if $option->getType() == 4} {include file="option/form_select.tpl"} {/if}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="actions">
                    <input type="submit" class="btn primary" value="{$i18n->_('Save')}"/>
                    <input type="button" id="cancel" class="btn" value="{$i18n->_('Cancel')}">
                </td>
            </tr>
        </tfoot>
    </table>
</div>

</form>

<script type="text/javascript" src="{$baseUrl}/js/modules/option/form.js"></script>