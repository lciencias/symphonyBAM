{*<div id="styledForm"><br /><h3>{$i18n->_('Reason')}</h3>
    {$form}
</div>*}
<script type="text/javascript" src="{$baseUrl}/js/modules/reason/index.js"></script>

<script>
    $(document).ready(function(){
    $("#cancel").click(function(event){
        event.preventDefault();
    location.href=baseUrl+"/reasons/list";
    })
    });
    
</script>
{if $errors}
    <div class="alert-message error">{$errors}</div>
{/if}
<div id="styledForm">
	<br>
	<h3>{$i18n->_('Reason')}</h3>
	<form class="validate" id="reasonForm" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/reasons/edit">
		<fieldset>
                        <input name="id" id="id" value="{$reason->getIdReason()}"type="hidden">
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input"> <input name="name" id="name" type="text" value="{$reason->getName()}" class="required">
				</span>
			</div>
                        <div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Type')}</label>
				</div>
				<span class="input"> {html_options name=type class='span4' id=type options=$typeReason selected=$reason->getType()}
				</span>
			</div>
                        {if $reason->getType()==0}        
                        <div class="clearfix" id="divSubtype">
                            {else}
                                <div class="clearfix" id="divSubtype" style="display: none;">
                        {/if}  
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Subtipo')}</label>
				</div>
				<span class="input"> {html_options name=subtype class='span4' id=subtype options=$subtype selected=$reason->getSubtype()}
				</span>
			</div>
                        {if $reason->getSubtype()==4}        
                        <div class="clearfix"  id="divNumMovs">
                            {else}
                            <div class="clearfix"  id="divNumMovs" style="display: none;">
                        {/if}    
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Número de movimientos')}</label>
				</div>
                                        <span class="input"> <input name="movments" id="movments" value="{$reason->getMovments()}" type="text" class="required" maxlength="5">
				</span>
			</div>        
                                
                        <div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Partialities')}</label>
				</div>
                                <span class="input"> <input type="checkbox" name="partialities" id="partialities" value="1" {if $reason->getPartialities()==1}checked="checked"{/if} >
				</span>
			</div>
                        <div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Movimientos financieros')}</label>
				</div>
                                <span class="input"> <input type="checkbox" name="financial_movement" id="financial_movement" value="1" {if $reason->getFinancialMovement()==1}checked="checked"{/if}  >
				</span>
			</div>        
<h5>{$i18n->_('Seleccione al menos un producto')}</h5>
			<table >
				
                                <tr>
							{foreach $products as $key => $product}
								<td> 
									<input type="checkbox" name="productsIds[]" id="product{$key}"  value="{$key}" {if in_array($key,$listProducts)}checked="checked"{/if}>{$product->getName()}
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