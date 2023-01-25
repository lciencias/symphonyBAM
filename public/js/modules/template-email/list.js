$(document).ready(function(){
	$('#myModal').modal({backdrop : true});
	$('#new-template').click(function(event){
		$('#myModal').modal('show');
		event.preventDefault();
	});
	$('#create').click(function(){
		$('#create-form').submit();
	});
});