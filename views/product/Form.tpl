<div id="styledForm">
	<br>
	<h3>{$i18n->_('Name')}</h3>
	<form class="validate" method="post" action="{$baseUrl}/product/save">
	<input type="hidden" name="id_product" value="{$product->getIdProduct()}">
		<fieldset>
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input"> <input name="name" id="name" value="{$product->getName()}" type="text"  class="required" disabled="true"></span>
			</div>
			<div class="clearfix">
                <div id="name-label">
                    <label for="name" class="required">{$i18n->_('Id Bam')}</label>
                </div>
                <span class="input"> <input name=id_product_bam id="id_product_bam" value="{$product->getIdProductBam()}" type="text" class="required digits" disabled="true"></span>
            </div>
            
            <div class="clearfix">
                <div id="name-label">
                    <label for="name" class="required">{$i18n->_('Description')}</label>
                </div>
                <span class="input"> <textarea rows="6" cols="40" name="description" id="description">{$product->getDescription()}</textarea></span>
            </div>
            
            <div class="clearfix">
                <div id="name-label">
                    <label for="name" class="required">{$i18n->_('Commissions')}</label>
                </div>
                <span class="input"> 
		<textarea rows="6" cols="40" name="commissions" id="commissions">{$product->getCommissions()}</textarea>
            </div>
            
            <div class="clearfix">
                <div id="name-label">
                    <label for="name" class="required">{$i18n->_('Requirements')}</label>
                </div>
                <span class="input"> 
		<textarea rows="6" cols="40" name="requirements" id="requirements">{$product->getRequirements()}</textarea>
		</span>
            </div>
			<div class="actions">
				<input value="{$i18n->_('Save')}" class="btn primary" type="submit">
				<button aria-disabled="false" role="button" name="cancel" id="cancel" type="button" class="btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">
					<span class="ui-button-text">Cancelar</span>
				</button>
			</div>
		</fieldset>
	</form>
</div>