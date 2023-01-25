$(document).ready(function(){
	
	
	$('#sincProducts').click(function(event){
                event.preventDefault();
//		setLoader('#requiredFieldsContainer', 'required-fields-message');
                $("#asinc").hide();
                $("#loader").show();
                $('#loader').append('<span style="color:#ff0000;font-size:18px;">P r o c e s a n d o . . . . . .</span>');
		$.ajax({
			url : baseUrl + '/cron/products',
//			data : {
//				id_client_category : value,
//			},
//			error : function(){
//				setMessageTable('#requiredFieldsContainer', 'error-message');
//			},
			success : function(data){
                            location.href=baseUrl+"/product/index";
			},
		});
	});

});