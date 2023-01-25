<div id="trackingTab">
<table class="zebra-striped bordered-table">
	<caption>
		<h3>{$i18n->_('Tracking')}</h3>
	</caption>
	<thead>
		<tr>
			<th>#</th>
			<th>{$i18n->_('User')}</th>
			<th>{$i18n->_('Event Type')}</th>
			<th>{$i18n->_('Date')}</th>
		</tr>
	</thead>
	<tbody>
	{foreach $trackings as $tracking}
		<tr>
			<td>{$tracking['id_ticket_client_log']}</td>
			<td>{$allUsers[$tracking['id_user']]}</td>
			<td>{$i18n->_($events[$tracking['event_type']])}</td>
			<td>{$tracking['date_log']}</td>
		</tr>
	{/foreach}
		<tr>
			<td colspan="4" class="center">{$i18n->_('Resolutions')}</td>
		</tr>
		{*{foreach $assignments as $assignment}
		{if $assignment['id_resolution']}
		{assign var=resolution value=$resolutions[$assignment['id_resolution']]}
		{/if}
		{if $assignment['id_file']}
		{assign var=file value=$assignmentFiles->getByPk($assignment['id_file'])}
		{/if}
		<tr>
			<td colspan="4">
				<p>{if $resolution}{$resolution->getName()} - {/if}{$assignment['note']} {if $file}<a class="btn" href="{$baseUrl}/{str_replace('public/','',$file->getUri())}" target="_blank">{$i18n->_('Download')} {$i18n->_('File')}</a>{/if}</p>
			</td>
		</tr>
		{/foreach}*}
                {foreach $assignments as $assignment}
		{if $assignment['id_resolution']}
		{assign var=resolution value=$resolutions[$assignment['id_resolution']]}
		{/if}
		{if $assignment['id_file']}
		{assign var=file value=$assignmentFiles->getByPk($assignment['id_file'])}
		{/if}
                {if $assignment['id_resolution_file']}
		{assign var=fileR value=$resolutionFiles->getByPk($assignment['id_resolution_file'])}
		{/if}
		<tr>
			<td colspan="4">
                             <table class="table">
                                <tr>
                                    <td><p>{if $resolution}{$resolution->getName()} - {/if}{$assignment['note']} </p></td>
{*                                    <td>{if $file}<a class="btn" href="{$baseUrl}/{str_replace('public/','',$file->getUri())}" target="_blank">{$i18n->_('Download')} {$i18n->_('File')}</a>{/if}</td>*}
                                    <td>{if $fileR}<a class="btn" href="{$baseUrl}/{str_replace('public/','',$fileR->getUri())}" download target="_blank">{$i18n->_('Download')} {$i18n->_('File')}</a>{/if}</td>
                                </tr>
                            </table>
				
			</td>
		</tr>
		{/foreach}
                
                
                
	</tbody>
</table>
<center><button class="btn default" name="regresar" id="regresar" onclick="history.back(1)">{$i18n->_('Back')}</button></center>
</div>