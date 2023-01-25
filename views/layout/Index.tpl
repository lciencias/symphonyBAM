

<div class="center" align="center">
<table class="detail">
    <caption>{$i18n->_('Datos Personales')}</caption>
    <tr>
        <th>{$i18n->_('Nombre de Usuario')}:</th>

        <td>{$user.username}</td>
    </tr>
    <tr>
        <th>{$i18n->_('Nombre Completo')}:</th>
        <td>{$user.fullName}</td>
    </tr>
    <tr>
        <th>{$i18n->_('Último Inicio de Sesión')}:</th>
        <td>{$user.lastLoginAt}</td>
    </tr>
    <tr>
        <th>{$i18n->_('Iniciada desde')}:</th>
        <td>{$user.lastLoginFrom}</td>
    </tr>
</table>

</div>