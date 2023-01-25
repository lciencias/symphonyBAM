<script type="text/javascript" src="{$baseUrl}/bootstrap/js/bootstrap-modal.js"></script>
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options name=status id=status options=$status  selected=$template['status']}</td>
                
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
        </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Template Emails')}{if "template-email/new"|isAllowed}<div style="float: right;"><a href="{url action=new}" class="btn" id="new-template">{icon src=page_white_add}{$i18n->_('New')}</a></div>{/if}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Event')}</th>
                <th>{$i18n->_('Language')}</th>
                <th>{$i18n->_('Destination Mail Account')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $templateEmails as $templateEmail}
                <tr>
                    <td>{$templateEmail->getIdTemplateEmail()}</td>
                    <td>{$templateEmail->getName()}</td>
                    <td>{$i18n->_($templateEmail->getEventName())}</td>
                    <td>{$i18n->_($templateEmail->getLanguageName())}</td>
                    <td>{$accounts[$templateEmail->getIndex()]}</td>
                    <td>{$i18n->_($templateEmail->getStatusName())}</td>
                    <td>{if "template-email/edit"|isAllowed}<a href="{$baseUrl}/template-email/edit/id/{$templateEmail->getIdTemplateEmail()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $templateEmail->isActive()}
                        {if "template-email/delete"|isAllowed}<a href="{$baseUrl}/template-email/delete/id/{$templateEmail->getIdTemplateEmail()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if "template-email/reactivate"|isAllowed}<a href="{$baseUrl}/template-email/reactivate/id/{$templateEmail->getIdTemplateEmail()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if "template-email/tracking"|isAllowed}<a href="{$baseUrl}/template-email/tracking/id/{$templateEmail->getIdTemplateEmail()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>

{include file='layout/Pager.tpl' paginator=$paginator}
{include file='template-email/Modal.tpl'}