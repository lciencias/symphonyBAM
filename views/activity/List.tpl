
    <table class="zebra-striped bordered-table">
        <caption><h3>{$i18n->_('Activities')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('User')}</th>
                <th>{$i18n->_('Start Date')}</th>
                <th>{$i18n->_('End Date')}</th>
                <th>{$i18n->_('Duration')}</th>
                <th>{$i18n->_('Note')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $activities as $activity}
                <tr>
                    <td>{$activity->getIdActivity()}</td>
                    <td>{$users[$activity->getIdUser()]}</td>
                    <td>{$activity->getStartDate()}</td>
                    <td>{$activity->getEndDate()}</td>
                    <td>{$activity->getDuration()->toHuman()}</td>
                    <td>{$activity->getNote()}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>