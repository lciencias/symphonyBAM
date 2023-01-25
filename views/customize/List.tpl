
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table style="width:50%" class="center">
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Company')}</td>
            <td>{html_options name=id_company id=id_company options=$companies selected=$post['id_company']}</td>
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Customize')}<div style="float: right;">{if "customize/new"|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('Id')}</th>
                <th>{$i18n->_('Company')}</th>
                <th>{$i18n->_('Logo')}</th>
                <th>{$i18n->_('Background Color')}</th>
                <th>{$i18n->_('Forward Color')}</th>
                <th>{$i18n->_('Font Size')}</th>
                <th>{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $customizes as $customize}
                <tr>
                    <td>{$customize->getIdPcsCommonCustomize()}</td>
                    <td>{$companies[$customize->getIdCompany()]}</td>
                    <td>{$customize->getLogo()}</td>
                    <td>{$customize->getBackgroundColor()}</td>
                    <td>{$customize->getForwardColor()}</td>
                    <td>{$customize->getFontSize()}</td>
                    <td>{if "customize/edit"|isAllowed}<a href="{$baseUrl}/customize/edit/id/{$customize->getIdPcsCommonCustomize()}" class="btn deactivate">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td></td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
