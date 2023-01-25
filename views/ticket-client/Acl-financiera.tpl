<style>
    .gray{
    background-color: #e9e9e9;
    font-size: 12px;
    font-weight:bold;
    }
    .texto{
        font-size: 11px;        
    }
    .titulo{
    text-align: center;
    padding: -10px;
    }
    .bordered-table{
    width: 100%;
    margin-top: 10px;
    margin-bottom: 10px;
    padding: -10px;
    }
    .derecha{
    text-align: right;}
    .table th, .table td {
    border-top: none !important;
    border-left: none !important;
}
 /*p { page-break-after: always; }*/
      .footer { position: fixed; bottom: 40px; }
      .footer2{ position: fixed; bottom: 20px; }
      .footer3{ position: fixed; bottom: 10px; }
      .pagenum:before { content: counter(page); }
    
</style>
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table class="table">
        <tr>
            <td colspan='1'><img alt=""width="40%" height="40%" src="{$url}/images/logos/company_logo.png" /></td>
            <td><h2>{$i18n->_('Solicitud de Aclaraci&oacute;n')}</h2></td>
        </tr>
    </table>
        <br>
</form>
{*<div class="footer">P&aacute;gina: <span class="pagenum"></span></div>*}
<table class="bordered-table">
        <thead>
            <tr class="gray">
                <th colspan="4" class="titulo"><h4>{$i18n->_('DATOS DE ACLARACI&Oacute;N')}</h4></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="gray">{$i18n->_('Fecha de Recepci&oacute;n')}</td>
                    <td><span class="texto">{$data.created}</span></td>
                    {if $data.folio > 0}
                    	<td class="gray">{$i18n->_('Folio')}</td>
                    	<td><span class="texto">{$data.folio}</span></td>
                    {else}
                    <td class="gray">{$i18n->_('Pre Folio')}</td>
                    	<td><span class="texto">{$data.folio_prev}</span></td>
                    {/if}
                </tr>
                
                <tr>
                    <td class="gray">{$i18n->_('N&uacute;mero de Sucursal')}</td>
                    <td><span class="texto">{$data.id_bam}</span></td>
                    <td class="gray">{$i18n->_('Nombre de Sucursal')}</td>
                    <td><span class="texto">{$data.branch}</span></td>
                </tr>
                
                <tr>
                    <td class="gray">{$i18n->_('Producto')}</td>
                    <td><span class="texto">{$data.product}</span></td>
                    <td class="gray">{$i18n->_('Canal')}</td>
                    <td><span class="texto">{$data.channel}</span></td>
                </tr>
                <tr>
                    <td class="gray">{$i18n->_('Motivo')}</td>
                    <td colspan="3"><span class="texto">{$data.client_category_name}</span></td>
                </tr>
        </tbody>
    </table>
                <br>
    <table class="bordered-table">
        <thead>
            <tr class="gray">
                <th colspan="4" class="titulo"><h4>{$i18n->_('DATOS DEL CLIENTE')}</h4></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="gray">{$i18n->_('Nombre / Raz&oacute;n Social')}</td>
                    <td><span class="texto">{$data.name}</span></td>
                    <td class="gray">{$i18n->_('Tipo de Cuenta')}</td>
                    <td><span class="texto">{$data.account_type}</span></td>
                </tr>
                
                <tr>
                    <td class="gray">{$i18n->_('N&uacute;mero de Cliente')}</td>
                    <td><span class="texto">{$data.client_number}</span></td>
                    <td class="gray">{$i18n->_('N&uacute;mero de Cuenta')}</td>
                    <td><span class="texto">{$data.account_number}</span></td>
                </tr>
                <tr>
                    <td class="gray">{$i18n->_('No de Tarjeta')}</td>
                    <td><span class="texto">{$data.no_card}</span></td>
                    <td class="gray">{$i18n->_('Tel&eacute;fono de Contacto')}</td>
                    <td><span class="texto">{$data.telefono}</span></td>
                </tr>
                <tr>
                    <td class="gray">{$i18n->_('e-Mail')}</td>
                    <td colspan="3"><span class="texto">{$data.email}</span></td>
                </tr>
        </tbody>
    </table>
                <br>
    {assign var="total" value="0"}
    {if $financiera}                
    <table class="bordered-table">
        <thead>
            <tr class="gray">
                <th colspan="5" class="titulo"><h4>{$i18n->_('DATOS DE TRANSACCI&Oacute;N')}</h4></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td class="gray">{$i18n->_('Fecha ')}</td>
                    <td class="gray">{$i18n->_('Concepto')}</td>
                    <td class="gray">{$i18n->_('Referencia')}</td>
                    <td class="gray">{$i18n->_('Importe')}</td>
                    <th class="gray">{$i18n->_('Importe Reclamado')}</th>
                </tr>
                
                    {* AQUI VA EL FOREACH  *}
                    {foreach $transactions as $transaction}
                    	{if $transaction.ammount_p !=""}
							{$total = $total + $transaction.ammount_p}
						{else}
							{$total = $total + $transaction.amount}
						{/if}
                        <tr>
                            <td><span class="texto">{$transaction.transaction_date_v}</span></td>
                            <td><span class="texto">{$transaction.description}</span></td>
                            <td><span class="texto">{$transaction.idT24}</span></td>
                            <td style="text-align:right;"><span class="texto">{$transaction.amount + 0|number_format:2:".":","}</span></td>                            
                            {if $transaction.ammount_p !=""}
                                <td style="text-align:right;"><span class="texto">{$transaction.ammount_p + 0|number_format:2:".":","}</span></td>
                            {else}
                                <td style="text-align:right;"><span class="texto">{$transaction.amount + 0|number_format:2:".":","}</span></td>
                            {/if}
                        </tr>
                    {/foreach}
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="gray">{$i18n->_('Importe Total Reclamado')}</td>
                    <td></td>
                    <td  style="text-align:right;"><span class="texto">{$total+ 0|number_format:2:".":","}</span></td>
                </tr>
                    
        </tbody>
    </table>
    <br>
    {/if}                
    <table class="bordered-table">
        <thead>
            <tr class="gray">
                <th colspan="4" class="titulo"><h4>{$i18n->_('DOCUMENTACI&Oacute;N ANEXA')}</h4></th>
            </tr>
        </thead>
        <tbody>              
                {assign var=archivos value=$data.attached}
                {assign var=i value=0}
                {assign var=contador value=0}
                {foreach $files as $key=>$file}
                	{if $file != ""}
						{if $contador eq 0}
                    		<tr>
                    	{/if}
                        	<td width="50%"><span class="texto">{$file}</span></td>
                        	{$contador = $contador + 1}
                        {if $contador eq 2}
                        	{$contador = 0}
                    		</tr>
                    	{/if}
                    
                    {/if}                    
                {/foreach}
        </tbody>
    </table>
   	<br>    
    <table class="bordered-table">
        <thead>
            <tr class="gray">
                <th  class="titulo"><h4>{$i18n->_('DESCRIPCI&Oacute;N')}</h4></th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td><span class="texto" style="text-align:justify;">{$data.description_report}</span></td>
                    
                </tr>
        </tbody>
    </table>    
    <br>
    <table class="table" width="100%">
       <tbody>
       	<tr class="gray">
        	<td width="100%" class="texto"  style="text-align:justify;">
				<p class="texto">LA RECEPCI&Oacute;N DE ESTA SOLICITUD NO IMPLICA CONFORMIDAD DE LA INSTITUCI&Oacute;N DE LA RECLAMACI&Oacute;N Y/O DE LA DOCUMENTACI&Oacute;N SOPORTE PRESENTADA.</p>
				<p class="texto">EL BANCO SE RESERVA EL DERECHO DE SOLICITAR AL CLIENTE INFORMACI&Oacute;N Y/O DOCUMENTACI&Oacute;N ADICIONAL.</p>					
				
			</td>
		</tr>
		 {if $financiera}
        <tbody>
         <tr class="gray">
             <td><p  class="titulo">ABONOS DE BUENA FE</p></td>
         </tr>
		<tr class="">
        	<td width="100%" class="texto">
				<p class="texto" style="text-align:justify;">Solo aplica para clientes que reciban su n&oacute;mina en BAM y que hayan realizado su transacci&oacute;n en ATM's de BAM.</p>
				<p class="texto" style="text-align:justify;">Acepto que se me abone el importe reclamado por una disposici&oacute;n en efectivo no dispensado en forma completa o					
					parcial realizado en un Cajero Autom&aacute;tico de BAM a partir de las 12:00 del d&iacute;a h&aacute;bil siguiente a la presentaci&oacute;n del 					
					presente documento, considerando que la sucursal lo entreg&oacute; al &aacute;rea de Aclaraciones antes de las 18:00, del d&iacute;a h&aacute;bil 					
					inmediato anterior, aceptando igualmente que en caso de que al concluir el proceso de dicha alcaraci&oacute;n y si el dictamen					
					no es favorable, BAM proceda a cargar a mi cuenta de cheques el monto que inicialmente me abon&oacute; de buena fe, para					
					lo cual mi expresa aceptaci&oacute;n al referido cargo, aplicando tambi&eacute;n en caso de renuncia o liquidaci&oacute;n, para que se cobre					
					de mi finiquito, firmando el presente documento.</p>
				<p class="texto" style="text-align:justify;">
					Banco Autofin M&eacute;xico S.A. Instituci&oacute;n de Banca M&uacute;ltiple, le comunica que su reclamaci&oacute;n ser&aacute; atendida, de contar con todos 
					los elementos necesarios, en un plazo m&aacute;ximo de 30 d&iacute;as h&aacute;biles, conforme al art&iacute;culo 50 bis fracc. IV de la ley de 
					protecci&oacute;n y defensa al usuario de servicios financieros, contados a partir de la recepci&oacute;n de la presente solicitud en el 
					&aacute;rea de Aclaraciones BAM. Su no implica conformidad de la instituci&oacute;n con la reclamaci&oacute;n y/o los soportes documentos 
					presentados. Bando AutofinM&eacute;xico S.A. Instituci&oacute;n de Banca M&uacute;ltiple, se reserva el derecho de requerir al cliente 
					informac&oacute;n y/o documentaci&oacute;nadicional.
				</p>	
			</td>
		</tr>
		</tbody>
		{else}
		<tr class="">
        	<td width="100%" class="texto">
				<p class="texto" style="text-align:justify;">Banco Autofin M&eacute;xico S.A. Instituci&oacute;n de Banca M&uacute;ltiple, le comunica que su reclamaci&oacute;n ser&aacute; atendida, de contar con 						
					todos los elementos necesarios, en un plazo m&aacute;ximo de 30 d&iacute;as h&aacute;biles, conforme al art&iacute;culo 50 bis fracc. IV de la ley de 						
					protecci&oacute;n y defensa al usuario de servicios financieros, contados a partir de la recepci&oacute;n de la presente solicitud en el 					
					&aacute;rea de Aclaraciones BAM. Su no implica conformidad de la instituci&oacute;n con la reclamaci&oacute;n y/o los soportes documentos presentados. Banco AutofinM&eacute;xico S.A. Instituci&oacute;n de Banca M&uacute;ltiple, se reserva el derecho de requerir al cliente 						
					informaci&oacute;n y/o documentaci&oacute;n adicional.
				</p>
			</td>
		</tr>
		
		{/if}
      </tbody>
     </table>
    <br>
	<table class="footer table" width="100%">
       <tbody>
                <tr>
                    <td width="50%" class="titulo">___________________________________________</td>
                    <td width="50%" class="titulo">___________________________________________</td>
                </tr>
      </tbody>
     </table>
	<table class="footer2 table" width="100%">
		<tbody>     
			<tr>
            	<td width="50%" class="titulo"><span class="texto">{$i18n->_('Nombre y firma del Cliente')}</span></td>
                <td width="50%" class="titulo"><span class="texto">{$i18n->_('Nombre y Firma del Funcionario de la Sucursal')}</span></td>
			</tr>
		</tbody>
     </table>

