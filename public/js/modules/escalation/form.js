$(document).ready(function(){
    
    var refreshAutocomplete = function(){
        
        var changeHandler = function( event, ui ) {
            if( ui.item ){
                $(this).val(ui.item.label);
                $(this).parents('span').find('input.value').val(ui.item.value);
                return false;
            }    
        } 
        
        $( ".autocompleteEmployee" ).autocomplete({
            source: baseUrl + "/escalation/get-employees",
            minLength: 2,
            focus: changeHandler,
            select: changeHandler 
        });
        
    };
    
    refreshAutocomplete();
    
    $('#addEscalation').click(function(){
        var first = $('#container span').get(0);
        var clon = $(first).clone();
        
        clon.find('input[type=text]').val('');
        
        i++;
        clon.find('input, select').each(function(index, item){
            var prefix = $(item).attr('dataindex');
            $(item).attr('id', prefix + i);
            $(item).attr('name', prefix + "[" + i + "]");
        });
        
        $('#container').append(clon);
        refreshAutocomplete();
        $('form.validate').validate();
    });
    
    $('.removeEscalation').live('click', function(){
        if($('#container span').length != 1)
          $(this).parent().remove();
    });
    
    var visibilityHandler =  function(element){
        var val = $(element).val();
        var autocompleteEmployee = $(element).parents('span').find('input.autocompleteEmployee');
        var valueInput = $(element).parents('span').find('input.value');
        
        if( val == 1 ){
            autocompleteEmployee.css('display', 'inline-block');
            valueInput.css('display', 'none');
        }else if( val == 2){
            autocompleteEmployee.css('display', 'none');
            valueInput.css('display', 'inline-block');
        }else if( val == 3){
            autocompleteEmployee.css('display', 'none');
            valueInput.css('display', 'none');
            valueInput.val('1');
        }else{
            alert("El tipo especificado no existe");
        }
    }
    
    $('.typeButton').live('click', function(){
        visibilityHandler(this);
    });
    
    $('.typeButton').each(function(index, item){
        visibilityHandler(item);
    });
    
});

