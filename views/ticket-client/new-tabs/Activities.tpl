<div id="activitiesTab">
	<table class="zebra-striped bordered-table">
		<caption>
			<h3>{$i18n->_('Activities')}</h3>
		</caption>
		<thead>
			<tr>
				<th width="5%">#</th>
				<th width="15%">{$i18n->_('User')}</th>
				<th>{$i18n->_('Start Date')}</th>
				<th>{$i18n->_('End Date')}</th>
				<th>{$i18n->_('Note')}</th>
			</tr>
		</thead>
		<tbody>
			{foreach $activities as $activity}
			<tr>
				<td>{$activity['id_activity']}</td>
				<td>{$activity['id_user']}</td>
				<td>{$activity['start_date']}</td>
				<td>
				{if $activity['end_date']}
					{$activity['end_date']}
				{else}
					{if 'activity/end-activity'|isAllowed}
						<a class="btn primary" href="{$baseUrl}/activity/end-activity/id/{$activity['id_activity']}">{$i18n->_('Save')} {$i18n->_('End Date')}</a>
					{/if}
				{/if}				
				</td>
				<td>{$activity['note']}</td>
			</tr>
			{/foreach}
		</tbody>
	</table>

{if 'ticket-client/comments'|isAllowed}
		<div id="commentsTab">
			<table class="zebra-striped bordered-table">
				<caption>
					<h3>{$i18n->_('Comments')}</h3>
				</caption>
				<thead>
					<tr>
						<th width="5%">#</th>
						<th width="15%">{$i18n->_('User')}</th>
						<th>{$i18n->_('Date')}</th>
						<th>{$i18n->_('Comment')}</th>
					</tr>
				</thead>
				<tbody>
					{foreach $arrayComments as $comment}
					<tr>
		                            {assign var="name" value=$comment['name']|cat:" "|cat:$comment['last_name']|cat:" "|cat:$comment['middle_name']} 
						<td>{$comment['id_comment']}</td>
						<td>{$name}</td>
						<td>{substr($comment['creation_date'],0,19)}</td>
						<td>{$comment['note']}</td>
					</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
{/if}
{if 'ticket-client/tracking'|isAllowed}
		<div id="trackingTab">
			<table class="zebra-striped bordered-table">
				<caption>
					<h3>{$i18n->_('Tracking')}</h3>
				</caption>
				<thead>
					<tr>
						<th width="5%">#</th>
						<th width="15%">{$i18n->_('User')}</th>
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
						<td>{$tracking['date_log']|date_format:"%d-%m-%Y %H:%M:%S"}</td>
					</tr>
				{/foreach}
					<thead>
					<tr>
						<th colspan="4" class="center">{$i18n->_('Resolutions')}</th>
					</tr>
					</thead>
					<tbody>
		            {foreach $assignments as $assignment}
		            	{if $assignment['id_resolution'] > 0}
		            		{assign var=resolution value=0}
		            		{assign var=file value=0}
		            		{assign var=fileR value=''}
		            	
							{if $assignment['id_resolution']}
								{$resolution = $resolutions[$assignment['id_resolution']]}
							{/if}
							{if $assignment['id_file']}
								{$file = $assignmentFiles->getByPk($assignment['id_file'])}
							{/if}
				            {if $assignment['id_resolution_file']}
								{$fileR = $resolutionFiles->getByPk($assignment['id_resolution_file'])}
							{/if}					
							<tr>
		                    	<td colspan="2"><p>{if $resolution}{$resolution->getName()} - {/if}{$assignment['note']} </p></td>
		                    	<td><p>{if $resolution}{$i18n->_('Date of resolution')}: {$assignment['resolution_date']|date_format:"%d-%m-%Y %H:%M:%S"}{/if} </p></td>
		                        <td>
								{if $file >0}
									<a class="btn" href="{$baseUrl}/{str_replace('public/','',$file->getUri())}" download target="_blank">{$i18n->_('Download evidence')}</a>
								{/if}
								{if $assignment['id_resolution_file'] >0}
									<a class="btn" href="{$baseUrl}/{str_replace('public/','',$fileR->getUri())}" download target="_blank">{$i18n->_('Download resolutory letter')}</a>
								{/if}
								</td>
							</tr>
						{/if}
					{/foreach}
				</tbody>
			</table>
		</div>
	{/if}
	<center>
		<button aria-disabled="false" role="button" id="cancel" type="button" class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
			<span class="ui-button-text">
				<img src="{$baseUrl}/images/template/icons/arrow_undo.png">{$i18n->_('Back')}
			</span>
		</button>		
	</center>
</div>