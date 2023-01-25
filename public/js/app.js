function modal(button, title, message){
    $( "#dialog-confirm" ).attr('title', title);
    $( "#dialog-confirm" ).find('span.message').html(message);     
    $( "#dialog-confirm" ).dialog({
        resizable: false,
        modal: true,
        buttons: [{
        	text : I18n._("OK"),
            click: function() {
                $( this ).dialog( "close" );
                window.location = $(button).attr('href');
            }
        },{
        	text: I18n._("Cancel"),
        	click: function() {
                $( this ).dialog( "close" );
            }	
        }]
    });
}


$(function () {
	$(".masfiltros").hide();
	$('#mega-menu-1').dcMegaMenu({
        rowItems : '7',
        speed: 'fast',
        effect: 'slide',
        event : 'click',
        fullWidth : true
    });
  
    // Tips
    $('.tip').twipsy();

    // Buttons
    $('button').button();

    // Anchors, Submit
    $('.button').button();
    
    // datepickers
    $( ".datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
    });
    
    // date and time
    $('.datetimepicker').datetimepicker({
        dateFormat: "yy-mm-dd",
        timeFormat: 'hh:mm'
    });
    
    $.datepicker.regional['es'] = {
  		  closeText: 'Aceptar', 
  		  prevText: 'Previo', 
  		  nextText: 'Pr�ximo',	  
  		  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  		  monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  		  monthStatus: 'Ver otro mes', 
  		  yearStatus: 'Ver otro a�o',
  		  dayNames: ['Domingo','Lunes','Martes','Mi�rcoles','Jueves','Viernes','S�bado'],
  		  dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','S�b'],
  		  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
  		  oneLine: true,
  		  dateFormat: "yy-mm-dd",
  		  timeFormat: 'HH:mm',		  
  		  timeText: 'Hora',
  		  initStatus: 'Selecciona la fecha', isRTL: false
  	};

  	$.datepicker.setDefaults($.datepicker.regional['es']);  
  	$.timepicker.setDefaults($.datepicker.regional['es']);
    // form validation
    $('form.validate').validate();
    
    // back
    $('.cancel, #cancel').click(function(){
    	location.href = baseUrl;
    	//window.location.href = document.referrer;
    });
    
    // confirm modal
    $('.deactivate, .confirm').click(function(){
        var title = $(this).attr('data-confirm-title') || I18n._("Deactivate");
        var message = $(this).attr('data-confirm-message') || I18n._("This item will be deactivated. Are you sure?");
        modal(this, title, message);
        return false;
    });
    
    // tabs
    $('.tabs, #tabs').tabs({ 
        cache: true,
        cookie: { expires: 30 }
    });
    
    $("#control").click(function(){
    	if($("#controlVal").val() == 0){
    		$("#imgControl").attr("src",baseUrl+"/images/template/plugins/tablesorter/up.jpg");
    		$("#controlVal").val(1);
    		$(".masfiltros").show();
    	}else{
    		$("#imgControl").attr("src",baseUrl+"/images/template/plugins/tablesorter/down.jpg");
    		$("#controlVal").val(0);
    		$(".masfiltros").hide();
    	} 
    	return false;
    });
});