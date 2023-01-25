$(document).ready(function(){
    
    function fetchDay(item){
        var id = $(item).attr('id');
        var day =  id.split('_')[1];
        return day;
    }
    
    function isEmpty(hour){
        return hour.length == 0;
        
    }
    
    function isRange(time1, time2){
        var parts = time1.split(':');
        var h1 = parseInt(parts[0], 10);
        var m1 = parseInt(parts[1], 10);
       
        
        var parts = time2.split(':');
        var h2 = parseInt(parts[0], 10);
        var m2 = parseInt(parts[1], 10);
      
        
        if( h1 < h2 ){
            return true;
        }else if( h1 > h2 ){
            return false;
        }else if( h1 == h2 ){
            if( m1 < m2 ){
                return true;
            }else if( m1 > m2 ){
                return false;
            }else if( m1 == m2 ){
                return false
            }    
        }
    }
    
    function isProgressiveTime(hour1, hour2, hour3, hour4){
        
        if( isEmpty(hour2) && isEmpty(hour3) ){
            return isRange(hour1, hour4);    
        }
        
        if( isEmpty(hour2) ){
            return isRange(hour1, hour3) && isRange(hour3, hour4);    
        }
        
        if( isEmpty( hour3) ){
            return isRange(hour1, hour2) && isRange(hour2, hour4);
        }
        
        return isRange(hour1, hour2) && isRange(hour2, hour3) && isRange(hour3, hour4);
    }
    
    $('input[type=checkbox]').click(function(){
        
        var day = fetchDay(this);
        if( $(this).attr('checked') )
        {
            $('#timeStart_' + day).removeAttr('disabled');
            $('#timeLunch_' + day).removeAttr('disabled');
            $('#timeLunchEnd_' + day).removeAttr('disabled');
            $('#timeEnd_' + day).removeAttr('disabled');
        }
        else
        {
            $('#timeStart_' + day).attr('disabled', 'disabled');
            $('#timeLunch_' + day).attr('disabled', 'disabled');
            $('#timeLunchEnd_' + day).attr('disabled', 'disabled');
            $('#timeEnd_' + day).attr('disabled', 'disabled');
        }
        
    });
    
    $('form.validate').submit(function(){
        var isValid = true;
        $('.enableDays:checked').each(function(index, item){
            var day = fetchDay(item);
            var time1 = $('#timeStart_' + day).val();
            var time2 = $('#timeLunch_' + day).val();
            var time3 = $('#timeLunchEnd_' + day).val();
            var time4 = $('#timeEnd_' + day).val();
            
            if( ( isEmpty(time2) && !isEmpty(time3) ) || ( isEmpty(time3) && !isEmpty(time2) ) ){
                isValid = false;
            }
            
            if( !isProgressiveTime(time1, time2, time3, time4) ){
                isValid = false;
            }
        });
        if( !isValid ){
        	var title = I18n._("Error");
        	var text = I18n._("The range of hours is incorrect");
            $("<div title='"+ title + "'>"+text+"</div>").dialog();
            return false;
        }
    });
    
});
