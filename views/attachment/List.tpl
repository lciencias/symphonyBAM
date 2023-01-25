{if $attachments}
    <table class="zebra-striped bordered-table center" style="width: 70%;">
        <caption><h3>{$i18n->_('Attachments')}</h3></caption>
        <thead>
            <tr>
                <th>{$i18n->_('#')}</th>
                <th>{$i18n->_('File')}</th>
                <th>{$i18n->_('Date')}</th>
                <th>{$i18n->_('Actions')}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $attachments as $attachment}
                <tr>
                    <td>{$attachment->getIdAttachment()}</td>
                    <td>{$attachment->getOriginalName()}</td>
                    <td>{$attachment->getCreatedAt()}</td>
                    <td><a class="btn" href="{str_replace('public',$baseUrl, $attachment->getUri())}">{$i18n->_('Download')}</a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}