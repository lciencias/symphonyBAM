$(document).ready(function(){
	var head;
	var anterior;
	var orden;
	var contadorHeaders;
	head = anterior = orden ="";
	contadorHeaders = 0;
	$("#myTableAjax").tablesorter({
		 theme : "bootstrap",
		 widthFixed: true,
		 widgets : [ "uitheme","zebra" ],
		 widgetOptions : {
		      zebra : ["even", "odd"],
		 }
	});	
	
	
	$(".head").click(function(){
		head = $(this).attr('id');
		if(String(head) !== '' && String(head) !== 'acciones'){
			$("#headP").val(head);
			$("#head").val(head);
		}else{
			$("#headP").val("");
			$("#head").val("");
		}
		if(String(anterior) !== String(head)){
			contadorHeaders = 0;
		}else{			
			contadorHeaders++;
		}
		if(contadorHeaders % 2 == 0){
			orden = "1";
		}else{
			orden = "2";
		}
		anterior = head;
		$("#ordenP").val(orden);
		$("#orden").val(orden);
	});
	
	
	$(".pag").click(function(){
		var page = 0;
		var action = $("#action").val();
		var url    = $("#urlpag").val();
		var idregs  = $("#idregs").val();
		var total  = $("#total").val();
		
		var data   ="";
		var random = random=Math.round(Math.random()*100);
		page = $(this).attr('rel');
		if(parseInt(total) > 0){
			data = $("#urlpag").val();
			data+="&random="+random+"&total="+total+"&page="+page+"&regs=6";
			$.get(baseUrl + "/ticket-client/search-tickets",{
				  account:$("#account").val(), 
				  clientNumber:$("#clientNumber").val(), 
				  rfc:$("#rfc").val(),
				  name:$("#name").val(),
				  last_name:$("#last_name").val(),
				  middle_name:$("#middle_name").val(),			
				  folio: $("#folio").val(),
				  id_ticket_type : $("#id_ticket_type").val(),
				  status:$("#status").val(),
				  id_channel: $("#id_channel").val(),
				  id_client_category: $("#id_client_category").val(),
				  id_origin_branch: $("#id_origin_branch").val(),
				  id_reported_branch:$("#id_reported_branch").val(),
				  id_user : $("#id_user").val(),
				  id_user_assigned:$("#id_user_assigned").val(),
				  orden : $("#ordenP").val(),
				  head  : $("#headP").val(),
				  random: random,
				  total: total,
				  page:page,
				  regs: idregs,
				  ajax:1,
				},
				function(buffer,estado,xhr){
					$("#resultsInformationContainer").html("");
					$("#resultsInformationContainer").html(buffer);			 
				},'html');	
		}		
		return false;
	});
});