<script type="text/javascript" src="{$baseUrl}/js/modules/branch/branch.js"></script>

<form method="POST" action="" class="filter-form">
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" value="{$params['name']}"/></td>
            <td>{$i18n->_('state')}</td>
            <td>{html_options options=$states name="id_country_state" id="id_country_state" selected=$params['id_country_state'] class="span4"}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>
<table>
        <tbody>
             {if "branch/sync"|isAllowed}
        <tr id="asinc">
            <td><input type="button" id="sincProducts" class="btn primary" value="{$i18n->_('Sync Branches')}" /></td>
        </tr>
            {/if}
        <tr id="oculto">
            <td>
                {*LOADER*}
        <div id="loader" style="text-align : center; display : none" client-account-message="{$i18n->_('Getting Account Information...')}">
	<img src="{$baseUrl}/images/misc/loaders/loading.gif"><br><span id="message"></span>
	<br>
</div>
            </td>
        </tr>
        </tbody>
    </table>
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Branch')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('State')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $branches as $branch}
                <tr>
                <td>{$branch->getIdbranch()}</td>
                    <td>{$branch->getName()}</td>
                    <td>{$states[$branch->getIdCountryState()]}
                    <td>{$i18n->_($branch->getStatusName())}</td>
                    <td>{if 'branch/edit'|isAllowed}<a href="{$baseUrl}/branch/edit/id/{$branch->getIdbranch()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {*{if $branch->isActive()}
                        {if 'branch/delete'|isAllowed}<a href="{$baseUrl}/branch/delete/id/{$branch->getIdbranch()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'branch/reactivate'|isAllowed}<a href="{$baseUrl}/branch/reactivate/id/{$branch->getIdbranch()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}*}
                    {if $branch->isActive()}
                        <button class="btn">{icon class=tip src=delete title=$i18n->_('Deactivate')}</button>
                    {else}
                        <button class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</button>
                    {/if}
                    </td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
