<style rel="stylesheet" type="text/css">
.table th,
.table td {
  padding: 8px;
  line-height: 20px;
  text-align: left;
  vertical-align: top;
  border-top: 0;
}
.error{
border-color:Red;
border-style:solid;
border-width:1px;
}
</style>

<script>
    $(document).ready(function () {
    	$("#send").click(function(){
			var number=$('.productstat:checkbox:checked').length;
			if(number==0){
				error("Seleccione al menos un producto");
            	return false
			}
		});
    /*$('#savecategory').validate({ // initialize the plugin
        rules: {
            'productsIds[]': {
                required: true,
            }
        },
        highlight: function(element) {
                 $(element).closest('input').addClass('error');
             },
             unhighlight: function(element) {
                 $(element).closest('input').removeClass('error');
             },
             errorElement: 'span',
             errorClass: 'error',
             errorPlacement: function(error, element) {
                 if(element.parent('.input-group').length) {
                     error.insertAfter(element.parent());
                 } else {
                     error.insertAfter(element);
                 }
             },
        submitHandler: function (form) { // for demo
            $('#savecategory').submit();
        }
    });*/
    
    $("#subtype").change(function(){
            id=$(this).val();
            $("#divNumMovs").hide();
            if(id == 4)
              $("#divNumMovs").show();   
            else{
                $("#movments").val('');
                $("#divNumMovs").hide();
            }
    });
    
    $("#financial_movement").click(function(){
    	$(".nvos").hide();
    	$('#product').val('');
    	$('#motive').val('');
    	$('#channel').val('');
    	if( $('#financial_movement').prop('checked') ) {
    		$(".nvos").show();
    	}
    });
    
    $("#sendG").click(function(){
    	if( $('#financial_movement').prop('checked') ) {
    		if(String($('#product').val().trim()) === ''){
    			error("El campo producto es obligatorio");
    			return false;
    		}
    		if(String($('#motive').val().trim()) === ''){
    			error("El campo motivo es obligatorio");
    			return false;
    		}
    		if(String($('#channel').val().trim()) === ''){
    			error("El campo Canal es obligatorio");
    			return false;
    		}

    	}
    });
    
        var logo    = baseUrl +'/images/logos/logo.png';

        function error( mensaje){
			$.gritter.add({
	    	    title: I18n._('BAM'),
	        	image: logo,
	        	text: mensaje,
	        	sticky: false,
	        	time: 1500,
	        	position: 'center'
	    	});
	    	return false;
		}        
});
</script>
<div id="styledForm" style="width : 100%; margin-left : 0">
	<br>
	<h3>{$i18n->_('Category')}</h3>
	<form id="savecategory" enctype="application/x-www-form-urlencoded"
		method="post" action="{$baseUrl}/client-category/{$onsubmit}/id/{$category['id_client_category']}">
		<fieldset>
			<input name="id_parent" value="{$category['id_parent']}" id="id_parent" type="hidden">
			<input name="id_ticket_type" value="{$category['id_ticket_type']}" id="id_ticket_type" type="hidden">
			<div class="clearfix">
				<div id="name-label">
					<label for="name" class="required">{$i18n->_('Name')}</label>
				</div>
				<span class="input"> <input name="name" id="name"
					value="{$category['name']}" type="text" class="required">
				</span>
			</div>

			<div class="clearfix">
				<div id="id_escalation-label">
					<label for="id_escalation" class="required">{$i18n->_('Escalation')}</label>
				</div>
				<span class="input"> 
					{html_options options=$escalations name="id_escalation" id="id_escalation" selected=$category['id_escalation'] class="span4 required"}
				</span>
			</div>
			<div class="clearfix">
				<div id="id_group-label">
					<label for="id_group" class="required">{$i18n->_('Group')}</label>
				</div>
				<span class="input"> 
					{html_options options=$groups name="id_group" id="id_group" selected=$category['id_group'] class="span4 required"}
				</span>
			</div>
			<div class="clearfix">
				<div id="id_service_level-label">
					<label for="id_service_level" class="required">{$i18n->_('Service Level')}</label>
				</div>
				<span class="input">
					{html_options options=$serviceLevels name="id_service_level" id="id_service_level" selected=$category['id_service_level'] class="span4 required"}
				</span>
			</div>
                        {if $category['id_ticket_type']==4 || $category['id_ticket_type']==3 || $category['id_ticket_type']==2 || $idTicketType==4 || $idTicketType==3 || $idTicketType==2}
                                {if $category['id_ticket_type']==3}
                                <div class="clearfix" id="divSubtype">
                                    <div id="name-label">
                                            <label for="name" class="required">{$i18n->_('Subtype')}</label>
                                    </div>
                                    <span class="input"> {html_options name=type class='span4' id=subtype options=$subtype selected=$category['type']}
                                    </span>
                                </div>
                                {/if}    
                                {if $category['type']==4 || $category['type']==2}        
                                    <div class="clearfix"  id="divNumMovs">
                                {else}
                                    <div class="clearfix"  id="divNumMovs" style="display: none;">
                                {/if} 
                                    <div id="name-label">
                                            <label for="name" class="required">{$i18n->_('Number of Movements')}</label>
                                    </div>
                                            <span class="input"> <input name="movments" id="movments" value="{$category['movments']}" type="text" class="required" maxlength="5">
                                    </span>
                                </div>        
                                <div class="clearfix">
                                        <div id="name-label">
                                                <label for="name" class="required">{$i18n->_('Partialities')}</label>
                                        </div>
                                        <span class="input"> <input type="checkbox" name="partialities" id="partialities" value="1" {if $category['partialities']==1}checked="checked"{/if} >
                                        </span>
                                </div>
                                <div class="clearfix"  id="divNumMovs">
                                        <div id="name-label">
                                                <label for="name" class="required">{$i18n->_('Financial Movements')}</label>
                                        </div>
                                        <span class="input"> <input type="checkbox" name="financial_movement" id="financial_movement" value="1" {if $category['financial_movement']==1}checked="checked"{/if}  >
                                        </span>
                                </div>               
                                
                                
                        {/if}              
            {if $category['financial_movement'] eq 1}
				<div class="clearfix nvos" style="display:block;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Product')}</label>
					</div>
					<span class="input">
						<input name="product" id="product" value="{$category['product']}" type="text" class="required" maxlength="25">
					</span>
				</div>
				<div class="clearfix nvos"  style="display:block;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Motive')}</label>
					</div>
					<span class="input">
						<input name="motive" id="motive" value="{$category['motive']}" type="text" class="required" maxlength="25">
					</span>
				</div>
				<div class="clearfix nvos"  style="display:block;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Channel')}</label>
					</div>
					<span class="input">
						<input name="chanel" id="chanel" value="{$category['chanel']}" type="text" class="required" maxlength="25">
					</span>
				</div>
			{else}
				<div class="clearfix nvos" style="display:none;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Product')}</label>
					</div>
					<span class="input">
						<input name="product" id="product" value="{$category['product']}" type="text" class="required" maxlength="25">
					</span>
				</div>
				<div class="clearfix nvos"  style="display:none;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Motive')}</label>
					</div>
					<span class="input">
						<input name="motive" id="motive" value="{$category['motive']}" type="text" class="required" maxlength="25">
					</span>
				</div>
				<div class="clearfix nvos"  style="display:none;">
					<div id="note-label">
						<label for="note" class="optional">{$i18n->_('Channel')}</label>
					</div>
					<span class="input">
						<input name="chanel" id="chanel" value="{$category['chanel']}" type="text" class="required" maxlength="25">
					</span>
				</div>
			
			{/if}
			                        
                                
			<div class="clearfix">
				<div id="note-label">
					<label for="note" class="optional">{$i18n->_('Note')}</label>
				</div>
				<span class="input"> <textarea name="note" id="note" cols="30"
						rows="5" class="">{$category['note']}</textarea>
				</span>
			</div>
			
			
		
			<div class="clearfix">
			<table>
				<tr>
					<td style="width: 135px;  text-align: right; margin-right: 30px;">
						<label for="note" class="">{$i18n->_('Required Fields')}</label>
					</td>
					<td style="padding-top : 0">
						<table class="table">
							<tr>
							{$i = 0}
							{foreach $fields as $key => $field}
								{$i = $i + 1}
								<td> 
									<input type="checkbox" name="requiredFields[]" id="requiredField{$i}" class="" value="{$key}" {if in_array($key,$requiredFields)}checked{/if}>{$field}
								</td>
								{if !($i mod 5)}
							</tr><tr>
								{/if}
							{/foreach}
						</table>
					</td>
				</tr>
			</table>
			</div>
						
			<div class="clearfix">
			<table>
				<tr>
					<td style="width: 135px;  text-align: right; margin-right: 30px;">
						<label for="note" class="">{$i18n->_('Required Documents')}</label>
					</td>
					<td style="padding-top : 0">
						<table class="table">
							<tr>
							{$i = 0}
							{foreach $documents as $key => $document}
								{$i = $i + 1}
								<td> 
									<input type="checkbox" name="requiredDocuments[]" id="requiredDocument{$i}" class="" value="{$key}" {if in_array($key,$requiredDocuments)}checked{/if}>{$document}
								</td>
								{if !($i mod 5)}
							</tr><tr>
								{/if}
							{/foreach}
						</table>
					</td>
				</tr>
			</table>
			</div>
                                                
                        <div class="clearfix">
			<table>
				<tr>
					<td style="width: 135px;  text-align: right; margin-right: 30px;">
						<label for="note" class="">{$i18n->_('Products')}</label>
					</td>
					<td style="padding-top : 0">
						<table class="table">
							<tr>
							{$i = 0}
							{foreach $products as $key => $product}
								{$i = $i + 1}
								<td> 
									<input type="checkbox" class="productstat" name="productsIds[]" id="product{$key}"  value="{$key}" {if in_array($key,$listProducts)}checked="checked"{/if}>{$product->getName()}
								</td>
								{if !($i mod 5)}
							</tr><tr>
								{/if}
							{/foreach}
						</table>
					</td>
				</tr>
			</table>
			</div>                        
				
				
			<div class="clearfix">
			<table >
				<tr >
					<td style="width: 135px;  text-align: right; margin-right: 30px;">
						<label for="note" class="">{$i18n->_('Resolutions')}</label>
					</td>
					<td style="padding-top : 0">
						<table class="table">
							<tr><td><strong>{$i18n->_('Favorables')}</strong></td></tr>
							{foreach $favorableResolutions as $key => $resolution}
							<tr>
								<td> 
									<input type="checkbox" name="resolutions[]" id="resolution{$i}" class="required" value="{$key}" {if in_array($key,$clientCategoryResolutions)}checked{/if}>{$resolution}
								</td>
							</tr>
							
							{/foreach}
						</table>
					</td>
					<td style="padding-top : 0">
						<table class="table">
						<tr><td><strong>{$i18n->_('Desfavorables')}</strong></td></tr>
							{foreach $unfavorableResolutions as $key => $resolution}
							<tr>
								<td> 
									<input type="checkbox" name="resolutions[]" id="resolution{$i}" class="required" value="{$key}" {if in_array($key,$clientCategoryResolutions)}checked{/if}>{$resolution}
								</td>
							</tr>
							
							{/foreach}
						</table>
					</td>
				</tr>
				
			</table>
			</div>
				
				
				
			<div class="actions">

				<input name="send" id="sendG" value="{$i18n->_('Save')}" class="btn primary validaSend"
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