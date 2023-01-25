<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    
    <title>Symphony | Symphony</title>
    <meta name="description" content="Symphony Ticket System">
    <meta name="author" content="chente & guadalupe">
    <link rel="shortcut icon" href="/ticket/public/images/logos/icon.png" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Styles --> 
    
 
<link type="text/css" href="/ticket/public/css/custom-theme/jquery-ui-1.8.16.custom.min.css" rel="stylesheet" />
<link href="/ticket/public/bootstrap/bootstrap.min.css" rel="stylesheet" />
<link href="/ticket/public/css/dcmegamenu.css" rel="stylesheet" />

<link href="/ticket/public/css/jquery.treeview.css" rel="stylesheet" />
<link href="/ticket/public/css/timePicker.css" rel="stylesheet" />
<link href="/ticket/public/css/jquery.gritter.css" rel="stylesheet" />
<link href="/ticket/public/css/app.css" rel="stylesheet" />
<link href="/ticket/public/css/colors.css" rel="stylesheet" />

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="/ticket/public/css/custom-theme/jquery.ui.1.8.16.ie.css" />
<![endif]-->  
    
    <!-- Javascript -->
    <script type="text/javascript"> 
    var baseUrl = "/ticket/public";
    var language = "es"; 
    var controller = "document";
    var action = "list";
</script>

<script type="text/javascript" src="/ticket/public/js/i18n.js"></script>
<script type="text/javascript" src="/ticket/public/js/jquery-1.6.4.js"></script>
<script type="text/javascript" src="/ticket/public/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery.dcmegamenu.1.3.3.min.js"></script> 
<script type="text/javascript" src="/ticket/public/bootstrap/js/bootstrap-twipsy.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery.treeview.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/jquery.gritter.min.js"></script>
<script type="text/javascript" src="/ticket/public/js/plugins/localization/messages_es.js"></script>
<script type="text/javascript" src="/ticket/public/js/app.js"></script>
<script type="text/javascript" src="/ticket/public/js/cloner.js"></script>
<script type="text/javascript" src="/ticket/public/js/scripts.js"></script>
<script type="text/javascript" src="/ticket/public/js/rules.js"></script>



  </head>

  <body>
    <div id="top_banner">
        <div style="float: lefft; display: inline-block; margin: 10px 0px 0px 20px;"><a href="/ticket/public/index/index"><img alt="" src="/ticket/public/images/logos/company_logo.png" /></a></div>
        <div style="float: right; height: 108px;"><a href="/ticket/public/index/index"><img alt="" src="/ticket/public/images/logos/symphony.png" /></a></div>
    </div>
     
    <div id="dtopbar"> 
   <div style="text-align: right;">
      <a href="/ticket/public/auth/change-language/lang/es"><img src='/ticket/public/images/template/icons/es.png' class='tip' data-original-title='Español'  /></a>
      <a href="/ticket/public/auth/change-language/lang/en"><img src='/ticket/public/images/template/icons/en.png' class='tip' data-original-title='Ingles'  /></a>
      <small>Bienvenido <strong>admin</strong> (Administrador) | <a href="/ticket/public/auth/logout" style="color: #FFF;">Salir</a> | <a href="/ticket/public/user/edit-password/id/1" style="color: #FFF;">Editar Contrase&ntilde;a</a></small>
      &nbsp;&nbsp;
  </div>
</div>

<div><ul class="mega-menu" id="mega-menu-1"><li class=""><a class="">Cat&aacute;logos<b class="caret"></b></a><ul><li><a href="/ticket/public/employee/list">Empleados</a><ul><li class="center"><a href="/ticket/public/employee/list"><img src="/ticket/public/images/template/menu-icons/estatusporempleado.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/position/index">Puestos</a><ul><li class="center"><a href="/ticket/public/position/index"><img src="/ticket/public/images/template/menu-icons/perfiles.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/location/index">Ubicaciones</a><ul><li class="center"><a href="/ticket/public/location/index"><img src="/ticket/public/images/template/menu-icons/companies.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/area/index">&Aacute;reas</a><ul><li class="center"><a href="/ticket/public/area/index"><img src="/ticket/public/images/template/menu-icons/grupos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/company/index">Empresas</a><ul><li class="center"><a href="/ticket/public/company/index"><img src="/ticket/public/images/template/menu-icons/companies.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/client-resolution/index">Resoluciones para Tickets de Cliente</a><ul><li class="center"><a href="/ticket/public/client-resolution/index"><img src="/ticket/public/images/template/menu-icons/estatus.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/branch/list">Sucursales</a><ul><li class="center"><a href="/ticket/public/branch/list"><img src="/ticket/public/images/template/menu-icons/companies.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/channel/list">Canales</a><ul><li class="center"><a href="/ticket/public/channel/list"><img src="/ticket/public/images/template/menu-icons/mediodecontacto.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket-type/list">Tipos de Tickets</a><ul><li class="center"><a href="/ticket/public/ticket-type/list"><img src="/ticket/public/images/template/menu-icons/catalogos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/workweek/index">Horarios</a><ul><li class="center"><a href="/ticket/public/workweek/index"><img src="/ticket/public/images/template/menu-icons/horarios.png" style="height: 83px;"></a></li></ul></li></ul></li><li class=""><a class="">Configuraci&oacute;n<b class="caret"></b></a><ul><li><a href="/ticket/public/escalation/list">Escalamientos</a><ul><li class="center"><a href="/ticket/public/escalation/list"><img src="/ticket/public/images/template/menu-icons/escalamiento.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/group/list">Grupos</a><ul><li class="center"><a href="/ticket/public/group/list"><img src="/ticket/public/images/template/menu-icons/grupos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/service-level/list">Niveles de Servicio</a><ul><li class="center"><a href="/ticket/public/service-level/list"><img src="/ticket/public/images/template/menu-icons/nivelesdeservicio.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/option/list">Par&aacute;metros</a><ul><li class="center"><a href="/ticket/public/option/list"><img src="/ticket/public/images/template/menu-icons/configuracion.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/client-category/list">Categor&iacute;as (Clientes)</a><ul><li class="center"><a href="/ticket/public/client-category/list"><img src="/ticket/public/images/template/menu-icons/tipificacion.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/field/list">Datos Requeridos</a><ul><li class="center"><a href="/ticket/public/field/list"><img src="/ticket/public/images/template/menu-icons/configuracion.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/document/list">Documentos Requeridos</a><ul><li class="center"><a href="/ticket/public/document/list"><img src="/ticket/public/images/template/menu-icons/configuracion.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/calendar/index">Holydays</a><ul><li class="center"><a href="/ticket/public/calendar/index"><img src="/ticket/public/images/template/menu-icons/diashabiles.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/template-email/index">Dise&ntilde;o de Correos</a><ul><li class="center"><a href="/ticket/public/template-email/index"><img src="/ticket/public/images/template/menu-icons/correos.png" style="height: 83px;"></a></li></ul></li></ul></li><li class=""><a class="">Seguridad<b class="caret"></b></a><ul><li><a href="/ticket/public/user/list">Usuarios</a><ul><li class="center"><a href="/ticket/public/user/list"><img src="/ticket/public/images/template/menu-icons/usuarios.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/session/list">Sesiones</a><ul><li class="center"><a href="/ticket/public/session/list"><img src="/ticket/public/images/template/menu-icons/sesionesactivas.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/access-role/index">Perfil</a><ul><li class="center"><a href="/ticket/public/access-role/index"><img src="/ticket/public/images/template/menu-icons/perfiles.png" style="height: 83px;"></a></li></ul></li></ul></li><li class=""><a class="">Tickets<b class="caret"></b></a><ul><li><a href="/ticket/public/ticket/list">Buscar</a><ul><li class="center"><a href="/ticket/public/ticket/list"><img src="/ticket/public/images/template/menu-icons/casos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket/mine">Mis Tickets</a><ul><li class="center"><a href="/ticket/public/ticket/mine"><img src="/ticket/public/images/template/menu-icons/seguimiento.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket/tickets-assigned">Tickets Asignados</a><ul><li class="center"><a href="/ticket/public/ticket/tickets-assigned"><img src="/ticket/public/images/template/menu-icons/inventario.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket/my-ticket">Nuevo Ticket</a><ul><li class="center"><a href="/ticket/public/ticket/my-ticket"><img src="/ticket/public/images/template/menu-icons/catalogos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket/employees">Nuevo Tickets</a><ul><li class="center"><a href="/ticket/public/ticket/employees"><img src="/ticket/public/images/template/menu-icons/catalogos.png" style="height: 83px;"></a></li></ul></li></ul></li><li class=""><a class="">Ticket de Cliente<b class="caret"></b></a><ul><li><a href="/ticket/public/ticket-client/new">Nuevo Ticket de Cliente</a><ul><li class="center"><a href="/ticket/public/ticket-client/new"><img src="/ticket/public/images/template/menu-icons/catalogos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket-client/list">Lista de Tickets de Cliente</a><ul><li class="center"><a href="/ticket/public/ticket-client/list"><img src="/ticket/public/images/template/menu-icons/casos.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket-client/my-tickets">Tickets de Cliente Asignados</a><ul><li class="center"><a href="/ticket/public/ticket-client/my-tickets"><img src="/ticket/public/images/template/menu-icons/seguimiento.png" style="height: 83px;"></a></li></ul></li><li><a href="/ticket/public/ticket-client/list-by-group">Tickets por Grupo</a><ul><li class="center"><a href="/ticket/public/ticket-client/list-by-group"><img src="/ticket/public/images/template/menu-icons/casos.png" style="height: 83px;"></a></li></ul></li></ul></li><li class=""><a class="">Reportes<b class="caret"></b></a><ul><li><a href="/ticket/public/ticket-client/report">R27 Report</a><ul><li class="center"><a href="/ticket/public/ticket-client/report"><img src="/ticket/public/images/template/menu-icons/monitoreo.png" style="height: 83px;"></a></li></ul></li></ul></li></ul>
</div>



    <div class="container"> 
      
<?
echo date("Y/m/d");

?>
<script type="text/javascript">

$('#paginator a').live('click', function(){
    if( $('#page').length != 0  ){
        $('#page').val($(this).attr('rel'));
        $('#page').parents('form').submit();
        return false;
    }
});

$('input[type=submit]').click(function(){
    $(this).parents('form').find('#page').val(1);
});

</script>

  
    </div>  
    
    

  </body>
</html>
