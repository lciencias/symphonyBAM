
<form action="{$baseUrl}/access-role/update" method="post" class="validate">
    <table class="center">
        <caption>{$i18n->_('Editar Grupo de Usuario')}</caption>
        <tfoot>
            <tr>
                <td colspan="2">
                    <input type="submit" value="{$i18n->_('Guardar')}" />
                    <input type="button" value="{$i18n->_('Regresar')}" class="back" />
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <th>{$i18n->_('Nombre')}</th>
                <td><input type="text" id="name" name="name" class="required" value="{$accessRole->getName()}"/>
                    <input type="hidden" name="id" value="{$accessRole->getIdAccessRole()}">
                </td>
            </tr>
        </tbody>
    </table>
</form>
