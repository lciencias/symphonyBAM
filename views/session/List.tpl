

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Sessions')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('User')}</th>
                <th>{$i18n->_('Last Request')}</th>
                <th>{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $sessions as $session}
                <tr>
                    <td>{$users[$session->getIdUser()]}</td>
                    <td>{$session->getLastRequest()->date}</td>
                    <td>
                        {if "session/delete"|isAllowed}<a href="{$baseUrl}/session/delete/id/{$session->getIdSession()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
