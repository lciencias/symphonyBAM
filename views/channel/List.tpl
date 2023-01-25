
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table>
        <tbody class="actions">
        <tr>
            <td>{$i18n->_('Name')}</td>
            <td><input type="text" name="name" id="name" value="{$post['name']}" class="span3" /></td>
            <td>{$i18n->_('Status')}</td>
            <td>{html_options name=status id=status options=$statuses selected=$post['status']}</td>
    
            <th><input type="submit" class="btn primary" value="{$i18n->_('Filter')}" /></th>
         </tr>
        </tbody>
    </table>
</form>

    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Channel')}<div style="float: right;">{if 'channel/new'|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('Name')}</th>
                <th>{$i18n->_('Status')}</th>
                <th colspan="3">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $channels as $channel}
                <tr>
                    <td>{$channel->getIdChannel()}</td>
                    <td>{$channel->getName()}</td>
                    <td>{$i18n->_($channel->getStatusName())}</td>
                    <td>{if 'channel/edit'|isAllowed}<a href="{$baseUrl}/channel/edit/id/{$channel->getIdChannel()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>
                    {if $channel->isActive()}
                        {if 'channel/delete'|isAllowed}<a href="{$baseUrl}/channel/delete/id/{$channel->getIdChannel()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Deactivate')}</a>{/if}
                    {else}
                        {if 'channel/reactivate'|isAllowed}<a href="{$baseUrl}/channel/reactivate/id/{$channel->getIdChannel()}" class="btn">{icon class=tip src=tick title=$i18n->_('Reactivate')}</a>{/if}
                    {/if}
                    </td>
                    <td>{if 'channel/tracking'|isAllowed}<a href="{$baseUrl}/channel/tracking/id/{$channel->getIdChannel()}" class="btn">{icon class=tip src=book_open title=$i18n->_('Tracking')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>


{include file='layout/Pager.tpl' paginator=$paginator}
