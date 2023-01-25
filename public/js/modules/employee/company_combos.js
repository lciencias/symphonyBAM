function clean(combo){
    while(combo.length > 0){
        combo.remove(combo.length -1);
    }
}

$(document).ready(function(){
    var lastId = null;
    var selectedIdCompany = $("#id_company").val();
    
    $("#id_company").click(function(){
        
        if( lastId == $("#id_company").val() ){
            return false;
        } 
        lastId = $("#id_company").val(); 
        
        if( $("#id_company").val() != '' ){
            
        	var isFirstSelectedIdCompany = lastId == selectedIdCompany;
            if( $('#id_position').length > 0 ){
                $.get(
                        
                    $('#id_position').attr('ajax_url'),
                    {
                        id: $(this).val(),
                        selected_id: isFirstSelectedIdCompany ? $('#id_position').attr('selected_id') : null
                    },
                    
                    function(json){
                        var ca = eval(json);
                        combo2 = document.getElementById('id_position');
                        if( combo2 ){
                            clean(combo2);
                            
                            for(var i=0; i<ca.length; i++){
                                combo2.options[i] = new Option( ca[i].position,  ca[i].id);
                            }
                            
                            var selected = $('#id_position').attr('selected_id');
                            if( selected > 0 ){
                                $('#id_position').val(selected);
                            }
                        }
                 });    
            }
            
            if( $('#id_area').length > 0 ){
                $.get(
                        
                    $('#id_area').attr('ajax_url'),
                    {
                        id: $(this).val(),
                        selected_id: isFirstSelectedIdCompany ? $('#id_area').attr('selected_id') : null
                    },
                    
                    function(json){
                        var ca = eval(json);
                        combo2 = document.getElementById('id_area');
                        if( combo2 ){
                            clean(combo2);
                            
                            for(var i=0; i<ca.length; i++){
                                combo2.options[i] = new Option( ca[i].area,  ca[i].id);
                            }
                            
                            var selected = $('#id_area').attr('selected_id');
                            if( selected > 0 ){
                                $('#id_area').val(selected);
                            }
                        }    
                });    
            }
            
            
            if( $('#id_location').length > 0 ){
                $.get(
                        
                    $('#id_location').attr('ajax_url'),
                    {
                        id: $(this).val(),
                        selected_id: isFirstSelectedIdCompany ? $('#id_location').attr('selected_id') : null  
                    },
                    
                    function(json){
                        var ca = eval(json);
                        combo2 = document.getElementById('id_location');
                        if( combo2 ){
                            clean(combo2);
                            
                            for(var i=0; i<ca.length; i++){
                                combo2.options[i] = new Option( ca[i].location,  ca[i].id);
                            }
                            
                            var selected = $('#id_location').attr('selected_id');
                            if( selected > 0 ){
                                $('#id_location').val(selected);
                            }
                            
                        }    
                  });
                }    
            }
            
        });
        
        $('#id_company').click();
});