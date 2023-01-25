<h3>{$i18n->_('Reporte Regulatorio REUNE Reclamaciones')}</h3>
<br><br>
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tfoot class="actions">
            <tr>
                <th colspan="8" class="center">
                     <input type="submit" name="toExcel" class="btn" value="{$i18n->_('Download')}" />
                </th>
            </tr>
        </tfoot>
        <tbody>
            
            <tr>
                <td>{$i18n->_('Start date')}</td>
                <td colspan="3">
                    {html_options name=ini id=ini options=$combo class="span4" selected=$seleccion}
                </td>
            </tr>
        </tbody>
    </table>
    {if $errors}
        <div class="alert-message error">{$i18n->_($errors)}</div>
    {/if}
</form>