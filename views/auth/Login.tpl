<script type="text/javascript" src="{$baseUrl}/js/modules/auth/login.js"></script>

<div id="loginFormContainer" class="center">
     <br /><br />    
    {if $errorMessage} <div class="alert-message error">{$errorMessage}</div>{/if}
    <form action="{$baseUrl}/auth/login" method="post" id="loginForm">

        <table>
            <caption></caption>
            <tfoot>
                <tr>
                    <td colspan="2" class="center"><input type="submit" value="{$i18n->_('Login')}" class="btn primary" /></td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <td><label for="username">{$i18n->_('Username')}:</label></td>
                    <td><input type="text" name="username" id="username" value="{$post.username}" autofocus/></td>
                </tr>
                <tr>
                    <td><label for="password">{$i18n->_('Password')}:</label></td>
                    <td><input type="password" name="password" id="password" value=""/></td>
                </tr>
            </tbody>
        </table>
    </form>
    
</div>
