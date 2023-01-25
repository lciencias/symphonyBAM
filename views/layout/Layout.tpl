<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/> 
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    
    <title>{$systemTitle} | {$contentTitle}</title>
    <meta name="description" content="Symphony Ticket System">
    <meta name="author" content="chente & guadalupe">
    <link rel="shortcut icon" href="{$baseUrl}/images/logos/icon.png" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Styles --> 
    {include file="layout/Css.tpl"}
    
    <!-- Javascript -->
    {include file="layout/Scripts.tpl"}

  </head>

  <body>
    <div id="top_banner">
        <div style="float: lefft; display: inline-block; margin: 10px 0px 0px 20px;"><a href="{url controller=index action=index}"><img alt="" src="{$baseUrl}/images/logos/company_logo.png" /></a></div>
        <div style="float: right; height: 108px;"><a href="{url controller=index action=index}"><img alt="" src="{$baseUrl}/images/logos/symphony.png" /></a></div>
    </div>
     
    {include file='layout/Menu.tpl'}

    <div class="container"> 
         {include file="layout/Messages.tpl"}
         {$contentPlaceHolder}  
    </div>  
    
    

  </body>
</html>
