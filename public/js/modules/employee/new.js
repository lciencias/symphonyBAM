$(document).ready(function(){

    $('#addPhone').click(function(){
        var first = $('#containerPhone span').get(0);
        var clon = $(first).clone();
        
        clon.find('input[type=text]').val('');
        
        i++;
        clon.find('input, select').each(function(index, item){
            var prefix = $(item).attr('dataindex');
            $(item).attr('id', prefix + i);
            $(item).attr('name', prefix + "[" + i + "]");
        });
        
        $('#containerPhone').append(clon);
        $('form.validate').validate();
        
        return false;
    });
    
    $('.removePhone').live('click', function(){
        if($('#containerPhone span').length != 1){
        	$(this).parent().remove();
        }
        return false;
    });
    
    
    $('#addEmail').click(function(){
        var first = $('#containerEmail span').get(0);
        var clon = $(first).clone();
        
        clon.find('input[type=text]').val('');
        
        j++;
        clon.find('input, select').each(function(index, item){
            var prefix = $(item).attr('dataindex');
            $(item).attr('id', prefix + j);
            $(item).attr('name', prefix + "[" + j + "]");
        });
        
        $('#containerEmail').append(clon);
        $('form.validate').validate();
        
        return false;
    });
    
    $('.removeEmail').live('click', function(){
        if($('#containerEmail span').length != 1){
        	$(this).parent().remove();
        }
        return false;
    });
    

    $(function () {
        $("#browser").treeview({});
    });

});
