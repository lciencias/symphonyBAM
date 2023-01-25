<script type="text/javascript" src="{$baseUrl}/js/modules/products/products.js"></script>

<form action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$params['name']}"></td>
            <td>{$i18n->_('Status')}</td>
             <td>{html_options name=status id=status options=$statuses selected=$params['status']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
        
        <table>
        <tbody>
             {if "product/sync"|isAllowed}
        <tr id="asinc">
            <td><input type="button" id="sincProducts" class="btn primary" value="{$i18n->_('Sincronizar Productos')}" /></td>
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
</form>
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Product')}
        {*<div style="float: right;">{if "product/form"|isAllowed}<a href="{url action=form}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div>*}
        </h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Id Bam')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $ProductCollection as $Product}
                <tr>
                    <td>{$Product->getIdProduct()}</td>
                    <td>{$Product->getName()}</td>
                    <td>{$Product->getIdProductBam()}</td>
                    <td>{$i18n->_($Product->getStatusName())}</td>
                    <td>{if "product/form"|isAllowed}<a href="{$baseUrl}/product/form/id/{$Product->getIdProduct()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $Product->isActive()}
                        {if "product/disable"|isAllowed}<a href="{$baseUrl}/product/disable/id/{$Product->getIdProduct()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "product/enable"|isAllowed}<a href="{$baseUrl}/product/enable/id/{$Product->getIdProduct()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                   
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
