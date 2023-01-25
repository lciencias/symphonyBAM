
{foreach $requiredDocuments as $requiredDocument}
<div class="clearfix" >
	<div>
		<label for="" class="label-name ">{$requiredDocument['name']}</label>
	</div>
	<span class="input"> 
		{if $uploadFiles}
			<input type="file" name="requiredDocuments{$requiredDocument['id_document']}" id="requiredDocuments{$requiredDocument['id_document']}" class="name-required-field  span4">
		{/if}
		{if isset($ticketClientDocuments[$requiredDocument['id_document']])}
			<a class="btn" target="_blank" href="{$baseUrl}/{str_replace('public/','',$ticketClientDocuments[$requiredDocument['id_document']])}">{$i18n->_('Download')}</a>
			
		{else}
					&nbsp;
			<button type="button" name="clear-{$requiredDocument['id_document']}" id="clear-{$requiredDocument['id_document']}" class="clear-required-field" style="width:40px;">{$i18n->_('-')}</button>
		
			<a class="btn disabled" disabled>{$i18n->_('File not set yet')}</a>
		{/if}
	</span>
</div>
{/foreach}