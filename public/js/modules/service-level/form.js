function str_pad(val, str, length){
    val = ""+ val;
    while( val.length < length ){
        val = str + val;
    }
    console.log(val);
    return val;
}

$(document).ready(function(){
    
    function displayTime(element, value){
        $(element).text(value);
    }
    
    function refreshForm(element, value){
        $(element).val(value);
    }
    
    function getTime(slider){
    	console.log();
        return str_pad($(slider).parent().find('.slider_days').slider("value"), '0', 2) + ":" 
        + str_pad($(slider).parent().find('.slider_hour').slider("value"), '0', 2)+ ":" 
        + str_pad($(slider).parent().find('.slider_minute').slider("value"), '0', 2);
    }
    
    function changeHandler(event, ui){
        var time = getTime(this);
        displayTime($(this).parent().find('.display'), time);
        refreshForm($(this).parent().find('.input_time'), time);
    }
    $( ".slider_days" ).slider({
        min: 0,
        max: 30,
        change: changeHandler
    });
    
    $( ".slider_hour" ).slider({
        min: 0,
        max: 23,
        change: changeHandler
    });
    
    $( ".slider_minute" ).slider({
        min: 0,
        max: 59,
        change: changeHandler
    });
    
    $( ".slider_days,.slider_hour,.slider_minute" ).each(function(index, item){
        $(item).slider('value', $(item).attr('dataValue'));
    });
    
});

