<div id="styledForm"><br /><h3>{$i18n->_('Reason')}</h3>
    {$form}
</div>
<div id="styledForm">
	<br>
	<h3>{$i18n->_('Reason')}</h3>
	<form class="validate" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/reasons/create">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input"> <input name="name" id="name" type="text" class="required">
				</span>
			</div>
<h5>{$i18n->_('Seleccione al menos un producto')}</h5>
			<table >
				
                                <tr>
							{foreach $products as $key => $product}
								<td> 
									<input type="checkbox" name="productsIds[]" id="product{$key}"  value="{$key}" >{$product->getName()}
								</td>							
							{/foreach}
				</tr>
			</table>
			</div>
				
				
				
			<div class="actions">

				<input name="send" id="send" value="{$i18n->_('Save')}" class="btn primary"
					type="submit">

				<button aria-disabled="false" role="button" name="cancel"
					id="cancel" type="button"
					class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">{$i18n->_('Cancel')}</span>
				</button>
			</div>
		</fieldset>
	</form>
</div>