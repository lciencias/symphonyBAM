var entero = "0123456789";
var numeros = "0123456789.";
var alfanumerico = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
var logo    = baseUrl +'/images/logos/logo.png';
var unicoTicket;
var unicoRegreso;
var unicoSaldo;
var unicoTx;
$.validator.addMethod(
		'regExFields', 
		function (value, element) {
			rule = $(element).attr('rule');
			var regex = new RegExp(rule);
			if(value == '') return true;
			else if (regex.test(value)) return true;
			return false;
		},
		"Este campo no es v&aacute;lido"
);
$.validator.classRuleSettings.regExFields = { regExFields : true };

$(document).ready(function(){
	var arrayQuestion = new Array(5);
	var indicQuestion ;
	var head;
	var anterior;
	var orden;
	var contadorHeaders;
	head = anterior = orden ="";
	unicoTicket = unicoRegreso = unicoSaldo = unicoTx = contadorHeaders = 0;
	$("#myTable").tablesorter({
		 theme : "bootstrap",
		 widthFixed: true,
		 widgets : [ "uitheme","zebra" ],
		 widgetOptions : {
		      zebra : ["even", "odd"],
		 }
	});
	$('#start_date').datetimepicker('option', {dateFormat: "yy-mm-dd",timeFormat: 'HH:mm',minDate: '-180D', maxDate: '0D'});
	$('#end_date').datetimepicker('option'  , {dateFormat: "yy-mm-dd",timeFormat: 'HH:mm',minDate: '-180D', maxDate: '0D'});
	$('#start_date_edo').datetimepicker('option', {dateFormat: "yy-mm-dd",timeFormat: 'HH:mm',minDate: '-180D', maxDate: '0D'});
	$('#end_date_edo').datetimepicker('option'  , {dateFormat: "yy-mm-dd",timeFormat: 'HH:mm',minDate: '-180D', maxDate: '0D'});
	$("#id_reason").attr('disabled',true);
	indicQuestion = 1;
	if(parseInt($("#findBD").val()) !== 1){
		$("#control").hide();
	}
	else{
		$("#control").show();
		$(".masfiltros").show();
	}
	$("#descriptionFind").hide();
	/*$('#ticket-form').validate({ignore : []});*/
	$.ajaxSetup ({
		dataType : 'json',
		type : 'POST',
		async : false,
	});
		
	
	$(".head").click(function(){
		head = $(this).attr('id');
		if(String(head) !== '' && String(head) !== 'acciones'){
			$("#head").val(head);
			$("#headP").val(head);
		}else{
			$("#head").val("");
			$("#headP").val("");
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
		$("#orden").val(orden);
		$("#ordenP").val(orden);
	});
	
	$("#searchBD").click(function(event){
		$("#findBD").val(1);
	});

	/**
	 * Metodo que sirve para buscar en la base con los parametros de alta de aclaracion
	 */
	$(".live").click(function(event){
		var url = baseUrl + '/ticket-client/search-tickets/';
		$.get(url,{
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
				  id_user_assigned:$("#id_user_assigned").val()
				},
				function(buffer,estado,xhr){				
				$("#resultsInformationContainer").html(buffer);
				 
		},'html');	
		return false;
	});
	
	$('#search').click(function(event){
		event.preventDefault();
		var aleatorio;
		var buffer;
		var valor;
		var incorrectos; 
		var correctos;
		var unico;
		var contadorCampos;
		unico = 0;
		contadorCampos = 0;
		aleatorio = incorrectos = correctos = valor = 0;
		arrayQuestion = new Array(6);
		arrayQuestion [0] = 0; 
		indicQuestion = 1;
		$("#pcorrectas").val("0");
		$("#icorrectas").val("0");
		$("#npreguntas").val("");
		buffer     = "";
		if(String($("#clientNumber").val()) === '' && String($("#account").val()) ===''){
			if(String($("#rfc").val()) !== ''){
				contadorCampos++;
			}
			if(String($("#name").val()) !== ''){
				contadorCampos++;
			}
			if(String($("#last_name").val()) !== ''){
				contadorCampos++;
			}
			if(String($("#middle_name").val()) !== ''){
				contadorCampos++;
			}
			if(parseInt(contadorCampos) <2){
				error(I18n._("Please type in two search fields"));
				return false;
			}
		}		
		$('#newForm').css({
			display : 'none',
		});
		setLoader('#clientInformationContainer','client-information-message');
		if(String($("#account").val()) !==""){
			$("#accountTmp").val($("#account").val()); 
		}

		$.ajax({
			url : baseUrl + '/ticket-client/get-client-information/',
			data : {clientNumber : $("#clientNumber").val(),account:$("#account").val(),rfc:$("#rfc").val(),name:$("#name").val(),last_name:$("#last_name").val(),middle_name:$("#middle_name").val()},
			error : function(){
				setMessageTable('#clientInformationContainer', 'error-message');
			},
			success : function(clientInfo){
				if(clientInfo == null){
					setMessageTable('#clientInformationContainer', 'no-information-message');
				}
                                if(clientInfo.error){
                                    setMessageTable('#clientInformationContainer', 'no-information-message');
                                    $("#messageDiv").find("#message").html(clientInfo.error);
                                }
				else if (clientInfo.length == 0){
					setMessageTable('#clientInformationContainer', 'no-information-message');
				}
				else{
					$('#clientInformationContainer').html('');
					$("#control").show();
					clientTable = $('#compactClientsTable').clone();
					clientTable.css({display : 'table',});				
					for (index in clientInfo){							
						tableRow = $('#compactClientsRow').clone();
						tableRow.attr('id',clientInfo[index].client_number);
						tableRow.find('.clientNumber').html(clientInfo[index].client_number);
						tableRow.find('.name').html(clientInfo[index].name);
						tableRow.css({display : 'table-row',});
						tableRow.find('.showAccountsBotton').attr('clientNumber',clientInfo[index].client_number);						
						clientNumber = clientInfo[index].client_number;
						
						//Inicio de evento para crerar nuevo ticket						
						tableRow.find('.showAccountsBotton').click(function(){
							$("#resultsInformationContainer").css({
								display : 'none',
							});
							$("#botonRegresar").css({display : 'block'});
						$.ajax({
								url : baseUrl + '/ticket-client/get-client-information/',
								data : {clientNumber : $(this).attr('clientNumber')},
								success : function(clientFullInfo){									
								if(clientFullInfo == null){
									//setMessageTable('#clientInformationContainer', 'no-information-message');
								}
								else if (clientFullInfo.length == 0){
									//setMessageTable('#clientInformationContainer', 'no-information-message');
								}
								else{
									$(".masfiltros").remove();
									$(".actions").remove();
									$(".encabezado").css({ color: "#FFFFFF", background: "#FF0000", "text-align": "center"});
									$("#resultsInformationContainer").html("");												
									for (indexj in clientFullInfo){
										if(unico === 0){
											if(parseInt($("#permisoPreguntas").val()) === 1){	
												var buffer = viewQuestion(clientFullInfo[indexj]);
												$("#preguntas").html(buffer);											
												clientFullTable = $('#clientInformationTable').clone();
												clientFullTable.attr('id',clientFullInfo[indexj].client_number);
												clientFullTable.find('.clientNumber').html(clientFullInfo[indexj].client_number);
												clientFullTable.find('.name').html(clientFullInfo[indexj].name);
												clientFullTable.css({display : 'block'});
																							
												//	inicio para dar click en el boton de Correcto
												clientFullTable.find('#correcto').click(function(){
													correctos = parseInt($("#pcorrectas").val()) + 1;
													$("#pcorrectas").val(String(correctos));
													$("#c-"+indicQuestion).css({background: "#5fbe5f" });
													arrayQuestion [indicQuestion] = 1;
													valor = totalPreguntas(indicQuestion);												
													indicQuestion = revisarPreguntas(clientFullInfo[indexj],valor,indicQuestion,arrayQuestion);												
												});									
												
												//inicio para dar click en el boton de Incorrecto
												clientFullTable.find('#incorrecto').click(function(){
													incorrectos = parseInt($("#icorrectas").val()) + 1;
													$("#icorrectas").val(String(incorrectos));
													$("#c-"+indicQuestion).css({background: "#cf453f" });
													arrayQuestion [indicQuestion] = 2;
													valor = totalPreguntas(indicQuestion);
													indicQuestion = revisarPreguntas(clientFullInfo[indexj],valor,indicQuestion,arrayQuestion);
												});
												$('#clientInformationContainer').html('');
												$('#clientInformationContainer').append(clientFullTable);
											}else{
												$('#clientInformationContainer').html('');
												arrayQuestion =[1,1,1,1,1,1];
												recuperaCuenta(clientFullInfo[indexj],arrayQuestion);
												}											
											}
											unico++;
										}											
									}
								}
							});
						});					
						clientTable.append(tableRow);
						$('#clientInformationContainer').append(clientTable);
					};
				}
			},
		});			
	});
/*
	$('.client-category').click(function(){
		$('#clientCategoryHidden').val($(this).val());
	});*/	
	
	/**
	 * Evento para abrir el modal de enviar formato
	 */
	$('#sendMail').click(function(){
		$("#validaEmail").css({ color: "#fff", background: "#fff" });
		$("#validaEmail").html("");
		$('#my-modal').css({display : 'block'});
	});
	
	/**
	 * Evento para limpiar el letrero de error
	 */
	$("#emailClient").keyup(function(){
		$("#validaEmail").html("");
	});
	
	/**
	 * Evento para enviar el formato, previo se valida que el correo sea valido
	 */
	$("#sendFormat").click(function(){
		emailClient =  $("#emailClient").val();		
		$("#validaEmail").css({ color: "#fff", background: "#fff" });
		$("#validaEmail").html("");
		if(String(emailClient) !== ""  && parseInt($("#id_ticket_client").val()) > 0){
			emailClient = emailClient.toLowerCase();
			$("#emailClient").val(emailClient);
	        if(valEmail(emailClient)){
	        	$("#validaEmail").html('<span style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
	        	$('#sendMail').attr('disabled',true);
	        	$.ajax({																
	        		url : baseUrl + '/ticket-client/report-pdf/',
	        		data : {
	        			clientInformation : $("#clientDataJson").val(),
	        			clientTransaction : $("#transactionsJson").val(),
	        			format:2,
	        			type:2,
	        			emailClient: emailClient,
	        			id_ticket_client : $("#id_ticket_client").val(),
	        		},
	        		error : function(){
	    				$("#validaEmail").css({ color: "#ff0000", background: "#fff" });
	    				$("#validaEmail").html(I18n._("Error generating mail sending"));	        		
	        		},
	        		success : function(accountInfo){
						$("#validaEmail").css({color:"#57a957"});
						$("#validaEmail").html('<span style="color:#57a957;font-size:16px;">'+I18n._("The email has been sent")+'</span>');						
						setTimeout(function(){
		    	        	$('#my-modal').css({display : 'none'});
		    	        	$('#sendMail').attr('disabled',false);
						},2500);
	        		}
	        	});
	        }else{
	        	$("#emailClient").val("");
				$("#validaEmail").css({ color: "#ff0000", background: "#fff" });
				$("#validaEmail").html(I18n._("Incorrect email"));
	        }
		}else{
			$("#validaEmail").css({ color: "#ff0000", background: "#fff" });
			$("#validaEmail").html(I18n._("Please provide email"));
		}
		return false;
	});
	
	/***
	 * Evento para imprimir el formato de ticket
	 */
        $("#print").click(function(){
		if(parseInt($("#id_ticket_client").val()) > 0){
			$("#errorPrint").css({ color: "#ff0000", background: "#fff" });
			$("#errorPrint").html(I18n._("P r o c e s a n d o . . . . "));
        	$.ajax({																
        		url : baseUrl + '/ticket-client/report-pdf/',
        		data : {
        			clientInformation : $("#clientDataJson").val(),
        			clientTransaction : $("#transactionsJson").val(),
        			clientDocuments   : $("#documentsJson").val(),
        			format:1,
        			type:2,        			
        		},
        		error : function(){
    				$("#errorPrint").css({ color: "#ff0000", background: "#fff" });
    				$("#errorPrint").html(I18n._("Error generating document"));	        		
        		},
        		success : function(pdf){
        			$("#errorPrint").css({ color: "#fff", background: "#fff" });
        			$("#errorPrint").html(I18n._(""));
        			window.open(baseUrl+'/carta/'+pdf, '_blank');
        		}
        	});

		}
	});


	/***
	 * Evento para cerrar el modal de enviar formato
	 */
	$("#closeWindow").click(function(){
		$('#my-modal').css({display : 'none'});
		$('#my-modal-new').css({display : 'none'});
	});

	$(".closeWindows").click(function(){
		$('.modal').css({display : 'none'});
	})

	$("#closeWindowf").click(function(){
		$('#my-modal-reopen').css({display : 'none'});
		return false;
	});
	
	$(".close").click(function(){
		$('.modal').css({display : 'none'});
	})

	/** 
	 * Evento para no permitir letras y caracteres especiales en campo numerico
	 */
	
	
    $('.numerico').keyup(function () {    	
	    this.value = check_chars(this.value,numeros);
    });
    $('.numerico').change(function () {    	
    	$(this).val(numberFormat($(this).val()));
    });	
    $('.entero').keyup(function () {    	
	    this.value = check_chars(this.value,entero);
    });
    $('.entero').change(function () {    	
    	$(this).val(numberEntero($(this).val()));
    });	

    $('.alfanumerico').keyup(function () {    	
	    this.value = check_chars(this.value,alfanumerico);	    
    });
    $('.alfanumerico').change(function () {    	
    	$(this).val($(this).val().toUpperCase());	    
    });
	

    $("#clear").click(function(){
    	 location.href=baseUrl+"/ticket-client/new";
    });
    $("#cancel2").click(function(){
    	 location.href=baseUrl+"/ticket-client/new";
    });
 
    
    $("#reOpen").click(function(){
    	var folioCondusef;
    	if(String($("#folio_condusefEdit").val().trim()) !== ''){
    		return true;
    	}
    	else{
    		$("#rfolioCondusef").css({ color: "#fff", background: "#fff" });
    		$("#rfolioCondusef").html("");
    		$("#rChannel").css({ color: "#fff", background: "#fff" });
    		$("#rChannel").html("");    		
    		$('#my-modal-reopen').css({display : 'block'});   
    		return false;
    	}
    });
    
    $('#newForm').find('#id_channel').change(function(){
		if(parseInt($("#id_channel").val()) !== 6){			
			$("#condusefAjax").hide();
			$('#newForm').find('#folio_condusef').val('');
		}    		
		else{
			$("#condusefAjax").show();
		}    	
    });
    
    $("#idChannelT").change(function(){
    	if(parseInt($("#idChannelT").val()) > 0){
    		$(".reng3Condusef").show();
    		if(parseInt($("#idChannelT").val()) === 2){
    			$(".reng3Condusef").hide();
    		}    		
    	}else{
    		$(".reng3Condusef").show();
    		error("Seleccione un canal");
    	}
    });
    
    $("#sendFolioCondusef").click(function(){
    	if(parseInt($("#idChannelT").val()) === 0){
    		error(I18n._("The Channel is Required"));
    		return false;
    	}
    	if(parseInt($("#idChannelT").val()) !== 2 && String($("#folioCondusefT").val()) === ""){
    		error(I18n._("The Folio Condusef is Required"));
    		return false;
    	}
    	if( (parseInt($("#idChannelT").val()) > 0)){
			$.ajax({												
				url : baseUrl + '/ticket-client/set-folio-condusef/',
				data: {
					idTicketClient : $("#id_ticket_client").val(),
					folioCondusef  : $("#folioCondusefT").val(),
					channel        : $("#idChannelT").val()
				},
				error : function(){						
					error1(I18n._("Error"));
					return false;
				},success : function(dataInfo){
					if(parseInt(dataInfo.exito) === 1){ 
						location.href = baseUrl + '/ticket-client/reopen/id/'+$("#id_ticket_client").val();
					}
					else{
						error(I18n._("Failed to save data"));
					}
				}
			});			
    	}else{
    		error(I18n._("The Channel is Required"));    	
    	}
    	return false;
    });
    
	/**
	 * Evento que guarda los datos del deposito en una tabla temporal
	 */	
	$("#saveDeposit").click(function(){
		if(parseInt($('#my-modal-new').find("#idInfTransaction").val()) > 0 && 
		   String($('#my-modal-new').find("#amountDeposited").val()) !== "" &&
		   String($('#my-modal-new').find("#dateDeposited").val()) !== "" ){
		   //$('#my-modal-new').find("#saveDeposit").attr('disabled',true);
		   $('#my-modal-new').find("#errorDeposit").html('<span style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
			var data = new FormData();
			data.append("id_transaction",$('#my-modal-new').find("#idInfTransaction").val());
			data.append("type_deposit",$('#my-modal-new').find("#typeDeposit").val());
	    	data.append("amount_deposit",$('#my-modal-new').find("#amountDeposited").val());
  			data.append("date_deposit"  ,$('#my-modal-new').find("#dateDeposited").val());
  			data.append("fileDeposit"  ,$('#my-modal-new').find("#fileDeposited")[0].files[0]);
  			$('#my-modal-new').find("#errorDeposit").html('<span style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
			$.ajax({																
				url : baseUrl + '/ticket-client/deposit-transaction/',
				type: "POST",
				data : data,
				processData: false,
			    contentType: false,
				error : function(){
					error(I18n._("Failed to save data"));
				},
				success : function(info){
					if(info === null){
						error(I18n._("Failed to save data"));
					}
					else if(parseInt(info.exito) === 1){						
						error(info.mensaje);
						setTimeout(function(){$('#my-modal-new').css({display : 'none'})},3500);   
					}else{
						error(info.mensaje);
						$('#my-modal-new').find("#errorDeposit").html(info.mensaje);
					}
				}
			});			
		}else{
			error(I18n._("Required fields"));
		}
		return false;
	});
	
	$("#edoCuenta").click(function(){
		unicoTicket = 0;
		$('#period_edo').val(0),
		$('#start_date_edo').val(""),
		$('#end_date_edo').val(""),		
		$("#resultados").html("");
		$(".tituloedoCuenta").css({ color: "#fff", background: "#ff0000", "font-size": "16px","text-align": "center"});
		$('#my-modal-cuenta').css({display : 'block'});
		return false;
	});
	
	$("#bottonEdoCuenta").click(function(){
		var buffer;
		buffer = "";
		unicoTicket = 0;
		unicoTx = 0;
		$("#resultados").html(buffer);
		if( ((String($('#start_date_edo').val()) !== '')  &&  (String($('#end_date_edo').val()) !== '')) || (parseInt($('#period_edo').val()) > 0) ){
			if(parseInt(unicoTx) === 0){
				$.ajax({												
					url : baseUrl + '/ticket-client/get-transactions-information/',					
					data : {
						clientNumber : $("#client_number").val(),
						clientAccount: $("#account_number").val(),			
						clientPeriod:  $('#period_edo').val(),
						clientStartDate : $('#start_date_edo').val(),
						clientEndDate : $('#end_date_edo').val(),
                        movments: $("#movments").val(),
                        clientIdProduct:$("#id_product_bam").val(),                                               
					},
					error : function(){						
						error1(I18n._("No connection to the Webservice"));
						return false;
					},success : function(transactionsInfo){
						unicoTx++;
						if(transactionsInfo == null){
							error1(I18n._("No connection to the Webservice"));
							return false;
						}
						else if(transactionsInfo.length == 0){
							$("#resultados").html(I18n._("Unavailable account statement"));
						}
						else{	
							buffer += '<table><tr><td>'+I18n._("Post date")+'</td><td>'+I18n._("Description")+'</td><td>'+I18n._("Amount")+'</td></tr>';
							for (index in transactionsInfo){
								if(String(transactionsInfo[index].post_date) !== "undefined"){
									buffer += '<tr>';
									buffer += '<td>'+transactionsInfo[index].post_date+'</td>';
									buffer += '<td>'+transactionsInfo[index].descriptions+'</td>';
									buffer += '<td>'+transactionsInfo[index].amount+'</td>';
									buffer += '</tr>';
								}else{
									buffer += '<tr><td  align="center">'+I18n._("No information available")+'</td></tr>';
								}
							}
							buffer += '</table>';
							$("#resultados").html(buffer);
						}
					}
				});
			}
			unicoTx++;
		}
		return false;
	});
	
	$('#period_edo').change(function(){
		if(parseInt($('#period_edo').val()) == 0){	
			$("#start_date_edo").attr('disabled', false);
			$("#end_date_edo").attr('disabled', false);
		}else{
			$("#start_date_edo").val('');
			$("#end_date_edo").val('');
			$("#start_date_edo").attr('disabled', true);
			$("#end_date_edo").attr('disabled', true);				
		}
	});
	$('#start_date_edo').change(function(){
		if(String($('#start_date_edo').val()) !== ''){
			$('#period_edo').val(0);
		}
		if( (String($('#start_date_edo').val()) !== '')  &&  (String($('#end_date_edo').val()) !== '') ){
			if( $('#start_date_edo').val() > $('#end_date_edo').val()){
				$('#start_date_edo').val($('#end_date_edo').val());
			}
		}
	});
	
	$('#end_date_edo').change(function(){
		if(String($('#end_date_edo').val()) !== ''){
			$('#period_edo').val(0);
		}
		if( (String($('#start_date_edo').val()) !== '')  &&  (String($('#end_date_edo').val()) !== '') ){
			if( $('#start_date_edo').val() > $('#end_date_edo').val()){
				$('#start_date_edo').val($('#end_date_edo').val());
			}
		}
	});

	$("#amortizacion").click(function(){
		var regs;
		var buffer;
		buffer = "";
		$("#cuerpo").html(buffer);
		if(String($("#account_number").val()) !== ''){
			$.ajax({																
				url : baseUrl + '/ticket-client-transaction/amortization/',
				data : {
					account_number : $("#account_number").val(),
					random : Math.round(Math.random() * 1000),
				},
				error : function(){
					error(I18n._("No connection to the Webservice"));
				},
				success : function(info){
					if(info == null){
						error(I18n._("No depreciation data"));					
					}			
					else if(info.length == 0){
						error(I18n._("No depreciation data"));	
						buffer += "<center>"+I18n._("No depreciation data")+"</center>";
					}
					else{
						buffer += '<table class="table bordered" id="tableAmortizations">';
						buffer += '<tr><td colspan="2" style="background-color:#ff0000;color:#ffffff;text-align:center;font-weight:bold;">'+I18n._("Amortization information")+'</td></tr>';
						buffer += '<tbody>';
						buffer += '<tr style="background-color:#ddd;color:#000;text-align:center;"><td>'+I18n._("Date of subscription")+'</td><td>'+I18n._("Amount")+' $</td></tr>';
						regs = info.verAmotizaciones;
						for (index in regs){
							buffer += "<tr><td>"+index+"</td><td>"+regs[index]+"</td></tr>";
						}						
						$('#my-modal-amortizacion').css({display : 'block'});
					}
					$("#cuerpo").html(buffer);
				}
			});			
		}
		return false;
	});
	
	$(".transacciones").click(function(){
		var div;
		var tmp; 
		var conditions;
		var docs;
		var represent;
		var combo1;
		var combo2;
		var idCombo;
		var nmCombo;
		var contracargos;
		var dataTmp;
		div = $(this).attr('id');
		tmp = div.split("|");
		
		$(".errorDeposit").html("");
		$("#errorControversia").html("");
		$(".errorControversia").html("");
		$("#descargarpartialModal"+tmp[1]).css({display:'none'});
		if(parseInt(tmp[0]) >  0 && parseInt(tmp[1]) >=  0 ){
			$("#id_transaction").val(tmp[3]);
			$("#id_transactionId").val(tmp[0]);
			$("#fecha_transaction").val(tmp[2]);
			$.ajax({																
				url : baseUrl + '/ticket-client-transaction/transaction-by-type/',
				dataType : 'json',
				data : {
					id_transaction : tmp[0],
					type: tmp[1],
					random : Math.round(Math.random() * 1000),
				},
				error : function(){
					error(I18n._("No connection to the Webservice"));
				},
				success : function(Info){
					if(Info == null){
						error(I18n._("Transaction not found"));					
					}			
					else if(Info.length == 0){
						error(I18n._("Transactions not found, please check the selection"));
					}
					else{
						$(".partialTmp"+tmp[1]).css({display:'none'});
						$("#amountDepositedModal"+tmp[1]).html("");
						$("#dateDepositedModal"+tmp[1]).html("");
						$("#descargarpartialModal"+tmp[1]).val("");
						if(parseInt(tmp[1]) !== 8){
							$("#descargarpartialModal"+tmp[1]).css({display:'none'});
							if(String(Info[0].amount_partial) !== 'null' && String(Info[0].deposit_date_partial) !== 'null'){
								$("#amountDepositedModal"+tmp[1]).html(Info[0].amount_partial);
								$("#dateDepositedModal"+tmp[1]).html(Info[0].deposit_date_partial);
								if(String(Info[0].voucher) !== 'null' && String(Info[0].voucher) !== 'undefined' ){
									$("#descargarpartialModal"+tmp[1]).val(Info[0].voucher);
									$("#descargarpartialModal"+tmp[1]).css({display:'block'});
									$(".partialTmp"+tmp[1]).css({display:'block'});
								}else{
									$("#descargarpartialModal"+tmp[1]).val('');									
									$("#descargarpartialModal"+tmp[1]).css({display:'none'});
									$(".partialTmp"+tmp[1]).css({display:'none'});
								}
								$('#my-modal-'+tmp[1]).find(".tablinks"+tmp[1]).css({display:'block'});							
							}else{
								$("#descargarpartialModal"+tmp[1]).val('');									
								$("#descargarpartialModal"+tmp[1]).css({display:'none'});
								$(".partialTmp"+tmp[1]).css({display:'none'});								
							}
						}	
						else{
							if(String(Info.partial[0].amount_partial) !== 'null' && String(Info.partial[0].date_deposit_partial) !== 'null'){
								$("#amountDepositedModal"+tmp[1]).html(Info.partial[0].amount_partial);
								$("#dateDepositedModal"+tmp[1]).html(Info.partial[0].date_deposit_partial);
							
								if(String(Info.partial[0].voucher) !== ''){
									$("#descargarpartialModal"+tmp[1]).val(Info.partial[0].voucher);
									$("#descargarpartialModal"+tmp[1]).css({display:'block'});
								}else{
									$("#descargarpartialModal"+tmp[1]).val('');									
									$("#descargarpartialModal"+tmp[1]).css({display:'none'});
									$(".partialTmp"+tmp[1]).css({display:'none'});									
								}
								$('#my-modal-'+tmp[1]).find(".tablinks8").css({display:'block'});							
							}else{
								$("#descargarpartialModal"+tmp[1]).val('');									
								$("#descargarpartialModal"+tmp[1]).css({display:'none'});
								$(".partialTmp"+tmp[1]).css({display:'none'});																
							}
						}
						switch(parseInt(tmp[1])){
						case 0:
							for (index in Info){								
								if(String(Info[index].idT24) != '' && String(Info[index].idT24) != 'undefined'){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].idT24);
									dataTmp = Info[index];
									$('#my-modal-'+tmp[1]).find(".fechaTxn").html(dataTmp[0].FechadeOperacion);
									$('#my-modal-'+tmp[1]).find(".horaTxn").html(dataTmp[0].HoradeOperacion);
									$('#my-modal-'+tmp[1]).find(".fechaRegistro").html(dataTmp[0].FechadeRegistro);
									$('#my-modal-'+tmp[1]).find(".importe").html(dataTmp[0].ImportedelaTransaccion);
									$('#my-modal-'+tmp[1]).find(".reference").html(dataTmp[0].Numerodereferencia);
									$('#my-modal-'+tmp[1]).find(".description").html(dataTmp[0].DescripciondelaOperacion);
									$('#my-modal-'+tmp[1]).find(".canal").html(dataTmp[0].CanaldeOperacion);
									$('#my-modal-'+tmp[1]).find(".type").html(dataTmp[0].TipodeTransaccion);
									$('#my-modal-'+tmp[1]).find(".detail").html(dataTmp[0].DetalledelaOperacion);
									$('#my-modal-'+tmp[1]).find(".movement").html(dataTmp[0].NaturalezadelaOperacion);
									if(String(dataTmp[0].VerLog) == "1"){
										$('#my-modal-'+tmp[1]).find("#verLog-0").css({display:'block'});
									}
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request2").val(Info[index].good_faith_request);
								}
							}
							break;
							case 1:
								for (index in Info){
									if(Info[index] != null){
										$('#my-modal-'+tmp[1]).find(".fechaTxn").html(Info[index].fechaTx);
										$('#my-modal-'+tmp[1]).find(".horaTxn").html(Info[index].horaTx);
										$('#my-modal-'+tmp[1]).find(".importe").html(Info[index].importe);
										$('#my-modal-'+tmp[1]).find(".respuesta").html(Info[index].respuesta);
										$('#my-modal-'+tmp[1]).find(".tipoTxn").html(Info[index].tipoTx);
										$('#my-modal-'+tmp[1]).find(".motivo").html(Info[index].Motivoderechazo);
										$('#my-modal-'+tmp[1]).find(".comercio").html(Info[index].comercio);
										$('#my-modal-'+tmp[1]).find(".auth").html(Info[index].noAuth);
										$('#my-modal-'+tmp[1]).find(".giro").html(Info[index].giro);
										$('#my-modal-'+tmp[1]).find(".afiliacion").html(Info[index].afiliacion);
										$('#my-modal-'+tmp[1]).find(".pem").html(Info[index].pem);
										$('#my-modal-'+tmp[1]).find(".secuencia").html(Info[index].secuencia);
										$('#my-modal-'+tmp[1]).find(".referencia").html(Info[index].referencia);
										$('#my-modal-'+tmp[1]).find(".respuestaArqc").html(Info[index].respArqueo);									
										$('#my-modal-'+tmp[1]).find(".status").html(Info[index].Estatus);
										$('#my-modal-'+tmp[1]).find(".reverso").html(Info[index].Reverso);
										$('#my-modal-'+tmp[1]).find(".motivoRech").html(Info[index].Motivoderechazo);
										$('#my-modal-'+tmp[1]).find(".montoRech").html(Info[index].MontoReverso);
										$('#my-modal-'+tmp[1]).find(".sobrante").html(Info[index].Sobrante);
										$('#my-modal-'+tmp[1]).find(".caseta").html(Info[index].Caseteraderechazo);
										$('#my-modal-'+tmp[1]).find(".montoEntregado").html(Info[index].Montoentregado);
										$('#my-modal-'+tmp[1]).find(".error1").html(Info[index].error);
										$('#my-modal-'+tmp[1]).find(".descripcion").html(Info[index].descripcion);
										$('#my-modal-'+tmp[1]).find(".billetes50").html(Info[index].Cantbill50);
										$('#my-modal-'+tmp[1]).find(".billetes100").html(Info[index].Cantbill100);
										$('#my-modal-'+tmp[1]).find(".billetes200").html(Info[index].Cantbill200);
										$('#my-modal-'+tmp[1]).find(".billetes500").html(Info[index].Cantbill500);
										$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
										$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
										$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
										if(String(Info[index].good_faith_request) != "undefined")
											$('#my-modal-'+tmp[1]).find("#good_faith_payment_request1").val(Info[index].good_faith_request);
										if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
											$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
											$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
											$('#my-modal-'+tmp[1]).find(".download").click(function(){
												if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
													descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
												}
											});										
										}
									}else{
										error1("La transacci�n "+tmp[0]+" no se encuentra registrada");
									}
								}
								break;
							case 2:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".ctaClabe").html(Info[index].CuentaClabe);
									$('#my-modal-'+tmp[1]).find(".banco").html(Info[index].Banco);
									$('#my-modal-'+tmp[1]).find(".beneficiario").html(Info[index].Beneficiario);
									$('#my-modal-'+tmp[1]).find(".rfcBeneficiario").html(Info[index].RFCBeneficiario);
									$('#my-modal-'+tmp[1]).find(".concepto").html(Info[index].Concepto);
									$('#my-modal-'+tmp[1]).find(".importeTx").html(Info[index].ImportedeTransaccion);
									$('#my-modal-'+tmp[1]).find(".origenOperacion").html(Info[index].OrigendelaOperacion);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".canal").html(Info[index].Canal);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaProg").html(Info[index].fechaProg);
									$('#my-modal-'+tmp[1]).find(".horaProg").html(Info[index].horaProg);
									$('#my-modal-'+tmp[1]).find(".fechaTx").html(Info[index].Fechadetransaccion);
									$('#my-modal-'+tmp[1]).find(".status2").html(Info[index].Status);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request2").val(Info[index].good_faith_request);									
																		
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download21").empty();
										$('#my-modal-'+tmp[1]).find(".download21").attr('id',Info[index].file_payment);
										$('#my-modal-'+tmp[1]).find(".download21").append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download21").click(function(){
											if(parseInt($(this).attr('id')) >0){												
												descargaFile($('#my-modal-'+tmp[1]).find(".download21").attr('id'));
											}
										});										
									}
									
									if(String(Info[index].file_delivery) != "undefined" && parseInt(Info[index].file_delivery) > 0){
										$('#my-modal-'+tmp[1]).find(".download22").empty();
										$('#my-modal-'+tmp[1]).find(".download22").attr('id',Info[index].file_delivery);
										$('#my-modal-'+tmp[1]).find(".download22").append("<button name='"+Info[index].file_delivery+"' id='"+Info[index].file_delivery+"' class='btn default download'>Descargar</button>");										
										$('#my-modal-'+tmp[1]).find(".download22").click(function(){
											if(parseInt($(this).attr('id')) > 0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download22").attr('id'));
											}
										});										
									}

								}
								break;
							case 3:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".clienteDeposito").html(Info[index].Clientedeposito);
									$('#my-modal-'+tmp[1]).find(".ctaDeposito").html(Info[index].Cuentadedeposito);
									$('#my-modal-'+tmp[1]).find(".concepto").html(Info[index].Concepto);
									$('#my-modal-'+tmp[1]).find(".importeTx").html(Info[index].Importedetransaccion);									
									$('#my-modal-'+tmp[1]).find(".origenOperacion").html(Info[index].OrigendelaOperacion);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".canal").html(Info[index].Canal);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaRegistro").html(Info[index].Fechadetransaccion);
									$('#my-modal-'+tmp[1]).find(".horaRegistro").html(Info[index].Horadetransaccion);
									$('#my-modal-'+tmp[1]).find(".fechaProg").html(Info[index].fechaProg);
									$('#my-modal-'+tmp[1]).find(".status3").html(Info[index].Status);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request3").val(Info[index].good_faith_request);									
									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}
								}
								break;
							case 4:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".noTarjeta").html(Info[index].Numerodetarjeta);
									$('#my-modal-'+tmp[1]).find(".banco").html(Info[index].Banco);
									$('#my-modal-'+tmp[1]).find(".importe").html(Info[index].Importe);									
									$('#my-modal-'+tmp[1]).find(".origenOperacion").html(Info[index].origenOperacion);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".canal").html(Info[index].Canal);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaRegistro").html(Info[index].Fechaderegistro);
									$('#my-modal-'+tmp[1]).find(".horaRegistro").html(Info[index].Horaderegistro);
									$('#my-modal-'+tmp[1]).find(".fechaProg").html(Info[index].Fechaprogramada);
									$('#my-modal-'+tmp[1]).find(".status").html(Info[index].status);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request4").val(Info[index].good_faith_request);									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}									
								}								
								break;
							case 5:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".referencia").html(Info[index].ReferenciaLineadecaptura);
									$('#my-modal-'+tmp[1]).find(".motivo").html(Info[index].Motivo);
									$('#my-modal-'+tmp[1]).find(".importe").html(Info[index].Importe);									
									$('#my-modal-'+tmp[1]).find(".origenOperacion").html(Info[index].OrigendelaOperacion);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".canal").html(Info[index].Canal);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaRegistro").html(Info[index].Fechaderegistro);
									$('#my-modal-'+tmp[1]).find(".horaRegistro").html(Info[index].Horaderegistro);
									$('#my-modal-'+tmp[1]).find(".authTeso").html(Info[index].AutorizacionTeso);
									$('#my-modal-'+tmp[1]).find(".status").html(Info[index].Status);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request5").val(Info[index].good_faith_request);									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}
								}								
								break;
							case 6:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".noCheque").html(Info[index].Numerodecheque);
									$('#my-modal-'+tmp[1]).find(".ctaRetiro").html(Info[index].Cuentaderetiro);
									$('#my-modal-'+tmp[1]).find(".importeTx").html(Info[index].Importedetransaccion);									
									$('#my-modal-'+tmp[1]).find(".bancoCheque").html(Info[index].Bancodelcheque);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaRegistro").html(Info[index].Fechaderegistro);
									$('#my-modal-'+tmp[1]).find(".horaRegistro").html(Info[index].Horaderegistro);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request6").val(Info[index].good_faith_request);									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}
								}								
								break;
							case 7:
								for (index in Info){
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".noCheque").html(Info[index].Numerodecheque);
									$('#my-modal-'+tmp[1]).find(".motivoRechazo").html(Info[index].Motivorechazo);
									$('#my-modal-'+tmp[1]).find(".importe").html(Info[index].Importe);									
									$('#my-modal-'+tmp[1]).find(".status").html(Info[index].Status);
									$('#my-modal-'+tmp[1]).find(".operado").html(Info[index].Operador);
									$('#my-modal-'+tmp[1]).find(".sucursal").html(Info[index].Sucursal);
									$('#my-modal-'+tmp[1]).find(".fechaPago").html(Info[index].Fechadepago);
									$('#my-modal-'+tmp[1]).find(".horaPago").html(Info[index].Horadepago);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);									
									if(String(Info[index].good_faith_request) != "undefined")
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request7").val(Info[index].good_faith_request);									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}
								}								
								break;
							case 8:
							default:
								$('#my-modal-'+tmp[1]).find(".accepted_payment").html("No");
								$('#my-modal-'+tmp[1]).find(".delivery_payment").html("No");
								$('#my-modal-'+tmp[1]).find(".controversy_chargeback_d").html("");
								$('#my-modal-'+tmp[1]).find(".controversy_chargeback_t").html("");
								$('#my-modal-'+tmp[1]).find(".rabonoBuenaFeBoton").css({display:'none'});
								for (index in Info){									
									if(String(Info[index].good_faith_request) != null && String(Info[index].good_faith_request) != "undefined" ){
										$('#my-modal-'+tmp[1]).find(".rabonoBuenaFeBoton").css({display:'block'});
									}
									/*if(String(Info[index].good_faith_payment) != null && String(Info[index].good_faith_payment) != "undefined" ){
										$('#my-modal-'+tmp[1]).find(".rabonoBuenaFeBoton").css({display:'none'});
									}*/
									
									$('#my-modal-'+tmp[1]).find(".idT24").html(Info[index].IDT24);
									$('#my-modal-'+tmp[1]).find(".fechaTxn").html(Info[index].Fechadetxn);
									$('#my-modal-'+tmp[1]).find(".horaTxn").html(Info[index].Horadetxn);
									$('#my-modal-'+tmp[1]).find(".importe").html(Info[index].Importe);
									$('#my-modal-'+tmp[1]).find(".respuesta").html(Info[index].Respuesta);
									$('#my-modal-'+tmp[1]).find(".tipoTxn").html(Info[index].Tipodetxn);
									$('#my-modal-'+tmp[1]).find(".motivo").html(Info[index].Motivoderechazo);
									$('#my-modal-'+tmp[1]).find(".comercio").html(Info[index].Comercio);
									$('#my-modal-'+tmp[1]).find(".auth").html(Info[index].NoAuth);
									$('#my-modal-'+tmp[1]).find(".giro").html(Info[index].Giro);
									$('#my-modal-'+tmp[1]).find(".afiliacion").html(Info[index].Afiliacion);
									$('#my-modal-'+tmp[1]).find(".pem").html(Info[index].PEM);
									$('#my-modal-'+tmp[1]).find(".secuencia").html(Info[index].Secuencia);
									$('#my-modal-'+tmp[1]).find(".referencia").html(Info[index].Referencia);
									$('#my-modal-'+tmp[1]).find(".respuestaArqc").html(Info[index].RespuestaArqueo);
									$('#my-modal-'+tmp[1]).find(".good_faith_payment").html(Info[index].good_faith_payment);
									$('#my-modal-'+tmp[1]).find(".good_faith_date").html(Info[index].good_faith_date);
									$('#my-modal-'+tmp[1]).find(".good_faith_amount").html(Info[index].good_faith_amount);	
									
									
									if(parseInt(Info[index].direct) !== 0){
										$('#my-modal-'+tmp[1]).find(".controversy_chargeback_d").html(Info[index].direct);	
									}									
									if(parseInt(Info[index].trad) !== 0 ){
										$('#my-modal-'+tmp[1]).find(".controversy_chargeback_t").html(Info[index].trad);
									}
									$('#my-modal-'+tmp[1]).find(".debit_time").html(Info[index].debit_time);
									
									$('#my-modal-'+tmp[1]).find(".payment_request_date").html(Info[index].payment_request_date);
									if(parseInt(Info[index].accepted_payment) === 1){
										$('#my-modal-'+tmp[1]).find(".accepted_payment").html("Si");	
									}									
									$('#my-modal-'+tmp[1]).find(".payment_delivery_date").html(Info[index].payment_delivery_date);
									if(parseInt(Info[index].delivered_payment) === 1){
										$('#my-modal-'+tmp[1]).find(".delivery_payment").html("Si");
									}

									if(String(Info[index].id_controversy_chargeback) != "undefined")									
									$('#my-modal-'+tmp[1]).find("#id_controversy_reason").val(Info[index].id_controversy_chargeback);
									
									if(String(Info[index].type) != "undefined")
										$('#my-modal-'+tmp[1]).find("#type").val(Info[index].type);
									if(String(Info[index].debit_time) != "undefined")
										$('#my-modal-'+tmp[1]).find("#debit_time").val(Info[index].debit_time);
									
									$('#my-modal-'+tmp[1]).find("#id_controversy_chargeback_d").val(1);
									$('#my-modal-'+tmp[1]).find("#id_controversy_chargeback_t").val(1);
									
									
									if(String(Info[index].payment_request_date) != "undefined")
										$('#my-modal-'+tmp[1]).find("#payment_request_date").val(Info[index].payment_request_date);
									
									if(String(Info[index].payment_delivery_date) != "undefined")
										$('#my-modal-'+tmp[1]).find("#payment_delivery_date").val(Info[index].payment_delivery_date);

									
									if(String(Info[index].accepted_payment) != "undefined"){										
										if(String(Info[index].accepted_payment) === "1"){
											$('#my-modal-'+tmp[1]).find("#accepted_payment").val(Info[index].accepted_payment);
										}else if(String(Info[index].accepted_payment) === "0"){
											$('#my-modal-'+tmp[1]).find("#accepted_payment").val(0);
										}
										else{
											$('#my-modal-'+tmp[1]).find("#accepted_payment").val('');
										}								
										//$('#my-modal-'+tmp[1]).find("#accepted_payment").val(Info[index].accepted_payment);
									}
																			
									if(String(Info[index].delivered_payment) != "undefined"){
										if(String(Info[index].delivered_payment) === "1"){
											$('#my-modal-'+tmp[1]).find("#delivery_payment").val(Info[index].delivered_payment);
										}else if(String(Info[index].delivered_payment) === "0"){
											$('#my-modal-'+tmp[1]).find("#delivery_payment").val(0);
										}
										else{
											$('#my-modal-'+tmp[1]).find("#delivery_payment").val(0);
										}								
									}
									
									if(String(Info[index].good_faith_request) != "undefined"){
										$('#my-modal-'+tmp[1]).find("#good_faith_payment_request8").val(Info[index].good_faith_request);									
									}
									
									if(String(Info[index].file_payment) != "undefined" && parseInt(Info[index].file_payment) > 0){
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).empty();
										$('#my-modal-'+tmp[1]).find(".download"+tmp[1]).append("<button name='"+Info[index].file_payment+"' id='"+Info[index].file_payment+"' class='btn default download'>Descargar</button>");
										$('#my-modal-'+tmp[1]).find(".download").click(function(){
											if(parseInt($('#my-modal-'+tmp[1]).find(".download").attr('id')) >0){
												descargaFile($('#my-modal-'+tmp[1]).find(".download").attr('id'));
											}
										});										
									}								
								}
								idCombo = "";
								nmCombo = "";
								combo1 = combo2 = "";
								contracargos = Info.contracargos; 
								for (index1 in contracargos){	
									if(String(index1) === "direct"){
										combo1 = 1;
									}
									if(String(index1) === "trad"){
										combo2 = 0;
									}
									
									if(String(index1) === "id_controversy_chargeback"){
										idCombo = contracargos[index1];
									}
									if(String(index1) === "name"){
										nmCombo = contracargos[index1];
									}
								}
								if(parseInt(combo1) === 1){
									if(parseInt(contracargos[index1]) !== 0){
										$("#id_controversy_chargeback_d").empty();
										$("#id_controversy_chargeback_d").append("<option value='"+idCombo+"'>"+nmCombo+"</option>");
									}									
								}
								if(parseInt(combo2) === 1){
									if(parseInt(contracargos[index1]) !== 0){
										$("#id_controversy_chargeback_t").empty();
										$("#id_controversy_chargeback_t").append("<option value='"+idCombo+"'>"+nmCombo+"</option>");
									}									
								}
								conditions = "";
								contracargos = Info.contidions
								for (index2 in contracargos){	
									if(String(contracargos[index2].name) != "undefined")
										conditions += contracargos[index2].name+"<br>";									
								}
								$("#condiciones").html(conditions);
								
								docs = "";
								contracargos = Info.docs
								for (index3 in contracargos){	
									if(String(contracargos[index3].name) != "undefined")
									docs += contracargos[index3].name+"<br>";									
								}
								$("#documentos").html(docs);
								
								represent = "";
								contracargos = Info.represent
								for (index4 in contracargos){	
									if(String(contracargos[index4].name) != "undefined")
										represent += contracargos[index4].name+"<br>";									
								}
								$("#representacion").html(represent);
								break;								
						}
						$('#my-modal-'+tmp[1]).css({display : 'block'});
					}
				}
			});
		} 		
	});
	
	$(".abonoBuenaFeBoton").click(function(){
		var div;
		var tmp;
		div = $(this).attr('id');
		tmp = div.split('-');
		$("#good_faith_payment_request"+tmp[1]).show();
		$("#buttonAbonoBuenaFe-"+tmp[1]).show();		
	});
	
	$(".rabonoBuenaFeBoton").click(function(){
		var div;
		var tmp;
		div = $(this).attr('id');
		tmp = div.split('-');
		$("#good_faith_delivery_request"+tmp[1]).show();
		$("#buttonFolioBuenaFe-"+tmp[1]).show();		
	});

	/** Evento para seleccionar los chargeback  **/
	$("#id_controversy_reason").change(function(){
		$("#id_controversy_chargeback_d").empty('');
		$("#id_controversy_chargeback_t").empty('');
		$("#type").val('');
		$("#debit_time").val('');
		$("#condiciones").html("");
		$("#documentos").html("");
		$("#representacion").html("");
		$("#id_controversy_chargeback_d").append("<option value=''>"+I18n._("Select")+"</option>");
		$("#id_controversy_chargeback_t").append("<option value=''>"+I18n._("Select")+"</option>");
		if(parseInt($("#id_controversy_reason").val()) > 0){
			$.ajax({																
				url : baseUrl + '/ticket-client-transaction/controversy-reason/',
				data : {
					id_controversy_reason : $("#id_controversy_reason").val(),
				},
				error : function(){
					error(I18n._("No connection to the Webservice"));
				},
				success : function(info){
					if(info == null){
						error(I18n._("No connection to the Webservice"));
						//setMessageTable('#clientInformationContainer', 'no-information-message');						
					}			
					else if(info.length == 0){
						error(I18n._("ChargesBack not found, please check the selection"));
						//setMessageTable('#accountInformationTable', 'client-account-message');
					}
					else{
						$("#type").val(info.reason.type);
						$("#debit_time").val(info.reason.debit_time);
						if(info.charge.length > 0){							
							for (indexj3 in info.charge){
								if(parseInt(info.charge[indexj3].type) === 1){
									$("#id_controversy_chargeback_d").append("<option value='"+info.charge[indexj3].id_controversy_chargeback+"'>"+info.charge[indexj3].name+"</option>");
								}
								if(parseInt(info.charge[indexj3].type) === 2){
									$("#id_controversy_chargeback_t").append("<option value='"+info.charge[indexj3].id_controversy_chargeback+"'>"+info.charge[indexj3].name+"</option>");
								}
							}							
						}

						if(info.issues.length > 0){
							for (indexj2 in info.issues){
								if(parseInt(info.issues[indexj2].type) === 1){
									$("#condiciones").append(info.issues[indexj2].name+"<br>");
								}
								if(parseInt(info.issues[indexj2].type) === 2){
									$("#documentos").append(info.issues[indexj2].name+"<br>");																	
								}
								if(parseInt(info.issues[indexj2].type) === 3){
									$("#representacion").append(info.issues[indexj2].name+"<br>");
								}
							}
						}
					}
				}
			});
		}
		return false;
	});
	
	$(".buttonFolioBuenaFe").click(function(){
		var tmp;
		tmp = $(this).attr('id').split('-');		
		var data = new FormData();
		if(parseInt($("#id_transactionId").val()) > 0 && String($("#good_faith_payment_request"+tmp[1]).val()) !== ''){
			data.append("id_transaction",$("#id_transactionId").val());
			data.append("good_faith_payment" ,$("#good_faith_delivery_request"+tmp[1]).val());
			data.append("tipo" ,2);
			$.ajax({																
				url : baseUrl + '/ticket-client/save-payment/',
				type: "POST",
				data : data,
				processData: false,
			    contentType: false,
				error : function(){
					error(I18n._("Failed to save data"));					
				},
				success : function(info){
					if(info === null){
						error1(I18n._("Failed to save data"));
					}
					else if(parseInt(info.exito) === 1){						
						exito(info.mensaje);
						if(parseInt(info.url) === 1)
							setTimeout(function(){location.href=baseUrl+"/ticket-client/my-tickets"},1200);
						else
							setTimeout(function(){location.href=baseUrl+"/ticket-client/new"},1200);
					}else{
						error1(info.mensaje);
					}
				}
			});				
		}
		return false;
		
	});

	$(".buttonAbonoBuenaFe").click(function(){
		var tmp;
		tmp = $(this).attr('id').split('-');		
		var data = new FormData();
		if(parseInt($("#id_transactionId").val()) >0   && String($("#good_faith_payment_request"+tmp[1]).val()) !== ''){
			data.append("id_transaction",$("#id_transactionId").val());
			data.append("good_faith_request" ,$("#good_faith_payment_request"+tmp[1]).val());
			data.append("tipo" ,1);
			$.ajax({																
				url : baseUrl + '/ticket-client/save-payment/',
				type: "POST",
				data : data,
				processData: false,
			    contentType: false,
				error : function(){
					error1(I18n._("Failed to save data"));					
				},
				success : function(info){
					if(info === null){
						error1(I18n._("Failed to save data"));
					}
					else if(parseInt(info.exito) === 1){
						exito(info.mensaje);
						if(parseInt(info.url) === 1)
							setTimeout(function(){location.href=baseUrl+"/ticket-client/my-tickets"},1200);
						else
							setTimeout(function(){location.href=baseUrl+"/ticket-client/new"},1200);						
					}else{
						error1(info.mensaje);
					}
				}
			});				
		}
		return false;
	});
	
	
	/********** Guardar datos del modal por tipo **************/
	$(".saveInformation").click(function(){
		var good_faith = 0;
		var data = new FormData();
		var div;
		var tmp;
		div = $(this).attr('id');
		tmp = div.split('-');
		$(".errorDeposit").html('<span style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
		$("#errorControversia").html("");
		switch(parseInt(tmp[1])){
			case 1:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file11")[0].files[0]);	
				types(data);
				break;
			case 2:
				typeTwo();
				break;
			case 3:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file31")[0].files[0]);
				types(data);
				break;
			case 4:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file41")[0].files[0]);
				types(data);
				break;
			case 5:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file51")[0].files[0]);
				types(data);
				break;
			case 6:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file61")[0].files[0]);
				types(data);
				break;
			case 7:
				data.append("id_transaction",$("#id_transactionId").val());
				data.append("file_payment"  ,   $("#file71")[0].files[0]);
				types(data);
				break;
			case 8:
				typeEight();
				break;
		}
		$(".errorDeposit").html('');
		$("#errorControversia").html("");
		return false;
	});
        
    $("#notClient").click(function(e){
        e.preventDefault();
        location.href=baseUrl+"/ticket-not-client/";
    });

	
	/**Evento para tipo de resolucion  **/
	$("#id_client_resolution").change(function(){
		var resoltuions;
		var data;
		$("#ris_recovered_amount").html("");
		if(parseInt($("#id_client_resolution").val()) >0){
			resoltuions = $("#resolutionsTypeJson").val().split("|");
			for (var k=0; k < resoltuions.length; k++){
				if(String(resoltuions[k]) !== ''){
					data = resoltuions[k].split(":");
					if(parseInt($("#id_client_resolution").val()) === parseInt(data[0])){
						$("#is_recovered_amount").val(data[1]);						
					}
				}				
			}
		}else{
			$("#is_recovered_amount").val('');
		}
		return false;
	});

	/***Evento para ver log****/
	$(".verLog").click(function(){
		var tmp;
		var detalles;
		var buffer;
		var contador;
		contador = 0;
		buffer = '';
		$("#tableLog").html('');
		tmp = $(this).attr('id').split("-");
		$("#noTab").val($(this).attr('id'));
		
		if(String($("#id_transaction").val()) != ""){
			$.ajax({																
				url : baseUrl + '/ticket-client-transaction/view-log/',
				data : {
					id_transaction : $("#id_transaction").val(),
					fecha_transaction : $("#fecha_transaction").val(),
				},
				error : function(){
					error(I18n._("No connection to the Webservice"));
				},
				success : function(info){
					if(info === null){
						error1(I18n._("No connection to the Webservice"));
					}
					else if(info.length === 0){
						error1(I18n._("No existe log para la transaccion"));
					}else{
						buffer += '<table class="bordered-table"><tbody>';
						for (indexj3 in info){
							buffer += '<tr><td style="background-color:#eeeeee;text-align:center;font-weight:bold;" colspan="4" width="100%">'+info[indexj3].nombre+'</td></tr>';
							detalles = info[indexj3].detalles;
							for(indexk3 in detalles){
								if(contador % 2 == 0){
									buffer += '<tr>';		
								}
								buffer += '<td style="background-color:#eeeeee;" width="25%">'+detalles[indexk3].nombre+'</td><td>'+detalles[indexk3].valor+'</td>';
								contador++;
							}						
						}
						buffer += '</tbody></table>';
						$("#tableLog").html(buffer);
					}
					$("#my-modal-"+tmp[1]).css({display : 'none'});
					$('#my-modal-log').css({display : 'block'});				
				}
			});
		}
		return false;
	});
	
	
	$(".closeLog, #closeLog").click(function(){
		var tmp;
		tmp = $("#noTab").val().split("-");
		$('#my-modal-log').css({display : 'none'});
		$("#my-modal-"+tmp[1]).css({display : 'block'});
		return false;
	});
	

	$("#guardar").click(function(){
		$("#error_folio_Conduset").html("");
		$("#error_category").html("");

		if(String($("#id_channel").val()) === ''){
			error(I18n._("Required field"));
			return false;
		} 
		
		if(parseInt($("#idTicketType").val()) === 2 && parseInt($("#id_channel").val()) ===6){
			if(String($("#folio_condusef").val()) === ''){
				error(I18n._("The Folio Condusef is Required"));
				return false;
			}					
		}		
		if(String($("#clientCategoryHidden").val()) === ''){
			error(I18n._("Required field"));
			return false;
		} 
		
		if(String($("#description").val()) === ''){
			error(I18n._("Required field"));			
			return false;
		}		
		
		if(String($("#description").val()) === ''){
			error(I18n._("Required field"));			
			return false;
		}		
		
		if(parseInt($("#idTicketType").val()) === 3 && parseInt($("#id_channel").val()) ===6){
			if(String($("#folio_conduset").val()) === ''){
				error(I18n._("The Folio Conduset is Required"));			
				return false;
			}					
		}
	});
	
	$('#idTicketType').change(function(){
		unicoTicket = 0;
		unicoTx = 0;
		$("#requiredCategoryContainer").css({display : 'block'});
		$("#label_category").css({display : 'block'});
		$('#requiredFieldsContainer').html('');
		$('#requiredDocumentsContainer').html('');
		$('#clientCategoryHidden').val('');
		$('.client-category').removeAttr('checked');
		
		$("#btnTransaction").show();			
		$("#descriptionFind").hide();
		$("#OtraTransaction").hide();
		$("#FinalTransaction").hide();									
		idTicketType = $('#idTicketType option:selected').val();		
		if(idTicketType != ''){
			if(parseInt(idTicketType) === 3){
				$("#requiredCategoryContainer").css({display : 'none'});
				$("#label_category").css({display : 'none'});
				$("#id_client_category").val(1);	
				$('#clientCategoryHidden').val(1);
				$("#btnTransaction").hide();			
				$("#descriptionFind").show();
				$("#OtraTransaction").show();
				$("#FinalTransaction").show();									
			}
			$('.ticketType').css({display : 'none'});
			$('#ticketType'+idTicketType).css({display : 'block'});
		}else{
			$("#id_reason").val('');
			$('.ticketType').css({display : 'none'});
			
		}
		return false;
	});

    $('.clear-required-field').click(function(){
		var tmp =$(this).attr('id').split('-');
		$("#requiredDocuments"+tmp[1]).val("");
    	return false;
    });
    
    //evento para visualizar al archivo{
    $("#descargarpartial").click(function(){
    	var idFile;
    	idFile = $("#descargarpartial").attr('value');
    	descargaFile(idFile);
    	return false;
    });
    $(".descargarpartialModal").click(function(){
    	var idFile;
    	idFile = $(this).attr('value');
    	descargaFile(idFile);
    	return false;
    });

});

function typeTwo(){
	var data = new FormData();
	data.append("id_transaction",$("#id_transaction").val());
	data.append("file_payment"  , $("#file21")[0].files[0]);	
	data.append("file_delivery" , $("#file22")[0].files[0]);
	$.ajax({
		url : baseUrl + '/ticket-client/save-types/',
		type: "POST",
		data : data,
		processData: false,
	    contentType: false,
		error : function(){
			error(I18n._("Failed to save data"));					
		},
		success : function(info){
			if(info === null){
				error1(I18n._("Failed to save data"));
			}
			else if(parseInt(info.exito) === 1){					
				exito(info.mensaje);						  
			}else{
				error1(info.mensaje);
			}
		}
	});				
}

function types(data){
	$.ajax({																
		url : baseUrl + '/ticket-client/save-types/',
		type: "POST",
		data : data,
		processData: false,
	    contentType: false,
		error : function(){
			error(I18n._("Failed to save data"));					
		},
		success : function(info){
			if(info === null){
				error1(I18n._("Failed to save data"));
			}
			else if(parseInt(info.exito) === 1){						
				exito(info.mensaje);						  
			}else{
				error1(info.mensaje);
			}
		}
	});	
}


function typeEight(){
	$("#errorControversia").html("");
	$("#errorControversia").html('<span id="paso" style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');	
	if(parseInt($("#id_controversy_reason").val()) >  0 && String($("#id_controversy_chargeback_d").val()) === ""  && String($("#id_controversy_chargeback_t").val()) === ""){
		error1('<span style="color:#ff0000;font-size:16px;">'+I18n._("Select a chargeback")+'</span>')
		return false;
	}
	if(parseInt($("#id_controversy_reason").val()) >  0 && parseInt($("#id_controversy_chargeback_d").val()) > 0  && parseInt($("#id_controversy_chargeback_t").val()) > 0){
		error1('<span style="color:#ff0000;font-size:16px;">'+I18n._("Select a chargeback")+'</span>')
		return false;
	}
	if(String($("#id_controversy_reason").val()) ==  "" && parseInt($("#id_controversy_chargeback_d").val()) > 0  && parseInt($("#id_controversy_chargeback_t").val()) > 0){
		error1('<span style="color:#ff0000;font-size:16px;">'+I18n._("Select a chargeback")+'</span>')
		return false;
	}
	//Paso validaciones ahora si guardo
	var data = new FormData();
	data.append("id_transaction",$("#id_transactionId").val());
	data.append("id_controversy_reason",$("#id_controversy_reason").val());
	data.append("id_controversy_chargeback_d", $("#id_controversy_chargeback_d").val());
	data.append("id_controversy_chargeback_t", $("#id_controversy_chargeback_t").val());
	data.append("payment_request_date", $("#payment_request_date").val());
	data.append("payment_delivery_date", $("#payment_delivery_date").val());
	data.append("accepted_payment", $("#accepted_payment").val());
	data.append("delivery_payment", $("#delivery_payment").val());
	if(String($("#file_payment").val()) !== "" && String($("#file_payment").val()) !== "undefined"){
		data.append("file_payment"  ,   $("#file_payment")[0].files[0]);
	}
	$.ajax({																
		url : baseUrl + '/ticket-client/save-types/',
		type: "POST",
		data : data,
		processData: false,
	    contentType: false,
		error : function(){
			error(I18n._("Failed to save data"));					
		},
		success : function(info){
			if(info === null){
				error1(I18n._("Failed to save data"));
			}
			else if(parseInt(info.exito) === 1){						
					exito(info.mensaje);
					$(".good_faith_amount").html(info.good_faith_amount);
					$(".good_faith_date").html(info.good_faith_date);
					$(".good_faith_payment").html(info.good_faith_payment);

			}else{
				error1(info.mensaje);
				$(".good_faith_amount").html(info.good_faith_amount);
				$(".good_faith_date").html(info.good_faith_date);
				$(".good_faith_payment").html(info.good_faith_payment);
			}
		}
	});
}

function openCity(evt, cityName,indexTab,idDiv) {
    var i, tabcontent, tablinks,nombre;
    nombre = cityName;
    tabcontent = document.getElementsByClassName("tabcontent"+idDiv);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks"+idDiv);
    for (i = 0; i < tablinks.length; i++) {
    	tablinks[i].style.background = "#ffffff";
    	tablinks[i].style.color= "#333333";
    }
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
        if(i === indexTab){
        	tablinks[i].style.background = "#57a957";
        	tablinks[i].style.color= "#ffffff";
    	}
    }
    document.getElementById(nombre).style.display = "block";
    evt.currentTarget.className += " active";
}

function openCity2(evt2, cityName2,indexTab2) {
    var j, tabcontent2, tablinks2,nombre2;
    nombre2 = cityName2;
    tabcontent2 = document.getElementsByClassName("tabcontentm");
    for (j = 0; j < tabcontent2.length; j++) {
        tabcontent2[j].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("tablinksm");
    for (j = 0; j < tablinks2.length; j++) {
    	tablinks2[j].style.background = "#ffffff";
    	tablinks2[j].style.color= "#333333";
    }
    for (j = 0; j < tablinks2.length; j++) {
        tablinks2[j].className = tablinks2[j].className.replace(" active", "");
        if(j == indexTab2){
        	tablinks2[j].style.background = "#57a957";
        	tablinks2[j].style.color= "#ffffff";
    	}
    }
    document.getElementById(nombre2).style.display = "block";
    evt2.currentTarget.className += " active";
}


/**
 * Metodo para mostrar las preguntas, la validacion de las 5 perguntas o el error
 * @param clientFullInfo
 * @param valor
 * @param indicQuestion
 * @param arrayQuestion
 * @returns
 */
function revisarPreguntas(clientFullInfo,valor,indicQuestion,arrayQuestion){
	var buffer;
	buffer = "";
	switch(valor){
		case 0:
			buffer = viewQuestion(clientFullInfo);
			$("#preguntas").html(buffer);													
			indicQuestion++;
			break;
		case 1:
			clientFullTable.find('#correcto').hide();
			clientFullTable.find('#incorrecto').hide();
			recuperaCuenta(clientFullInfo,arrayQuestion);
			break;
		case 2:															
			clientFullTable.find('#correcto').hide();
			clientFullTable.find('#incorrecto').hide();
			$('#preguntas').css({ color: "#cf453f", background: "#ffffFF", "font-size": "24pt","text-align": "center"});
			$('#preguntas').html("<br><br>"+I18n._("NON-SUCCESSFUL VALIDATION"));
			setTimeout(function(){location.href=baseUrl+"/ticket-client/new"},3000);															
			break;
	}	
	return indicQuestion; 
}



/**
 * Metodo que sirve para revisar cuantas preguntas correctos e incorrectas
 * @param clientFullInfo
 * @param arrayQuestion
 */
function recuperaCuenta(clientFullInfo,arrayQuestion){
	var renglon;
	var tmpAccount;
	var buttons;
	renglon = 0;
	tmpAccount = buttons = '';
	if(arrayQuestion.length > 0){
		for(var h=1; h <= arrayQuestion.length; h++){
			if(parseInt(arrayQuestion[h]) == 1)
				$("#r-"+h).css({background: "#5fbe5f" });
			else
				$("#r-"+h).css({background: "#cf453f" });
		}
	}	
	if(parseInt(unicoTicket) === 0){
		$.ajax({																
			url : baseUrl + '/ticket-client/get-account-information/',
			data : {
				clientNumber : clientFullInfo.client_number,
				clientAccount: $("#accountTmp").val(),
			},
			error : function(){
				//setMessageTable('#clientInformationContainer', 'no-information-message');
			},
			success : function(accountInfo){
				renglon = 0;
				if(accountInfo == null){
					//setMessageTable('#clientInformationContainer', 'no-information-message');			
				}
                if(accountInfo.error){
                	setMessageTable('#clientInformationContainer', 'no-information-message');
                    $("#messageDiv").find("#message").html(accountInfo.error);
                }
				else if(accountInfo.length == 0){
					//setMessageTable('#accountInformationTable', 'client-account-message');
				}
				else{
					// recupera las cuentas asociadas al numero de cliente					
					$('#clientInformationContainer').html('');
					informationTable = $("#InformationClientTable").clone();
					informationTable.attr('id',clientFullInfo.client_number);
					informationTable.find('.clientNumber').html(clientFullInfo.client_number);
					informationTable.find('.name').html(clientFullInfo.name);
					$('#clientInformationContainer').append(informationTable);
					for (indexj2 in accountInfo){	
					    accountTable = $('#accountInformationTable').clone();
						accountTable.attr('id',accountInfo[indexj2].card_number);
						accountTable.find('.accountNumbers').val(accountInfo[indexj2].account).attr('id',accountInfo[indexj2].account).click(selectAccount);						
						accountTable.find('.account').html(accountInfo[indexj2].account);
						accountTable.find('.type').html(accountInfo[indexj2].type);
						accountTable.find('.cardNumber').html(accountInfo[indexj2].card_number);
						accountTable.find('.nmTypes').html(accountInfo[indexj2].type.trim());
						accountTable.find('.nmProducts').attr('id','d'+accountInfo[indexj2].account);
						tmp = accountInfo[indexj2].p;				
						if(String(tmp) !== ""){
							productIds = tmp.split("*");
							if(productIds.length > 0){
								accountTable.find('.nmProducts').html('');
								for(var k = 0; k < (productIds.length-1); k++){
									propierts = productIds[k].split("|");
									if(String($("#accountTmp").val()) === String(accountInfo[indexj2].account)){
										accountTable.find('#'+accountInfo[indexj2].account).attr('checked',true);
										accountTable.find('#'+accountInfo[indexj2].account).hide();
										accountTable.find('#d'+accountInfo[indexj2].account).append('<button id="'+accountInfo[indexj2].account+"-"+propierts[0]+"-"+propierts[1]+"-"+propierts[2]+"-"+accountInfo[indexj2].type+'" '+regresaClase(propierts[0])+' name="'+accountInfo[indexj2].account+"-"+propierts[0]+"-"+propierts[1]+"-"+propierts[2]+'" class="btn default">'+propierts[1]+'</button>&nbsp;&nbsp;');
									} 								
								}
							}
						}
						informationTable.css({display : 'block'});
						accountTable.css({display : 'block'});
						$('#clientInformationContainer').append(accountTable);	
					}
					unicoTicket++;
					//evento para seleccionar la cuenta y desplegar los productos sin cuenta default
					$('#clientInformationContainer').find('.accountNumbers').click(function(){
						unicoTicket = unicoRegreso = unicoSaldo = unicoTx = 0
						muestraProductos(clientFullInfo,$(this).attr('id'),arrayQuestion);				
					});
					//evento para seleccionar la cuenta y desplegar los productos, cuando el producto es por default
					$('#clientInformationContainer').find('.nvoTicket').click(function(){
						var tmpData;
						var cadena;		
						$("#mensajeError").html("");
						unicoSaldo = unicoTx = unicoTicket = unicoRegreso = 0;
						$("#idTicketType").val('');
						$("#id_reason").val('');
						tmpData = $(this).attr('id').split('-');	
						if(String(tmpData[0]) !== "" && parseInt(tmpData[1]) > 0){
							cadena = tmpData[0]+"-"+tmpData[1]+"-"+tmpData[2]+"-"+tmpData[3]+"-"+tmpData[5];
							seleccionaProducto(clientFullInfo,tmpData[0],cadena,arrayQuestion);
						}					
					});
				}
			}
		});			
	}
}

/**
 * Metodo que se encarga de mostrar los productos por cuenta
 * @param clientFullInfo
 * @param account
 */
function muestraProductos(clientFullInfo,account,arrayQuestion){	
	$(".nmProducts").html("");
	$(".accountNumbers").show();
	tmpAccount = account;	
	tmp="";
	$('#'+tmpAccount).hide();
	$('#d'+tmpAccount).html('<span style="color:#ff0000;font-size:18px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
	$.ajax({																
		url : baseUrl + '/ticket-client/get-product-information/',
		data : {
			clientNumber : clientFullInfo.client_number,
			clientAccount: account,							
		},
		error : function(){
			//setMessageTable('#clientInformationContainer', 'no-information-message');
		},success : function(productInfo){
			renglon = 0;			
			if(productInfo == null){
				//setMessageTable('#clientInformationContainer', 'no-information-message');
				//$('#mensajeError').html(I18n._("No connection to the Webservice"));
				error(I18n._("No connection to the Webservice"));
			}
             if(productInfo.error){
            	 setMessageTable('#clientInformationContainer', 'no-information-message');
                 $("#messageDiv").find("#message").html(productInfo.error);
            }
			else if(productInfo.length == 0){
				//setMessageTable('#clientInformationContainer', 'no-information-message');
				$('#d'+tmpAccount).html(I18n._("Account has no products"));
				error(I18n._("Account has no products"));
			}
			else{
				buttons = "";
				for (indexj3 in productInfo){
					//$('.typeAccount').html(productInfo[indexj3].type);
					//$('.cardNumber').html(productInfo[indexj3].card_number);	
					//$("#no_card").val(productInfo[indexj3].card_number);
					$("#name_client").val(clientFullInfo.name);
					//$("#account_type").val(productInfo[indexj3].type);
					accountTable = $('#accountInformationTable').clone();				    
					tmp = productInfo[indexj3].p;
					if(String(tmp) !== ""){
						productIds = tmp.split("*");
						if(productIds.length > 0){
							accountTable.find('.nmProducts').html('');
							for(var k = 0; k < (productIds.length-1); k++){
								if(String(tmpAccount) === String(productInfo[indexj3].account)){
									propierts = productIds[k].split("|");				
									buttons+='<button id="'+tmpAccount+"-"+propierts[0]+"-"+propierts[1]+"-"+propierts[2]+"-"+productInfo[indexj3].type+"-"+productInfo[indexj3].card_number+'" '+regresaClase(propierts[0])+' name="'+tmpAccount+"-"+propierts[0]+"-"+propierts[1]+"-"+propierts[3]+"-"+productInfo[indexj3].type+'">'+propierts[1]+'</button>&nbsp;&nbsp;';													
								}
							}
						}
					}
				}								
				$('#d'+tmpAccount).html(buttons);						
				$('#clientInformationContainer').find('.nvoTicket').click(function(){					
					seleccionaProducto(clientFullInfo,account,$(this).attr('id'),arrayQuestion);
				});
			}
		}
	});	
	return false;
}
	
/** 
 * Metodo para seleccionar productos
 * @param clientFullInfo
 * @param account
 * @param productId
 */
function seleccionaProducto(clientFullInfo,account,productId,arrayQuestion){
	$("#transactionsTicket").css({display:'none'});
	$("#transactionsTmp").css({display:'none'});
	var datos;
	if(String(productId) != ""){
		datos = productId.split('-');
		//luis
		
		information = $("#newTicketTab2").clone();		
		information.find('.clientNumber').html(clientFullInfo.client_number);
		information.find('.accountNumber').html(account);
		information.find('.name').html(clientFullInfo.name);
		information.find('.product').html(datos[2]);		
		$("#clientInformationContainer").html(information);
		information.css({display : 'block'});				
		$("#accountTmp").val(account);
		$("#client_number").val(clientFullInfo.client_number);
		$('#newForm').find("#id_product").val(datos[1]);
		$('#newForm').find("#id_product_bam").val(datos[3]);
		$('#newForm').find("#chanel").val(datos[2]);
		$('#newForm').find("#email").val(clientFullInfo.email);
		$('#newForm').find("#id_entidad").val(clientFullInfo.id_entidad);
		$('.cardNumber').html(datos[5]);	
		$("#no_card").val(datos[5]);
		$('.typeAccount').html(datos[4]);
		$("#account_type").val(datos[4]);
		
		if(clientFullInfo.home_phone != 'null' && clientFullInfo.home_phone !== ''){
			$('#newForm').find("#telefono").val(clientFullInfo.home_phone);	
		}else{
			if(clientFullInfo.mobile_phone != 'null' && clientFullInfo.mobile_phone !== ''){
				$('#newForm').find("#telefono").val(clientFullInfo.mobile_phone);
			}else{
				$('#newForm').find("#telefono").val('No se registro telefono');
			}
		}
		
		$('#newForm').find("#state_client").val(clientFullInfo.state);
		$('#newForm').find("#employee").val(clientFullInfo.employee);
		$('#newForm').find("#card_type").val(clientFullInfo.card_type);
		
		if(parseInt($("#branchUser").val()) > 0){
//			$('#newForm').find('#id_origin_branch').val($("#branchUser").val());
//			$('#newForm').find('#id_origin_branch_tmp').attr('disabled',true);
			$('#newForm').find('#id_reported_branch').val($("#branchUser").val());
			$('#newForm').find('#id_reported_branch_tmp').val($("#branchUser").val());
			$('#newForm').find('#id_reported_branch_tmp').attr('disabled',true);
		}
		if(parseInt($("#canalUser").val()) > 0){
			$('#newForm').find('#id_channel').val($("#canalUser").val());
			$('#newForm').find('#id_channel_tmp').attr('disabled',true);
		}
		if(parseInt(clientFullInfo.id_branch) > 0){
			$('#newForm').find('#id_origin_branch').val(clientFullInfo.id_branch);
			$('#newForm').find('#id_origin_branch_tmp').val(clientFullInfo.id_branch);
			$('#newForm').find('#id_origin_branch_tmp').attr('disabled',true);	
//			$('#newForm').find('#id_reported_branch').val(clientFullInfo.id_branch);
//			$('#newForm').find('#id_reported_branch_tmp').val(clientFullInfo.id_branch);
//			$('#newForm').find('#id_reported_branch_tmp').attr('disabled',true);
		}

		$('#newForm').css({display : 'block',});
		
		$('#idTicketType').change(function(){
			$("#movments").val("-1");
			$("#newTicket").css({display:'none'});
			$("#findTicket").css({display:'none'});			
			$("#transactionsTicket").css({display:'none'});
			$("#transactionsTmp").css({display:'none'});
			$('#mensajeError').html("");
			if(parseInt($('#idTicketType').val())> 0){				
				if(parseInt(unicoTicket) === 0){
					$.ajax({																
						url : baseUrl + '/ticket-client/get-reasons-information/',
						data : {
							clientIdProduct:datos[1],
							idTicketType : $('#newForm').find('#idTicketType').val()
						},
						error : function(){
							//$('#mensajeError').html(I18n._("Failed to query Database"));
							error(I18n._("Failed to query Database"));
						},
						success : function(reasonsInfo){
							if(reasonsInfo === null){
								//$('#mensajeError').html(I18n._("No connection to the Webservice"));
								error(I18n._("No connection to the Webservice"));
							}
							else if(reasonsInfo.length === 0  || String(reasonsInfo) === ""){
								//$('#mensajeError').html(I18n._("The product has no registered reason"));
								error(I18n._("The product has no registered reason"));
								$("#id_reason").val('');
								$("#id_reason").attr('disabled',true);
							}
							else{
								$("#id_reason").attr('disabled',false);
								$('#newForm').find("#id_reason").empty();
								if(reasonsInfo.length > 0){
									$('#newForm').find("#id_reason").append('<option value="">'+I18n._("Select")+'</option>');							
									for (indexj2 in reasonsInfo){
										$('#newForm').find("#id_reason").append('<option value="'+reasonsInfo[indexj2].id_client_category+'-'+reasonsInfo[indexj2].financial_movement+'-'+reasonsInfo[indexj2].partialities+'-'+reasonsInfo[indexj2].type+'-'+reasonsInfo[indexj2].movments+'">'+reasonsInfo[indexj2].name+'</option>');
									}
								}
								unicoTicket++;
							}
						}
					});
				}
			}else{
				$("#id_reason").attr('disabled',true);
				$("#id_reason").val('');
			}
			return false;
		});
		
		$("#newForm").find('#period').change(function(){
			if(parseInt($('#period').val()) == 0){	
				$("#start_date").attr('disabled', false);
				$("#end_date").attr('disabled', false);
			}else{
				$("#start_date").val('');
				$("#end_date").val('');
				$("#start_date").attr('disabled', true);
				$("#end_date").attr('disabled', true);				
			}
			return false;
		});
		
		$("#newForm").find('#start_date').change(function(){
			if(String($("#newForm").find('#start_date').val()) !== ''){
				$('#period').val(0);
			}
			if( (String($("#newForm").find('#start_date').val()) !== '')  &&  (String($("#newForm").find('#end_date').val()) !== '') ){
				if( $("#newForm").find('#start_date').val() > $("#newForm").find('#end_date').val()){
					$("#newForm").find('#start_date').val($("#newForm").find('#end_date').val());
				}
			}
			return false;
		});
		
		$("#newForm").find('#end_date').change(function(){
			if(String($("#newForm").find('#end_date').val()) !== ''){
				$('#period').val(0);
			}
			if( (String($("#newForm").find('#start_date').val()) !== '')  &&  (String($("#newForm").find('#end_date').val()) !== '') ){
				if( $("#newForm").find('#start_date').val() > $("#newForm").find('#end_date').val()){
					$("#newForm").find('#start_date').val($("#newForm").find('#end_date').val());
				}
			}
			return false;			
		});
		
		
		$('#newForm').find('#id_reason').change(function(){
			var tmpReason;  
			value = $('#newForm').find('#id_reason').val();
			tmpReason = value.split("-");
			if(parseInt($("#idTicketType").val()) > 0 && parseInt($("#idTicketType").val()) !== 3 && String(value) !== '' && parseInt(tmpReason[0]) > 0){
				
				setLoader('#requiredFieldsContainer', 'required-fields-message');
				$.ajax({
					url : baseUrl + '/ticket-client/get-required-fields/',
					data : {
						id_client_category : tmpReason[0],
					},
					error : function(){
						setMessageTable('#requiredFieldsContainer', 'error-message');
					},
					success : function(requiredFields){
						$('#requiredFieldsContainer').html('');
						for (index in requiredFields){
							fieldDiv = $('#requiredField').clone();
							fieldDiv.css({
								display : 'block',
							});
							regExp = $(this).attr('reg-exp');
							fieldDiv.find('.label-name').html(requiredFields[index].name);
							fieldDiv.find('.name-required-field')
							.attr('name','requiredFields['+requiredFields[index].id_field + ']')
							.attr('id','requiredFields['+requiredFields[index].id_field + ']')
							.attr('rule',requiredFields[index].reg_ex);
							
							
							if (requiredFields[index].sample !== null)
								fieldDiv.find('.name-required-field').attr('placeholder','Sample: ' + requiredFields[index].sample);							
							$('#requiredFieldsContainer').append(fieldDiv);
						}
						$('.validate').validate();
					},
				});
				
				
				setLoader('#requiredDocumentsContainer', 'required-documents-message');
				$.ajax({
					url : baseUrl + '/ticket-client/get-required-documents/',
					data : {
						id_client_category : tmpReason[0],
					},
					error : function(){
						setMessageTable('#requiredDocumentsContainer', 'error-message');
					},
					success : function(requiredDocuments){
						$('#requiredDocumentsContainer').html('');
		                number=0;						
		                documentDiv = $('#requiredDocument').clone();
						for (index in requiredDocuments){			
			                documentDiv = $('#requiredDocument').clone();							
			                documentDiv.css({display : 'block'});	
							documentDiv.find('.label-name').html(requiredDocuments[index].name);
							documentDiv.find('.name-required-document')
							.attr('name','requiredDocuments'+requiredDocuments[index].id_document)
							.attr('id','requiredDocuments'+requiredDocuments[index].id_document);							
							
							documentDiv.find('.clear-required-field')
							.attr('id','clear-'+requiredDocuments[index].id_document)
							.attr('name','clear-'+requiredDocuments[index].id_document);							
							$('#requiredDocumentsContainer').append(documentDiv);
		                    number++;
						}						
						$("#number_files").val(number);
		                documentDiv.find('.clear').click(function(){
		        			var tmp =$(this).attr('id').split('-');
		        			$("#requiredDocuments"+tmp[1]).val("");
		                	return false;
		                });
					},
				});
			}
		});

		
		$('#newForm').find('#id_reason').change(function(){			
			var tmpArray;
			unicoTicket = 0;
			$("#t_period").show();
			$("#t_start_date").show();
			$("#t_end_date").show();			
			if(String($('#id_reason').val()) === ''){
				$("#newTicket").css({display:'none'});
				$("#findTicket").css({display:'none'});			
				$("#transactionsTicket").css({display:'none'});
				$("#transactionsTmp").css({display:'none'});
				$("#condusef").css({display:'none'});
			}
			else if(parseInt($('#newForm').find('#idTicketType').val()) !== 2 && parseInt($('#newForm').find('#idTicketType').val()) !== 3 && parseInt($('#newForm').find('#idTicketType').val()) !== 4 ){
				//No son aclaraciones,quejas  ni consultas
				tmpArray = $('#id_reason').val().split("-");
				$('#clientCategoryHidden').val(tmpArray['0']);
				$("#newTicket").css({display:'block'});
				$("#findTicket").css({display:'none'});
				$("#transactionsTicket").css({display:'none'});		
				$("#transactionsTmp").css({display:'none'});
				$("#condusef").css({display:'none'});
			}			
			else{				
				if(parseInt($('#newForm').find('#idTicketType').val()) === 2){
					$("#condusef").css({display:'block'});
				}else{
					$("#condusef").css({display:'none'});
				}				
				tmpArray = $('#id_reason').val().split("-");
				$('#clientCategoryHidden').val(tmpArray['0']);
				$("#partialities").val(tmpArray[2]);
				if( (parseInt($('#newForm').find('#idTicketType').val()) === 2) || (parseInt($('#newForm').find('#idTicketType').val()) === 4) ){				
					if(parseInt(tmpArray[1]) !== 1){					
						$("#newTicket").css({display:'block'});
						$("#findTicket").css({display:'none'});
						$("#transactionsTicket").css({display:'none'});	
						$("#transactionsTmp").css({display:'none'});
					}else{
						$("#findTicket").css({display:'block'});
						$("#newTicket").css({display:'none'});
						$("#transactionsTicket").css({display:'none'});			
						$("#transactionsTmp").css({display:'none'});
					}			
				}
				//son consultas
				if(parseInt($('#newForm').find('#idTicketType').val()) === 3){
					$("#newForm").find('#period').val(1)
					$("#t_period").hide();
					$("#t_start_date").hide();
					$("#t_end_date").hide();
					$("#findTicket").css({display:'block'});
					$("#newTicket").css({display:'none'});
					$("#btnTransaction").hide();			
					$("#descriptionFind").show();
					$("#OtraTransaction").show();
					$("#FinalTransaction").show();	
					$("#transactionsTicket").css({display:'none'});
					$("#transactionsTmp").css({display:'none'});
					if(parseInt(tmpArray[3]) === 4 && parseInt(tmpArray[4]) >= 0){
						$("#movments").val(tmpArray[4]);
					}
				}
					
			}
			return false;
		});
		
		/** Evento para buscar transacciones de una cuenta  **/
		$("#newForm").find('#find').click(function(){	
			$("#transactionsTmp").css({display:'none'});
			$("#newForm").find("#tableTransacctions").html("");
			$("#newForm").find("#rdescriptionConsulta").html("");
			$("#newForm").find("#mensajeError").html("");
			$("#btnTransaction").show();
			$("#OtraTransaction").hide();
			$("#FinalTransaction").hide();
			$("#descriptionFind").hide();
			//(parseInt($("#movments").val()) > 0) &&
			if(  ((String($("#newForm").find('#start_date').val()) !== '')  &&  (String($("#newForm").find('#end_date').val()) !== '')) || (parseInt($("#newForm").find('#period').val()) > 0)  ){
				if( parseInt($("#movments").val())  !== 0){
					$("#transactionsTmp").show();
					$("#leyendaSaldo").html("");
					if(parseInt(unicoTicket) === 0){
						$.ajax({																
							url : baseUrl + '/ticket-client/get-transactions-information/',
							data : {
								clientNumber : clientFullInfo.client_number,
								clientAccount: account,			
								clientIdProduct:datos[3],
								clientPeriod:  $('#period').val(),
								clientStartDate : $('#start_date').val(),
								clientEndDate : $('#end_date').val(),
								movments: $("#movments").val(),
							},
							error : function(){
								error(I18n._("No connection to the Webservice"));
								return false;
							},success : function(transactionsInfo){
								if(transactionsInfo == null){
									error(I18n._("No connection to the Webservice"));
									return false;
								}
								if(transactionsInfo.error){
									if(transactionsInfo.error == "No existen registros"){
										error(I18n._("Transactions not found, please check the selection"));
                                    }else{                                    	
                                    	error(transactionsInfo.error);
                                    }
									return false;
								}
								else if(transactionsInfo.length == 0){
									error(I18n._("Transactions not found, please check the selection"));
									return false;
								}
								else{	
									var contadorTrans;
									contadorTrans = 0;
									var bufferTrans;
									var bufferheader;
									bufferTrans = bufferheader = "";
									for (indexj2 in transactionsInfo){
										$("#newForm").find("#tableTransacctions").css({width:"100%;"});								
										if(contadorTrans === 0){
											bufferheader = '<tr>';
											if(parseInt($('#newForm').find('#idTicketType').val()) !== 3){
												bufferheader += '<td>&nbsp;</td>';
											}
											bufferheader += '<td style="font-weight:bold;">'+I18n._("ID")+'</td>'+
													'<td style="font-weight:bold;">'+I18n._("Transaction date")+'</td>'+											
													'<td style="font-weight:bold;">'+I18n._("Post date")+'</td>'+											
													'<td style="font-weight:bold;">'+I18n._("Description")+'</td>'+
													'<td style="font-weight:bold;">'+I18n._("Reference number")+'</td>'+
													'<td style="font-weight:bold;">'+I18n._("Amount")+'</td>';
											if(parseInt($("#partialities").val()) == 1){
												bufferheader += '<td></td>';
											}
											bufferheader +='</tr>';
											$("#newForm").find("#tableTransacctions").append(bufferheader);
										}
										contadorTrans = contadorTrans + 1;
										
										bufferTrans  +='<tr id="reng-'+transactionsInfo[indexj2].id_transaction+'*'+transactionsInfo[indexj2].id_type_transaction+'">';
										if(parseInt($('#newForm').find('#idTicketType').val()) !== 3){
											bufferTrans  +='<td><input type="checkbox" class="checkboxes" name="checkbox-'+transactionsInfo[indexj2].id_transaction+'"  id="'+transactionsInfo[indexj2].id_transaction+'*'+transactionsInfo[indexj2].transaction_date+'*'+transactionsInfo[indexj2].amount+'*'+transactionsInfo[indexj2].id_type_transaction+'" value="'+transactionsInfo[indexj2].id_transaction+'*'+transactionsInfo[indexj2].transaction_date+'*'+transactionsInfo[indexj2].amount+'*'+transactionsInfo[indexj2].id_type_transaction+'*'+transactionsInfo[indexj2].reference+'*'+transactionsInfo[indexj2].comerce+'*'+transactionsInfo[indexj2].afilition+'*'+transactionsInfo[indexj2].reference_number+'*'+transactionsInfo[indexj2].descriptions+'"></td>';
										}
										bufferTrans  +='<td>'+transactionsInfo[indexj2].id_transaction+'</td>'+
										'<td>'+transactionsInfo[indexj2].transaction_date+'</td>'+
										'<td>'+transactionsInfo[indexj2].post_date+'</td>'+
										'<td>'+transactionsInfo[indexj2].descriptions+'</td>'+
										'<td>'+transactionsInfo[indexj2].reference_number+'</td>'+
										'<td>'+transactionsInfo[indexj2].amount+'</td>';
										if(parseInt($("#partialities").val()) == 1){
											bufferTrans  +='<td><button class="checkboxesModal btn default" name="'+transactionsInfo[indexj2].id_transaction+'-boton" id="'+transactionsInfo[indexj2].id_transaction+'*'+transactionsInfo[indexj2].transaction_date+'*boton" style="disabled:true;">'+I18n._("More")+'</button></td>';
										}
										bufferTrans  +='</tr>';
									}
									$("#newForm").find("#tableTransacctions").append(bufferTrans);
									$(".inicio").css({display:'none'});
									$("#newTicket").css({display:'none'});
									$("#findTicket").css({display:'none'});								
									$("#transactionsTicket").css({display:'block'});
									$("#transactionsTmp").css({display:'block'});
				        			if(parseInt($("#movments").val()) > 0){
										$("#btnTransaction").css({display:'none'});
										$("#descriptionFind").show();
										$("#OtraTransaction").show();
										$("#FinalTransaction").show();	
				        			}
									
									$("#newForm").find(".checkboxesModal").click(function(){
										$('#my-modal-new').find("#descargarpartial").css({display:'none'});
										var div="";
										var tmp;
										var divCheck = "";
						        		div = $(this).attr('id');					        		
						        		tmp = div.split("*");
						        		divCheck = tmp[0]+"*"+tmp[1];
					        			$("#newForm").find("#mensajeError").html("");
					        			$('#my-modal-new').find("#saveDeposit").attr('disabled',false);
					        			$('#my-modal-new').find("#errorDeposit").css({color:"#ff0000"});
					        			$('#my-modal-new').find("#errorDeposit").html("");						        		
						        		if(String(tmp[0]) != ""){
						        			$('#my-modal-new').find("#idInfTransaction").val(tmp[0]);						        
											$('#my-modal-new').find("#amountDeposited").val("");
						        			$('#my-modal-new').find("#dateDeposited").val("");
						        			$('#my-modal-new').find("#fileDeposited").val("");
						        			$('#my-modal-new').find("#typeDeposit").val(1);
						        			$('#my-modal-new').css({display : 'block'});
						        		}						        		
					        			return false;
									});
									
									
									$("#newForm").find(".checkboxes").click(function(){								
										var ids = "";
								        $('.checkboxes').each(function(){
								        	if($("#newForm").find(this).is(':checked')){
								        		ids = ids+$(this).attr('id')+"|";								        		
								        	}
								        });
								        $("#idsTransacciones").val(ids);
									});
								}
							}
						});
					}
				}else{
					$("#transactionsTicket").css({display:'block'});
					$("#transactionsTmp").css({display:'none'});
					$("#btnTransaction").hide();
					$("#OtraTransaction").show();
					$("#FinalTransaction").show();
					$("#descriptionFind").show();
					if(parseInt(unicoSaldo) === 0){
						$.ajax({																
							url : baseUrl + '/ticket-client/get-saldo-information/',
							data : {
								clientAccount: account,			
							},
							error : function(){						
								error(I18n._("No connection to the Webservice"));
								unicoSaldo = 0;
							},success : function(transactionsInfo){
                                if(transactionsInfo.error){
                                	error(transactionsInfo.error);
                                    setMessageTable('#clientInformationContainer', 'no-information-message');
                                    $("#messageDiv").find("#message").html(transactionsInfo.error);
                                    $("#newForm").hide();
                                    unicoSaldo = 0;
                                }
								else if(transactionsInfo.length == 0){
									error(I18n._("Transactions not found, please check the selection"));
									unicoSaldo = 0;
								}
								else{									
									$("#leyendaSaldo").html(I18n._("Current balance")+":"+transactionsInfo);
									$("#btnTransaction").css({display:'none'});
									$("#descriptionFind").show();
									$("#OtraTransaction").show();
									$("#FinalTransaction").show();	
									$(".inicio").css({display:'none'});
									$("#newTicket").css({display:'none'});
									$("#findTicket").css({display:'none'});								
								}
							}
						});
					}
					unicoSaldo++;
				}
			}else{
				error(I18n._("Please select a period"));
			}
		
			return false;
		});
		
		/** Evento para despues de seleccionar las transacciones que hay que ligar al ticket**/
		$("#newForm").find("#btnTransaction").click(function(){
			var tmp2;
			var tmp;
			var contador;
			var arrayTypes;
			var str; 
			var idDiv;
			str = idDiv = "";
			contador=0;
			$("#newForm").find("#mensajeError").html("");
			if(String($("#idsTransacciones").val()) !== ""){				
				$(".checkboxes").each(function(){
					if($(this).attr('checked')){
						tmp = $(this).attr('id').split("*");
						if(parseInt(str.indexOf(tmp[3])) === -1 ){
							str += tmp[3]+"|";						
						}
					}
				});
				arrayTypes = str.split("|");
				if(arrayTypes.length > 2){
					error(I18n._("Select transactions of one type"));
				}else{
					$("#newForm").find(".checkboxes").each(function(){
						tmp2 = $(this).attr('id').split('*');
						idDiv="reng-"+tmp2[0]+"*"+tmp2[3];
						if($(this).attr('checked')){
							$(this).closest('tr').css({background:'#ffff99'});
						}else{
							$(this).closest('tr').remove();						
						}						
					});
					$("#tableDes").css({display:'none'});
					$(".checkboxesModal").css({display:'none'});
					$(".checkboxes").css({display:'none'});
					$("#transactionsTmp").css({'overflow-y': 'auto'});
					$("#transactionsTicket").css({display:'block'});
					$("#transactionsTmp").css({display:'block'});
					$("#findTicket").css({display:'none'});
					$("#btnTransaction").css({display:'none'});
					$("#btnTransactionRegresar").css({display:'none'});
					$("#newTicket").css({display:'block'});
				}
				return false;
			}else{
				error(I18n._("Select a transaction"));
			}
			return false;
		});
		
		/** Evento para otra consulta **/
		$("#newForm").find(".otras").click(function(){
			var boton;
			boton = 2;
			if(String($(this).attr('id')) === "OtraTransaction"){
				boton = 1;
			}
			var data = new FormData();	
			$("#rdescriptionConsulta").html("");
			data.append("id_reason",$('#id_reason').val());
			data.append("id_ticket_type",$('#midTicketType').val());
	    	data.append("account_number",$('#account_number').val());
  			data.append("id_reported_branch",$('#id_reported_branch').val());
  			data.append("description",$('#descriptionConsulta').val());
  			data.append("id_product",$('#id_product').val());
  			data.append("id_product_bam",$('#id_product_bam').val());
  			data.append("email",$('#email').val());
  			data.append("id_entidad",$('#id_entidad').val());
  			data.append("state_client",$('#state_client').val());
  			data.append("client_number",$('#client_number').val());
  			if( String($('#id_reason').val()) !== ''  && parseInt($('#idTicketType').val()) > 0  && parseInt($('#id_reported_branch').val()) > 0  
  				&& String($('#account_number').val()) !== '' && String($('#descriptionConsulta').val()) !== ''){
  				$("#rdescriptionConsulta").html('<span style="color:#ff0000;font-size:16px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
  				$.ajax({																
  					url : baseUrl + '/ticket-client/creaet-ajax/',
  					type: "POST",
  					data : data,
  					processData: false,
  				    contentType: false,
  					error : function(){
  						error(I18n._("Failed to save data"));					
  					},
  					success : function(info){
  						if(parseInt(info.exito) === 1){
  							$('#descriptionConsulta').val('');
  							if(parseInt(boton) === 1){
  	  			  				$("#idsTransacciones").val("");
  	  			  				$('#newForm').css({display : 'none',});
  	  			  				$("#findTicket").css({display:'none'});
  	  			  				$("#newTicket").css({display:'none'});
  	  			  				$(".inicio").css({display:'block'});
  	  			  				$("#inicio").val(0);
  	  			  				$("#transactionsTicket").css({display:'none'});
  	  			  				$("#transactionsTmp").css({display:'none'});
  	  			  				setLoader('#clientInformationContainer','client-information-message');
  	  			  				$('#clientInformationContainer').html('<span style="color:#ff0000;font-size:18px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
  	  			  				$("#accountTmp").val(account);
  	  			  				unicoTicket = 0;
  	  			  				recuperaCuenta(clientFullInfo,arrayQuestion);
  	  			  			}else{
  	  			  				$(".alert-message").html("Se ha resuelto el ticket");
  	  			  				location.href=baseUrl+"/ticket-client/new";
  	  			  			}  							
  						}
  						return false;
  					}
  				});
  				return false;
  			}else{
  				$("#rdescriptionConsulta").html(I18n._("Required field"));
  			}
  				
  			return false;
		});		
		

		
		$('#newForm').find('.regresaProductos').click(function(){			
			unicoTicket = 0;
			unicoSaldo = unicoTx = 0
			if(parseInt(unicoRegreso) === 0){
				$("#idsTransacciones").val("");
				$('#newForm').css({display : 'none',});
				$("#findTicket").css({display:'none'});
				$("#newTicket").css({display:'none'});
				$(".inicio").css({display:'block'});
				$("#inicio").val(0);
				$("#transactionsTicket").css({display:'none'});
				$("#transactionsTmp").css({display:'none'});
				$("#idTicketType").val('');
				$('#id_reason').val('');
				$('#period').val(0);
				setLoader('#clientInformationContainer','client-information-message');
				$('#clientInformationContainer').html('<span style="color:#ff0000;font-size:18px;">'+I18n._("P r o c e s s i n g . . . . . . .")+'</span>');
				$("#accountTmp").val(account);
				recuperaCuenta(clientFullInfo,arrayQuestion);
				unicoTicket = 0;
			}
			unicoRegreso++;
			return false;
		});
	}
}

/**
 * Metodo para descargar el archivo adjunto del id file
 * @param idFile
 * @returns {Boolean}
 */
function descargaFile(idFile){
	window.open(baseUrl + '/download/download/id/'+idFile,'descarga','fullscreen=0,location=0,menubar=0,resizable=0,scrollbars=0,status=0,titlebar=0,toolbar=0');
	return false;
}

function descargaFileTmp(idFile){
	window.open(baseUrl + '/download/download-tmp/id/'+idFile,'descarga','fullscreen=0,location=0,menubar=0,resizable=0,scrollbars=0,status=0,titlebar=0,toolbar=0');
	return false;	
}

/**
 * Metodo que pinta el color del boton
 */
function regresaClase(aleatorio){
	var clase = "";	
	var id = (aleatorio % 5) + 1;
	switch(parseInt(id)){
		case 1:
			clase = 'btn large success nvoTicket';
			break;
		case 2:
			clase = 'btn large primary nvoTicket';
			break;
		case 3:
			clase = 'btn large info nvoTicket';
			break;
		case 4:
			clase = 'btn large success nvoTicket';
			break;
		case 5:
			clase = 'btn large danger nvoTicket';
			break;			
	}
	return "class = '"+clase+"' ";	
}


function totalPreguntas(indicQuestion){
	var exito = 0;	
	if(indicQuestion >= 5){
		if(parseInt($("#pcorrectas").val()) > parseInt($("#icorrectas").val())){
			exito = 1;
		} else{   
			exito = 2;
		}
	}else{
		if(parseInt($("#pcorrectas").val())>=3){
			exito = 1;
		}
		if(parseInt($("#icorrectas").val())>=3){
			exito = 2;
		}
		
	}
	return exito;
}
function viewQuestion(clientFullInfo){
	var buffer;
	var arrayQuestion;
	var arrayTmp;
	var aleatorio  = 0;
	var ocurrencia = 0;
	var tmpPreguntas = "";
	buffer  = "";
	tmpPreguntas     = $("#npreguntas").val();
	if(String(tmpPreguntas) === ""){		
		aleatorio = Math.floor((Math.random() * 5) + 1);
		$("#npreguntas").val(aleatorio);
	}
	else{		
		do{
			ocurrencia  = 0;
			aleatorio = Math.floor((Math.random() * 5) + 1);
			for(var l = 0; l < tmpPreguntas.length; l++){	
				if(parseInt(aleatorio) === parseInt(tmpPreguntas.charAt(l))){					
					ocurrencia++;
				}				
			}
		}
		while(ocurrencia > 0);
		tmpPreguntas = tmpPreguntas+aleatorio;
		$("#npreguntas").val(tmpPreguntas);
	}
	var styleAmbT=' style="color:#FFFFFF;background:#FF0000;text-align:center;width:40%;border:1px solid #191919;" ';
	var styleAmb=' style="color:#666666;background:#FFFFFF;text-align:center;width:40%;border:1px solid #191919;" ';
	switch(aleatorio){
		case 1:
			buffer ='<table class="bordered-table"><tr><td '+styleAmbT+'>'+I18n._("RFC")+'</td><td '+styleAmb+'>'+clientFullInfo.rfc+'</td></tr></table>';
			break;
		case 2:
			buffer ='<table class="bordered-table"><tr><td '+styleAmbT+'>'+I18n._("BIRTHDATE")+'</td><td '+styleAmb+'>'+clientFullInfo.birthday+'</td></tr></table>';
			break;
		case 3:
			buffer ='<table class="bordered-table"><tr><td '+styleAmbT+'>'+I18n._("HOME PHONE")+'</td><td '+styleAmb+'>'+clientFullInfo.home_phone+'</td></tr></table>';
			break;
		case 4:
			buffer ='<table class="bordered-table"><tr><td '+styleAmbT+'>'+I18n._("MOBILE PHONE")+'</td><td '+styleAmb+'>'+clientFullInfo.mobile_phone+'</td></tr></table>';
			break;
		case 5:
			buffer ='<table class="bordered-table"><tr><td '+styleAmbT+'>'+I18n._("DOMICILE")+'</td><td '+styleAmb+'>'+I18n._("Street")+'</td><td '+styleAmb+'>'+clientFullInfo.street+'</td></tr><tr><td rowspan="6" '+styleAmb+'></td><td '+styleAmb+'>'+I18n._("External number")+'</td><td '+styleAmb+'>'+clientFullInfo.external_number+'</td></tr><tr><td '+styleAmb+'>'+I18n._("Internal number")+'</td><td '+styleAmb+'>'+clientFullInfo.internal_number+'</td></tr><tr><td '+styleAmb+'>'+I18n._("Colony")+'</td><td '+styleAmb+'>'+clientFullInfo.colony+'</td></tr><tr><td '+styleAmb+'>'+I18n._("Town")+'</td><td '+styleAmb+'>'+clientFullInfo.town+'</td></tr><tr><td '+styleAmb+'>'+I18n._("Zip code")+'</td><td '+styleAmb+'>'+clientFullInfo.zip_code+'</td></tr><tr><td '+styleAmb+'>'+I18n._("State")+'</td><td '+styleAmb+'>'+clientFullInfo.state+'</td></tr></table>';
			break;
	}	
	return buffer;

}

function valEmail(txt){
    var b=/^[^@\s]+@[^@\.\s]+(\.[^@\.\s]+)+$/
    return b.test(txt)
}
/**
 * 
 * @param container
 * @param messageType
 */
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
/**
 * 
 * @param container
 * @param messageType
 */
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
/**
 * 
 */
function selectAccount(){
	value = '';
	$(document).find('.accountNumbers').each(function(){
		if($(this).is(':checked'))
			value = $(this).val();
	});
	$('#account_number').val(value);
}

$(function () {
	$(".treeview").treeview({
		collapsed:true,

	});
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

function error1(cadena){
	/*$(".errorDeposit").css({color:"#ff0000"});
	$(".errorDeposit").html(cadena);
	$("#errorControversia").css({color:"#ff0000"});		
	$("#errorControversia").html(cadena);*/
	$.gritter.add({
        title: I18n._('BAM'),
        image: logo,
        text: cadena,
        sticky: false,
        time: 1500,
        position: 'center'
    });
    return false;
	
}
function exito(cadena){
	/*$(".errorDeposit").css({color:"#57a957"});
	$("#errorControversia").css({color:"#57a957"});
	$(".errorDeposit").html(cadena);	
	$("#errorControversia").html(cadena);*/
	$.gritter.add({
        title: I18n._('BAM'),
        image: logo,
        text: cadena,
        sticky: false,
        time: 1500,
        position: 'center'
    });
    return false;

	setTimeout(function(){$('.modal').css({display : 'none'})},3000);
}

function check_chars(cadena, chars)
{
    var s = "";
    var j = 0;
    for (i = 0; i < cadena.length; i++)
    {
        if (chars.indexOf(cadena.charAt(i)) != -1)
        {
          s = s + cadena.charAt(i);
        }
        else j++;
    }
    cadena = s; 
    return cadena;
}

function numberFormat(numero)
{
    var resultado = ""; 
    if(numero[0]=="-") {
        nuevoNumero=numero.replace(/\,/g,'').substring(1);
    }
    else{
        nuevoNumero=numero.replace(/\,/g,'');
    }
    if(numero.indexOf(".")>=0){
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf("."));
    }
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++){
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ",": "") + resultado;
    }
    if(numero.indexOf(".")>=0){
        resultado+=numero.substring(numero.indexOf("."));
    }else{
        resultado+=".00"
    }
    if(numero[0]=="-") {
        return "-"+resultado;
    }
    else{
            return resultado;
    }
}

function numberEntero(numero)
{
    var resultado = ""; 
    if(numero[0]=="-") {
        nuevoNumero=numero.replace(/\,/g,'').substring(1);
    }
    else{
        nuevoNumero=numero.replace(/\,/g,'');
    }
    if(numero.indexOf(".")>=0){
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf("."));
    }
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++){
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ",": "") + resultado;
    }
    if(numero.indexOf(".")>=0){
        resultado+=numero.substring(numero.indexOf("."));
    }else{
        resultado+=""
    }
    if(numero[0]=="-") {
        return "-"+resultado;
    }
    else{
            return resultado;
    }
}
