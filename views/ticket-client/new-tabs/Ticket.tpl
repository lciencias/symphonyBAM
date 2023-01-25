<div id="newTicketTab">
	<div class="tdcenter" style="text-align:center;">
		<span class="input" id="mensajeError" style="text-align:center;font-size:16px;color:#ff0000;"></span>
	</div>			     			     
	<form method="post" action="{$baseUrl}/ticket-client/{$onsubmit}" id="ticket-form" class="styledForm" enctype="multipart/form-data" style="width: 90% !important;">
		<input type="hidden" name="id_ticket_client" id="id_ticket_client" value="{$ticketClient['id_ticket_client']}">
		<input type="hidden" name="id_product" id="id_product" value="{$ticketClient['id_product']}">	
		<input type="hidden" name="id_product_bam" id="id_product_bam" value="{$idProductBam}">		
		<input type="hidden" name="email" id="email" value="{$ticketClient['email']}">	
		<input type="hidden" name="state_client" id="state_client" value="{$ticketClient['state_client']}">
		<input type="hidden" name="client_number" id="client_number" value="{$ticketClient['client_number']}">
		<input type="hidden" name="partialities" id="partialities" value="0">
		<input type="hidden" name="movments" id="movments" value="-1">
		<input type="hidden" name="name_client" id="name_client" value="{$ticketClient['name_client']}">
		<input type="hidden" name="employee" id="employee" value="{$ticketClient['employee']}">
		<input type="hidden" name="card_type" id="card_type" value="{$ticketClient['card_type']}">
		<input type="hidden" name="account_type" id="account_type" value="{$ticketClient['account_type']}">		
		<input type="hidden" name="no_card" id="no_card" value="{$ticketClient['no_card']}">
		<input type="hidden" name="chanel" id="chanel" value="{$ticketClient['chanel']}">
		<input type="hidden" name="clientCategoryHidden" id="clientCategoryHidden" value="0">
		<input type="hidden" name="folio_condusefEdit" id="folio_condusefEdit" value="{$ticketClient['folio_condusef']}">
		<input type="hidden" name="telefono" id="telefono" value="{$ticketClient['telefono']}">
		<input type="hidden" name="id_entidad" id="id_entidad" value="{$ticketClient['id_entidad']}">
		
		<fieldset>
			{if $ticketClient['id_ticket_type'] > 0}
				<div class="clearfix">
			   		<div>
			       		<label for="description" class="required" >
			       			<span style="font-size:14px;font-weight:bold;">{$i18n->_('Motive')}</span>
			           	</label>
					</div>
					<span style="font-size:14px;font-weight:bold;">{$category}</span>
				</div>						        
		    {/if} 	
		
			<div class="clearfix inicio" id="inicio">
				<div> 
			    	<label for="id_ticket_type" class="required">
			    		{$i18n->_('Ticket Type')}
			         </label>
			    </div>
			   	<span class="input">
			   	{if $ticketClient['id_ticket_type'] > 0}
			   		<input type="hidden" name="id_ticket_type" id="id_ticket_type" value="{$ticketClient['id_ticket_type']}">
			   		{if "ticket-client/ticket-legal"|isAllowed}		   		
			   			{html_options options=$ticketTypes name=id_ticket_type_tmp id=idTicketType_tmp class="span4 required" disabled="true" selected=$ticketClient['id_ticket_type']}
			   		{else}
						{html_options options=$ticketTypesJurid name=id_ticket_type_tmp id=idTicketType_tmp class="span4 required" disabled="true" selected=$ticketClient['id_ticket_type']}			   		
			   		{/if}
			   	{else}
			   		{if "ticket-client/ticket-legal"|isAllowed}
			   			{html_options options=$ticketTypes name=id_ticket_type id=idTicketType class="span4 required" selected=$ticketClient['id_ticket_type']}
			   		{else}
						{html_options options=$ticketTypesJurid name=id_ticket_type id=idTicketType class="span4 required" selected=$ticketClient['id_ticket_type']}			   		
			   		{/if}
			   	{/if}			             	
			    </span>
			</div>
			{if $onsubmit neq 'update'}
			<div class="clearfix inicio">
			    	<div>
			        	<label for="reason" class="required">
			            	{$i18n->_('Motive')}
			            </label>
			         </div>
			         <span class="input">
			         {if $complemento > 0}
			         	<input type="hidden" name="id_reason" id="id_reason" value="{$complemento}">
			         	{html_options options=$reasons name="id_reason_tmp" id="id_reason_tmp" selected=$complemento disabled="true" class="span4 required"}
			         {else}
			        	{html_options options=$reasons name="id_reason" id="id_reason" selected=$complemento class="span4 required"}
			        {/if}
					 </span>
				</div>				
			{/if}			
			<div id="transactionsTicket" style="display:none;">				
				<table class="table encabezado"><tr><td>{$i18n->_('Customer Statement Information')}</td></tr></table>
				<div id="transactionsTmp" style="display:none;overflow-y:scroll;height:160px;border:3px;">
					<table class="table" id="tableTransacctions">				
					</table>
				</div>				
				<table class="table" id="tableDes">
						<tr><td colspan="2"><span style="text-align:center;font-size:24px;" id="leyendaSaldo" class="leyendaSaldo"></span></td></tr>
						<tr id="descriptionFind" style="pointer: none;">
							<td>{$i18n->_('Description')}</td>
							<td><textarea name="descriptionConsulta" id="descriptionConsulta" class="form-control required" style="pointer:none;width:450px;height:120px;"></textarea>
							<span id="rdescriptionConsulta"></span></td>
						</tr>										
				</table><br>
				<table class="table">
				<tr>
						<td class="tdright">
							<button aria-disabled="false" role="button" name="OtraTransaction" id="OtraTransaction" 
									class="btn default otras ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
									<span class="ui-button-text">
										<img src="{$baseUrl}/images/template/icons/find.png">{$i18n->_('Other Inquiry')}
									</span>
							</button>&nbsp;&nbsp;
							<button aria-disabled="false" role="button" name="FinalTransaction" id="FinalTransaction" 
									class="btn default otras ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
									<span class="ui-button-text">
									<img src="{$baseUrl}/images/template/icons/find.png">{$i18n->_('End consultation')}
									</span>
							</button>&nbsp;&nbsp;
							<button aria-disabled="false" role="button"  name="btnTransaction" id="btnTransaction" 
								    class="btn primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
								<span class="ui-button-text">
									<img src="{$baseUrl}/images/template/icons/disk.png">{$i18n->_('Following')}
								</span>
							</button>&nbsp;&nbsp;
							<button aria-disabled="false" role="button"  name="btnTransactionRegresar" id="btnTransactionRegresar" 
							class="btn danger ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only regresaProductos">
								<span class="ui-button-text">
									<img src="{$baseUrl}/images/template/icons/arrow_undo.png">{$i18n->_('Back')}
								</span>							
							</button>
						</td>
					</tr>
				</table>
			</div>						
			
			
			<div id="newTicket" {if $onsubmit neq 'update'} style="display : none;"{/if}>
				<div class="clearfix">
		             <div>
		             	<label for="fid_channel" class="required">
		             		{$i18n->_('Channel')}
		             	</label>
		             </div>
		             <span class="input">
		             {if $onsubmit neq 'update'}
		             	{if $canalUser > 0}
			             	<input type="hidden" name="id_channel" id="id_channel" value="{$canalUser}">
			             	{html_options options=$channels name="id_channel_tmp" id="id_channel_tmp" class="span4 required" disabled="true" selected=$canalUser}
			             {else}
		    	         	{html_options options=$channels name="id_channel" id="id_channel" class="span4 required" selected=$ticketClient['id_channel']}
		        	     {/if}
		        	  {else}
		             	{if $ticketClient['id_channel'] > 0}
		             		{if $canalUser > 0}
			             		<input type="hidden" name="id_channel" id="id_channel" value="{$canalUser}">
			             	{else}
			             		<input type="hidden" name="id_channel" id="id_channel" value="{$ticketClient['id_channel']}">
			             	{/if}
			             	{html_options options=$channels name="id_channel_tmp" id="id_channel_tmp" class="span4 required" disabled="true" selected=$ticketClient['id_channel']}
			           {else}
		    	         	{html_options options=$channels name="id_channel" id="id_channel" class="span4 required" selected=$ticketClient['id_channel']}
		        	     {/if}		        	  
		        	  {/if}
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
		              {if $onsubmit neq 'update'}
							<input type="hidden" name="id_origin_branch" id="id_origin_branch" value="">
							{html_options options=$branches name=id_origin_branch_tmp id=id_origin_branch_tmp class="span4 required" disabled="true"}		              
		              {else}
			              {if $ticketClient['id_origin_branch'] > 0}
							<input type="hidden" name="id_origin_branch" id="id_origin_branch" value="{$ticketClient['id_origin_branch']}">
							{html_options options=$branches name=id_origin_branch_tmp id=id_origin_branch_tmp class="span4 required" disabled="true" selected=$ticketClient['id_origin_branch']}
			             {else}		             
			             	{html_options options=$branches name=id_origin_branch id=id_origin_branch class="span4 required" selected=$ticketClient['id_origin_branch']}
			             {/if}
			          {/if}
		             </span>
		         </div>
		         <div class="clearfix">
		             <div>
		             	<label for="id_ticket_type" class="required">
		             		{$i18n->_('Reported Branch')}
		             	</label>
		             </div>
		             <span class="input">
		         	{if $onsubmit neq 'update'}
			             {if $branchUser > 0}
							<input type="hidden" name="id_reported_branch" id="id_reported_branch" value="{$branchUser}">
							{html_options options=$branches name=id_reported_branch_tmp id=id_reported_branch_tmp class="span4 required" disabled="true" selected=$branchUser}
			             {else}		             
			             	{html_options options=$branches name=id_reported_branch id=id_reported_branch class="span4 required" selected=$ticketClient['id_reported_branch']}
			             {/if}		         	
		         	{else}
			             {if $ticketClient['id_reported_branch'] > 0}
							<input type="hidden" name="id_reported_branch" id="id_reported_branch" value="{$ticketClient['id_reported_branch']}">
							{html_options options=$branches name=id_reported_branch_tmp id=id_reported_branch_tmp class="span4 required" disabled="true" selected=$ticketClient['id_reported_branch']}
			             {else}		             
			             	{html_options options=$branches name=id_reported_branch id=id_reported_branch class="span4 required" selected=$ticketClient['id_reported_branch']}
			             {/if}
			         {/if}
		             </span>
		         </div>
		         
		         
		         {if $ticketClient['id_ticket_type'] eq '' and  $canalUser == 6} 
		         	{if "ticket-client/ticket-legal"|isAllowed}
		         		<div class="clearfix" id="condusef" style="display:none;">
							<div>
			             		<label for="account_number" class="required">
			             			{$i18n->_('Folio Condusef')}
				             	</label>	
				             </div>
				             <span class="input">
			             		<input type="text" placeholder="{$i18n->_('Folio Condusef')}" name="folio_condusef" id="folio_condusef" class="required span4 alfanumerico" value="{$ticketClient['folio_condusef']}">
					             <span id="error_folio_Conduset"></span>
							</span>
		         		</div>
		         	{/if}		         
		         {/if}
		         {if $ticketClient['id_channel'] == 6} 
		         	{if "ticket-client/ticket-legal"|isAllowed}
		         		<div class="clearfix">
							<div>
			             		<label for="account_number" class="required">
			             			{$i18n->_('Folio Condusef')}
				             	</label>	
				             </div>
				             <span class="input">
			             		<input type="text" placeholder="{$i18n->_('Folio Condusef')}" name="folio_condusef" id="folio_condusef" class="required span4 alfanumerico" value="{$ticketClient['folio_condusef']}" readonly>
					             <span id="error_folio_Conduset"></span>
							</span>
		         		</div>
		         	{/if}		         
		         {/if}

		         {if $ticketClient['id_ticket_type'] eq '' and  $ticketClient['id_channel'] eq ''} 
		        	 <div class="clearfix" id="condusefAjax" style="display:none;">
						<div>
			           		<label for="account_number" class="required">
			            			{$i18n->_('Folio Condusef')}
				           	</label>	
				         </div>
				         <span class="input">
			          		<input type="text" placeholder="{$i18n->_('Folio Condusef')}" name="folio_condusef" id="folio_condusef" class="required span4 alfanumerico" value="{$ticketClient['folio_condusef']}">
				            <span id="error_folio_Conduset"></span>
						</span>
		        	</div>	  
		        {/if}       
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
                <br><input type="hidden" name="number_files" id="number_files"/>
				<div class="clearfix">
			    	<div>
			        	<label for="description" class="required" >
			        		{$i18n->_('Description')}
			            </label>
			       </div>
			       <span class="input">
				   	<textarea name="description" id="description" class="required" style="width: 503px; height: 105px;">{$ticketClient['description']}</textarea>				   	
			        </span>
			        <span id="error_description"></span>
			    </div>
			    <div class="">
				{if !in_array($ticketClient['status'],['Closed','Canceled'])}
					{if $action eq 'new'}
						<button aria-disabled="false" role="button"
							class="btn primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
							name="guardar" id="guardar">
							<span class="ui-button-text" type="submit">
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
		         		{if $ticketClient['id_ticket_type'] != 3}
		            		{if "ticket-client/reopen"|isAllowed}<a href="{url action=reopen id=$ticketClient['id_ticket_client']}" id="reOpen" class="btn">{icon src="arrow_rotate_anticlockwise"}{$i18n->_('Reopen')}</a>{/if}
		            	{/if}		            		
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
			</div>
			{* añadio este tema *}
			<div id="findTicket" style="display : none">			
				<div class="clearfix" id="t_period">
			    	<div>
			        	<label for="period" class="required">
			            	{$i18n->_('Period')}
			            </label>
			         </div>
			         <span class="input">
			         	{html_options options=$periods name="period" id="period" selected=$params['period'] class="span4"}
					</span>
			    </div>			         
			    <div class="clearfix"  id="t_start_date">
			    	<div>
			        	<label for="From" class="required" >
			             	{$i18n->_('From')} 
			            </label>
			        </div>
			        <span class="input">
				    	<input type="text" name="start_date" id="start_date" value="{$params['start_date']}" class="datepicker validDates span3"/></td>
			        </span>
			    </div>
		        <div class="clearfix" id="t_end_date">
			    	<div>
			        	<label for="Until" class="required" >
			        		{$i18n->_('Until')} 
			            </label>
			        </div>
			        <span class="input">
				    	<input type="text" name="end_date" id="end_date" value="{$params['end_date']}" class="datepicker validDates span3"/>
			         </span>
			     </div>
			     <div class="clearfix">
			    	<div>
			        	<label for="From" class="required" >&nbsp;</label>
			        </div>
			     	<span class="input">
			     		<button aria-disabled="false" role="button"
							class="btn primary ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
							name="find" id="find">
							<span class="ui-button-text">
								<img src="{$baseUrl}/images/template/icons/disk.png">{$i18n->_('Following')}
							</span>
						</button>
						&nbsp;&nbsp;
						<button aria-disabled="false" role="button" id="cancelNew"
							type="button"
							class="btn danger ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only regresaProductos">
							<span class="ui-button-text">
								<img src="{$baseUrl}/images/template/icons/arrow_undo.png">{$i18n->_('Back')}
							</span>
						</button>
					</span>			     
			     </div>
			</div>
		</fieldset>
	</form>
</div>

