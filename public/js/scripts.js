$(document).ready(function(){
	
	
	 $("form").keypress(function(e) {
	        if (e.which == 13) {
	            return false;
	        }
	 });
	try{
		$(document).find('.validate').each(function(){
			$(this).validate({ignore : []});
		});
	}catch(err){

	}
	$(document).find('.filter-form').each(function(){
		var filterForm = this;
		$(this).find('input[type="submit"]').each(function(){
			$(this).click(function(event){
				event.preventDefault();
				var url = baseUrl + '/' + controller + '/' + action;
				$(filterForm).find(':input').each(function(){
					if (!$(this).is('input[type="submit"]')){
						if($(this).val()!='')
							url += '/' + $(this).attr('name') + '/' + $(this).val();
					} 
				});
				$(window.location).attr('href', url);
			});
		});
	});
});
