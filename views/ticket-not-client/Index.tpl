<script type="text/javascript" src="{$baseUrl}/js/modules/ticket-not-client/index.js"></script> 
<style>
    .gray{
    background-color: #e9e9e9;
    font-weight:bold;
    }
    .table-custom th,.tableHead th{
    background-color: #152d5e;
    color: #fff;
    text-align: center;
    }
    .tableHead {
     margin-bottom: 0px;
    }
    
</style>
<form id="not-client" action="" method = "post">
<input type="hidden" id="random" name="random">  
    <table>
        <tbody class="actions">
            <tr >
                <td width="50%">
                    <table style="margin-bottom: 0px;">
                        <tr>
                            <td>{$i18n->_('Name')}</td>
                            <td><input type="text" name="name_client" id="name" value="{$post['name']}" class="span5" /></td>
                        </tr>
                        <tr>
                            <td>{$i18n->_('Ticket Type')}</td>
                            <td>{html_options name=ticketType id=ticketType options=$ticketType selected=$params['ticketType'] class=span5}</td>
                        </tr>
                        <tr>
                            <td>{$i18n->_('Reason')}</td>
                            <td>{html_options name=reason id=reason options=$reasons selected=$params['reason'] class=span5 required}</td>
                        </tr>
                    </table>
                </td>
                <td width="50%">
                    {*<div id="personal" style="display: none;">
                    <table style="margin-bottom: 0px;">
                        
                            <tr>
                                <td>{$i18n->_('Busqueda por')}</td>
                                <td>{html_options name=comboPersonal id=comboPersonal options=$comboPersonal selected=$params['comboPersonal'] class=span7}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"><input type="text" name="searchName" id="searchName" value="{$post['name']}" class="span7" required/></td>
                            </tr>
                    </table>
                    </div>*}
                    <div id="sucursal" class="dynamicCombo" style="display: none;">
                    <table style="margin-bottom: 0px;">
                        
                            <tr>
                                <td>{$i18n->_('Select the branch')}</td>
                                <td>{html_options name=id_branch id=id_branch options=$branches selected=$params['branch'] class=span7}</td>
                            </tr>
                    </table>
                    </div>        
                    <div id="divProducts"  class="dynamicCombo" style="display: none;">
                    <table style="margin-bottom: 0px;">
                         
                            <tr>
                                <td>{$i18n->_('Select a Product')}</td>
                                <td>{html_options name=id_product id=id_product options=$products selected=$params['product'] class=span7}</td>
                            </tr>
                    </table>
                    </div>            
                </td>
            </tr>
            <tr>
                <td width="50%"><input type="hidden" name="subtype" id="subtype"></td>
                <td width="50%"><input type="button" id="searchWs" class="btn primary" value="{$i18n->_('Search')}" />
                <input type="button" id="returnWs" class="btn cancel" value="{$i18n->_('Back')}" />
                </td>
            </tr>
           </tbody>
        </table>
</form>

{*ERROR*}
<div 
	id="messageDiv" 
	style="text-align : center;" 
	error-message="{$i18n->_('An error ocurred during the request, please try it again or try to log in again')}" 
	no-information-message="{$i18n->_('No information found')}" 
	no-account-message="{$i18n->_('No Accounts found')}"
	null-message="{$i18n->_('You must fill at least one field')}"
>
	<h4 id="message"></h4><br>
</div>




{*LOADER*}
<div 
id="loader" 
style="text-align : center; display : none" 
client-information-message="{$i18n->_('Obteniendo Información...')}"
>
	<img src="{$baseUrl}/images/misc/loaders/loading.gif" id="loadimg"><br><span id="message"></span>
	<br><br>
</div>

                <div id="errorContainer" style="text-align : center; display : none"><h4 id="message"></h4></div>
                <div id="clientInformationContainer"></div>
            <div id="PersonalResponseContainer" class="dynamicDiv" style="height:60vh; display:none;" >
                <body style="margin:0px;padding:0px;overflow:hidden">
                    <iframe id="intranetFrame" src="#" frameborder="0" style="overflow:hidden;height:100%;width:100%" height="100%" width="100%"></iframe>
                </body>
                {*<table class="tableHead">
                    <t>
                        <th colspan="5" >Información de empleados</th> 
                    </tr>
                </table>
                <table class="zebra-striped bordered-table">
                    <thead>
                        <tr>
                            <th>Extensión</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Área</th>
                            <th>Dirección</th>
                        </tr>
                    </thead>
                    <tbody class="info">
                        
                    </tbody>
                    
                </table>*}
            </div>
            <div id="BranchResponseContainer" class="dynamicDiv" style="display: none;" >
                <table class="tableHead">
                    <t>
                        <th colspan="5" >{$i18n->_('Branch Information')}</th> 
                    </tr>
                </table>
                <table class="zebra-striped bordered-table">
                    <thead>
                        <tr>
                            <th>{$i18n->_('Branch')}</th>
                            <th>{$i18n->_('Domicile')}</th>
                            <th>{$i18n->_('Schedule')}</th>
                        </tr>
                    </thead>
                    <tbody class="info">
                        
                    </tbody>
                    
                </table>
            </div>
            
            <div id="ProductsResponseContainer" class="dynamicDiv" style="display: none;" >
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th colspan="2">{$i18n->_('Institution info')}</th>
                        </tr>
                    </thead>
                    <tbody class="info">
                        <tr>
                            <td class="gray">{$i18n->_('Name')}</td>
                            <td class="resName"></td>
                        </tr>
                        <tr>
                            <td class="gray">{$i18n->_('Description')}</td>
                            <td class="resDesc"></td>
                        </tr>
                        <tr>
                            <td class="gray">{$i18n->_('Requirements')}</td>
                            <td class="resReq"></td>
                        </tr>
                        <tr>
                            <td class="gray">{$i18n->_('commissions')}</td>
                            <td class="resCom"></td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
<form id="save-not-client" action="" method = "post">  
    <table id="tableTicket" style="display:none;"  class="dynamicDiv">
        <tbody class="actions">
            <tr>
                <td width="20%">{$i18n->_('Description')}</td>
                <td width="50%"><textarea name="description" id="description" class="span10 required"></textarea></td>
                <td width="30%"><input type="button" id="saveTicket" class="btn primary" value="{$i18n->_('Save')}" /></td>
            </tr>
           </tbody>
    </table>
</form>