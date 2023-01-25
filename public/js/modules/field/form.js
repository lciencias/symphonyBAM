$(document).ready(function(){
	$('#reguralExpressions').change(function(){
		value = $('#reguralExpressions :selected').val();
		$('#reg_ex').val(value);
	});
});