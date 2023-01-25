
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Holiday Calendar')}<div style="float: right;">{if 'calendar/new'|isAllowed}<a href="{url action=new}" class="btn">{icon src=page_white_add}{$i18n->_('New')}</a>{/if}</div></h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('Date')}</th>
                <th>{$i18n->_('Holiday')}</th>
                <th colspan="2">{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $calendars as $calendar}
                <tr>
                    <td>{$calendar->getDate()}</td>
                    <td>{$calendar->getNameHoliday()}</td>
                    <td>{if 'calendar/edit'|isAllowed}<a href="{$baseUrl}/calendar/edit/id/{$calendar->getIdCalendar()}" class="btn">{icon class=tip src=pencil title=$i18n->_('Edit')}</a>{/if}</td>
                    <td>{if 'calendar/delete'|isAllowed}<a href="{$baseUrl}/calendar/delete/id/{$calendar->getIdCalendar()}" class="btn deactivate">{icon class=tip src=delete title=$i18n->_('Delete')}</a>{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>

{include file='layout/Pager.tpl' paginator=$paginator}
