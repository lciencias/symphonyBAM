var logo    = baseUrl +'/images/logos/logo.png';
$(document).ready(function(){		
        /**
	 * Evento para enviar el formato, previo se valida que el correo sea valido
	 */
        $("#searchWs").click(function(e){
            e.preventDefault();
            $("#errorContainer").hide();
            subtype=0;
            subtype=$("#subtype").val();
            $("#random").val(Math.round(Math.random() * 10000));
            $("#not-client").validate({ 
                submitHandler: function(form) {
                    setLoader('#clientInformationContainer','client-information-message');
                        $.ajax({
                            url : baseUrl + '/ticket-not-client/search-ws/',
                            data : $('#not-client').serialize(),
                            dataType : 'json',
                            error : function(){
                                    setMessageTable('#requiredFieldsContainer', 'error-message');
                            },
                            success : function(Info){
                            	if(Info !== null){
	                                $("#clientInformationContainer").empty();
	                                if(Info.error){
	                                    $("#intranetFrame").hide();
	                                    $("#save-not-client").hide();
	                                    setMessageWs(Info.error);
	                                }
	                                if(Info == null){
	                                	setMessageTable('#errorContainer', 'no-information-message');
	                                }
	                                else if (Info.length == 0){
	                                    setMessageTable('#errorContainer', 'no-information-message');
	                                }
	                               else
	                               {  
	                                $("#PersonalResponseContainer").hide();
	                                $("#BranchResponseContainer").hide();
	                                    switch(subtype){
	                                        case '1':
	                                        	if(Object.keys(Info).length >0){                                        		
	                                        		if(parseInt(Info.exist) === 1){
	                                        			$("#intranetFrame").show();                                       			 
	                                       				 $("#intranetFrame").attr("src", Info.url.trim());                                        			 
	                                       				 $("#PersonalResponseContainer").show();                                       				 
	                                       				 $("#tableTicket").show();
	                                                }else{
	                                                	setMessageWs("La url es inaccesible");
	                                                }
	                                            }
	                                        	break;
	                                        case '2':
	                                                if(Object.keys(Info).length >0){
	                                                    buffer='';
	                                                    $("#BranchResponseContainer").show();
	                                                    $("#tableTicket").show();
	                                                    for (index in Info){
	                                                        buffer+='<tr>';
	                                                        buffer+='<td>'+Info[index].name+'</td>';
	                                                        buffer+='<td>'+Info[index].address+'</td>';
	                                                        buffer+='<td>'+Info[index].scheduled+'</td>';
	                                                        buffer+='</tr>';     
	                                                        }
	                                                    $("#BranchResponseContainer").find(".info").html(buffer);    
	                                                }
	                                        break;
	
	                                        case '3':
	                                                if(Object.keys(Info).length >0){
	                                                    buffer='';
	                                                    $("#ProductsResponseContainer").show();
	                                                    $("#tableTicket").show();
	                                                    $("#ProductsResponseContainer").find(".resName").html(Info.name);
	                                                    $("#ProductsResponseContainer").find(".resDesc").html(Info.description);
	                                                    $("#ProductsResponseContainer").find(".resReq").html(Info.requirements);
	                                                    $("#ProductsResponseContainer").find(".resCom").html(Info.commissions);  
	                                                }
	                                        break;
	                                    } // termina switch
	                                }   
                            	}else{
                            		error(I18n._("No connection to the Webservice"));
                            	}
	                          }, // termina success ajax                            
                        });// termina ajax                       
                    }//ternmina submitHandler
            });  
            if(parseInt(subtype) > 0){
            	$(this).submit();
            }
        });
        
        
        $("#reason").change(function(){
            $(".dynamicDiv").hide();
            $(".dynamicCombo").hide();
            $("#sucursal").hide();
            $("#divProducts").hide();
            $("#searchName").val('');
            $("#description").val('');
            id=$(this).val();
            if(id >0){
                $.ajax({
			url : baseUrl + '/ticket-not-client/get-subtype-by-id/',
			data : {
				id : id,
			},
			error : function(){
				setMessageTable('#errorContainer', 'error-message');
			},
			success : function(subtype){
                         
                            
                            
//                            $("#personal").hide();
//                            $("#sucursal").hide();
//                            $("#divProducts").hide();
//                            $("#PersonalResponseContainer").hide();
//                            $("#BranchResponseContainer").hide();
//                            $("#ProductsResponseContainer").hide();
//                            $("#tableTicket").hide();
//                            $("#searchName").val('');
//                            $("#description").val('');
                            
                            $("#subtype").val(subtype);
				switch(subtype){
//                                    case '1':
//                                        $("#personal").show();
//                                    break;
                                    case '2':
                                        $("#sucursal").show();
                                        break;
                                    case '3':
                                        $("#divProducts").show();    
                                        break;
                                    break;
                                }
                              
			},
		});
                
                
            }
            
            
        });
        
        $("#saveTicket").click(function(e){
            e.preventDefault();
            $('#save-not-client').validate({ 
                submitHandler: function(form) {
                $.ajax({
			url : baseUrl + '/ticket-not-client/save-ticket/',
			data : {
				id_reason : $("#reason").val(),id_ticket_type:$("#ticketType").val(),description:$("#description").val(),name_client:$("#name").val()
			},
                        dataType : 'json',
			error : function(){
				setMessageTable('#requiredFieldsContainer', 'error-message');
			},
			success : function(){
                            location.href=baseUrl+"/ticket-client/new";
			},
		});
                }
            });
            $(this).submit();
        });
function setLoader(container, messageType){
	loader = $('#loader').clone();
	message = loader.attr(messageType);
	loader.find('#message').html(message);
	loader.css({
		display : 'block'
	});
	$(container).html('');
	$(container).append(loader);
}
function setMessageTable(container, messageType){
	$(container).html('');
	table = $('#messageDiv').clone();
	message = table.attr(messageType);
	table.find('#message').html(message);
	table.css({
		display : 'block',
	});
	$(container).append(table);
}

function setMessageWs(message){
	$("#errorContainer").find("#message").html(message);
        $("#errorContainer").show();
}

});

function error( mensaje){
	$.gritter.add({
        title: I18n._('BAM'),
        image: logo,
        text: mensaje,
        sticky: false,
        time: 2500,
        position: 'center'
    });
    return false;
}
