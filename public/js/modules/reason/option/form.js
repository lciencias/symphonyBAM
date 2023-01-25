$(document).ready(function(){
	$('#addOption').click(function(){
		var first = $('#inputContainer span').get(0);
		var clon = $(first).clone();
		clon.find('input[type=text]').val('');
		$('#inputContainer').append(clon);
	});
	
	$('.removeOption').live('click', function(){
		if($('#inputContainer span').length != 1)
		  $(this).parent().remove();
	});
	
});

