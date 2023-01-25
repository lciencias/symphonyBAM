$(document).ready(function(){		
        $("#type").change(function(){
            id=$(this).val();
            $("#divNumMovs").hide();
            if(id == 0)
              $("#divSubtype").show();   
            else{
                $("#movments").val('');
                $("#divSubtype").hide();
            }
                
        });
        
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
        
//        $("#send").clik(function(e){
//        e.preventDefault();
//        
//        $('#save-not-client').validate({ 
//                submitHandler: function(form) {
//                }
//            });
//            $(this).submit();
//        });
        
        


});
