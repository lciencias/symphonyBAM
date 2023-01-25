<div id="newTicketTab"> 
			<form method="post" action="{$baseUrl}/ticket-client/{$onsubmit}" id="ticket-form" class="styledForm" enctype="multipart/form-data" style="width: 90% !important;">
			<input type="hidden" name="id_ticket_client" id="id_ticket_client" value="{$ticketClient['id_ticket_client']}">
				<fieldset>
					 <div class="clearfix">
			             <div>
			             	<label for="id_ticket_type" class="required">
			             		{$i18n->_('Ticket Type')}
			             	</label>
			             </div>
			             <span class="input">
			             {if $action eq 'new'}
			             {html_options options=$ticketTypes name=id_ticket_type id=idTicketType class="span4 required" selected=$ticketClient['id_ticket_type']}
			             {else}
			             {html_options options=$ticketTypes name=id_ticket_type id=idTicketType class="span4 required" selected=$ticketClient['id_ticket_type'] disabled}
			             {/if}
			             	
			             </span>
			         </div>
			         <div class="clearfix">
			             <div>
			             	<label for="id_channel" class="required">
			             		{$i18n->_('Channel')}
			             	</label>
			             </div>
			             <span class="input">
			             	{html_options options=$channels name="id_channel" id="id_channel" class="span4 required" selected=$ticketClient['id_channel']}
						</span>
			         </div>
			         <div class="clearfix">
			             <div>
			             	<label for="account_number" class="required">
			             		{$i18n->_('Account Number')}
			             	</label>
			             </div>
			             <span class="input">
			             	<input type="text" name="account_number" id="account_number" class="required span4" value="{$ticketClient['account_number']}" readonly>
						</span>
			         </div>
			         <div class="clearfix">
			             <div>
			             	<label for="id_ticket_type" class="required">
			             		{$i18n->_('Origin Branch')}
			             	</label>
			             </div>
			             <span class="input">
			             	{html_options options=$branches name=id_origin_branch id=id_origin_branch class="span4 required" selected=$ticketClient['id_origin_branch']}
			             </span>
			         </div>
			         <div class="clearfix">
			             <div>
			             	<label for="id_ticket_type" class="required">
			             		{$i18n->_('Reported Branch')}
			             	</label>
			             </div>
			             <span class="input">
			             	{html_options options=$branches name=id_reported_branch id=id_reported_branch class="span4 required" selected=$ticketClient['id_reported_branch']}
			             </span>
			         </div>
			         
				       <table>
					       <tbody>
						        <tr>
						            <td>
							            <label for="id_category" class="required">
							            	{$i18n->_('Category')}
							            </label>
						            </td>
						            <td>
						            </td>
						            <td> 
						            	<span class="input">
						            		{if $action eq 'new'}
						            		{foreach $nestedCategories as $idTicketClient => $nestedCategory}
								            <div style="width: 500px; max-height: 500px;  text-align: left; overflow: auto; display : none;" id="ticketType{$idTicketClient}" class="ticketType">
									            {render_client_categories nestedCategories=$nestedCategory renderer=select selected=$ticketClient['id_client_category']}
											</div>		
											{/foreach}
											<br><input type="hidden" name="clientCategoryHidden" id="clientCategoryHidden" class="required"/>						            
											{else}
								            {$category}
								            {/if}
						            	</span>
						            </td>
						          
						        </tr>
					        </tbody>
				      </table>
				      
				      
			    	<div id="requiredFieldsContainer">
			    		{if $action neq 'new'}
			    		{include file="ticket-client/Required-fields.tpl"}
			    		{/if}
			    	</div>
			    	<div id="requiredDocumentsContainer">
			    		{if $action neq 'new'}
			    		{include file="ticket-client/Required-documents.tpl"}
			    		{/if}
			    	</div>
			    	{* añadio este tema *}
			    	<div class="clearfix">
			             <div>
			             	<label for="reason" class="required">
			             		{$i18n->_('Motive')}
			             	</label>
			             </div>
			             <span class="input">
			             	{html_options options=$reasons name="id_reason" id="id_reason" selected=$params['id_reason'] class="span4"}
						</span>
			         </div>
					<div class="clearfix">
			             <div>
			             	<label for="period" class="required">
			             		{$i18n->_('Period')}
			             	</label>
			             </div>
			             <span class="input">
			             	{html_options options=$periods name="period" id="period" selected=$params['period'] class="span4"}
						</span>
			         </div>			         
			         <div class="clearfix">
			             <div>
			             		<label for="From" class="required" >
			             			{$i18n->_('From')} 
			             		</label>
			             	</div>
			             <span class="input">
				             <input type="text" name="start_date" id="start_date" value="{$params['start_date']}" class="datepicker validDates span3 required"/></td>
			             </span>
			         </div>
			         <div class="clearfix">
			             <div>
			             		<label for="Until" class="required" >
			             			{$i18n->_('Until')} 
			             		</label>
			             	</div>
			             <span class="input">
				             <input type="text" name="end_date" id="end_date" value="{$params['end_date']}" class="datepicker validDates span3 required"/>
			             </span>
			         </div>
			    	{* fin de lo añadido *}
			    	
			    	
			         <div class="clearfix">
			             <div>
			             		<label for="description" class="required" >
			             			{$i18n->_('Description')}
			             		</label>
			             	</div>
			             <span class="input">
				             <textarea name="description" id="description" class="required" style="width: 503px; height: 105px;">{$ticketClient['description']}</textarea>
			             </span>
			         </div>
	
					<div class="">
						{if !in_array($ticketClient['status'],['Closed','Canceled'])}
						{if $action eq 'new'}
							 
						<button aria-disabled="false" role="button"
							class="btn primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
							name="send" id="send">
							<span class="ui-button-text">
								<img src="{$baseUrl}/images/template/icons/disk.png">{$i18n->_('Save')}
							</span>
						</button>
						{else if 'ticket-client/update'|isAllowed}
							{if $modifyTicket}
						<button aria-disabled="false" role="button"
							class="btn primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
							name="send" id="send">
							<span class="ui-button-text">
								<img src="{$baseUrl}/images/template/icons/disk.png">{$i18n->_('Save')}
							</span>
						</button>
							{/if}
						{/if}
							
						{/if}
						{if $action eq 'new'}
							<button aria-disabled="false" role="button" id="cancelNew"
								type="button"
								class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only regresaProductos">
								<span class="ui-button-text">
									<img src="{$baseUrl}/images/template/icons/arrow_undo.png">{$i18n->_('Back')}
								</span>
							</button>
						{else}
							<button aria-disabled="false" role="button" id="cancel"
								type="button"
								class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
								<span class="ui-button-text">
									<img src="{$baseUrl}/images/template/icons/arrow_undo.png">{$i18n->_('Back')}
								</span>
							</button>						
						{/if}
						{if $ticketMachine["Cancel"]}
		                    {if "ticket-client/cancel"|isAllowed}
		                    <a href="{url action=cancel id=$ticketClient['id_ticket_client']}" id="cancelTicket" class="btn confirm" data-confirm-title="{$i18n->_('Cancel Ticker')}" data-confirm-message="{$i18n->_('This ticket will be canceled. Are you sure?')}">{icon src=cancel}{$i18n->_('Cancel Ticket')}</a>
							{/if}
		                  {/if}
		                  {if $ticketMachine["Work"]}
		                    {if "ticket-client/work"|isAllowed}<a href="{url action=work id=$ticketClient['id_ticket_client']}" id="" class="btn">{icon src=working}{$i18n->_('Working')}</a>{/if}
		                  {/if}
		                  {if $ticketMachine["Open"]}
		                    {if "ticket-client/reopen"|isAllowed}<a href="{url action=reopen id=$ticketClient['id_ticket_client']}" id="" class="btn">{icon src="arrow_rotate_anticlockwise"}{$i18n->_('Reopen')}</a>{/if}
		                  {/if}
		                  {if $ticketMachine["Close"]}
		                    {if "ticket-client/close"|isAllowed}<a href="{url action=close id=$ticketClient['id_ticket_client']}" id="" class="btn">{icon src=accept}{$i18n->_('Close Ticket')}</a>{/if}
		                  {/if}
			              {if !in_array($ticketClient['status'], ['Unread', 'Closed'])}
			                  {if $ticketClient['is_stopped']}
			                    {if "ticket-client/resume"|isAllowed}<a href="{url action=resume id=$ticketClient['id_ticket_client']}" class="btn">{icon src=control_play_blue}{$i18n->_('Resume')}</a>{/if}
			                  {else if $action neq 'new'}
			                    {if "ticket-client/pause"|isAllowed}<a href="{url action=pause id=$ticketClient['id_ticket_client']}" class="btn">{icon src=control_pause_blue}{$i18n->_('Pause')}</a>{/if}
		                  {/if}
		                {/if}
					</div>
				</fieldset>
			</form>
		</div>