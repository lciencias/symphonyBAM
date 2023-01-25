<style>
    .gray{
    	background-color: #e9e9e9;font-weight:bold;
    }
    .titulo{
    	text-align: center;
    }
    .bordered-table{
    	width: 100%;
    	}
    .derecha{
	    text-align: right;
    }
	.izquierda{
		text-align: left;
	}
    .bold{
    	font-weight:bold;
    }
    .table th, .table td {
    	border-top: none !important;border-left: none !important;
    }
  	.texto{
  		font-size: 11px;
  	}
    .footer{
    	position: fixed; bottom: 0px;
	}
	.footer2{ 
		position: fixed; bottom: 5px; 
	}
    .pagenum:before{
    	content: "page " counter(page) " of " counter(pages); 
    }   
</style>
<body>
<form method="POST" action="">
    <input type="hidden" name="page" id="page" value="{$page|default:1}" />
    <table class="table">
        <tr>
            <td colspan="1"><img alt="" width="40%" height="40%" src="{$url}/images/logos/company_logo.png" /></td>
            <td colspan="3"><h4>{$i18n->_('CARTA RESOLUTORIA DE ACLARACI&Oacute;N')}</h4></td>
        </tr>
         <tr>
                <td colspan="4" class="titulo derecha"><h4>{$i18n->_('M&eacute;xico, D.F. a ')}{$fecha}</h4></th>
        </tr>
        <tr>
                    <td class="izquierda bold">{$i18n->_('No. Cliente: ')}</td>
                    <td colspan="3" class="texto">{$information.client_number}</td>
        </tr>
        <tr>
                    <td class="izquierda bold">{$i18n->_('No. Cuenta BAM: ')}</td>
                    <td colspan="3" class="texto">{$information.account_number}</td>
        </tr>
        <tr>
                    <td class="izquierda bold">{$i18n->_('No. de Tarjeta:  ')}</td>
                    <td colspan="3" class="texto">{$information.no_card}</td>
        </tr>
         <tr>
                    <td class="izquierda bold">{$i18n->_('Motivo de Reclamaci&oacute;n: ')}</td>
                    <td colspan="3" class="texto">{$information.reason_name}</td>
        </tr>
         <tr>
                    <td class="izquierda bold">{$i18n->_('Folio de la Aclaraci&oacute;n ')}</td>
                    <td colspan="3" class="texto">{$information.folio}</td>
        </tr>
        <tr>
                    <td colspan="4" class="texto"><br><br>{$i18n->_('Estimado (a) Cliente: ')}{$information.name_client}</td>
        </tr>
        
        <tr>
            <td colspan="4" class="texto"><br><br>Nos referimos a la aclaraci&oacute;n que present&oacute; a esta instituci&oacute;n, con fecha  {$fechaAssignacion|date_format:"%d/%m/%Y"}, de acuerdo con el siguiente detalle de su(s) transacci&oacute;n(es) objetada(s) <br><br><br><br></td>
        </tr>
        <tr>
            <td colspan="4" class="texto">
                <table>
                    <tr>
                        <th>{$i18n->_('Fecha  y Hora de Transacci&oacute;n: ')}</th>
                        <th>{$i18n->_('Concepto: ')}</th>
                        <th>{$i18n->_('Importe Edo. Cta. ')}</th>
                        {*<th>{$i18n->_('Tipo de Aclaraci&oacute;n')}</th>*}
                        <th>{$i18n->_('Importe Reclamado')}</th>
                    </tr>
                    {foreach $transaction as $transactionn}
                        <tr>
                            <td class="texto">{$transactionn.transaction_date_v}</td>
                            <td class="texto">{$transactionn.description}</td>
                            <td class="texto">{$transactionn.amount}</td>
                            {if $transactionn.ammount_p !=""}
                                <td class="texto">{$transactionn.ammount_p}</td>
                            {else}
                                <td class="texto">{$transactionn.amount}</td>
                            {/if}
                        </tr>
                    {/foreach}
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4"><br><br>DICTAMEN</td>
        </tr>
        <tr>
            <td colspan="4" class="texto"><br>RESULTADO DEL DICTAMEN<br>
                {$information.dictamen}                
            </td>
        </tr>
        <tr>
            <td colspan="4"  class="texto"><br>DESCRIPCI&Oacute;N DEL DICTAMEN<br>
                 {$information.desc_dictamen}
			</td>
        </tr>
        <tr>
			<td colspan="4" class="titulo bold" ><br><br>Atentamente</td>
        </tr>
        <tr>
            <td colspan="4" class="titulo bold">Banco Autofin M&eacute;xico, S. A.,<br> Instituci&oacute;n de Banca M&uacute;ltiple.</td>
        </tr>
	    </table>
		<table class="footer2 table" width="100%">        
	        <tr>
	            <td colspan="4" style="text-align:center;font-size:10px;">
	                Banco Autofin M&eacute;xico, S.A., Instituci&oacute;n de Banca M&uacute;ltiple<br>
	        		Av. Insurgentes Sur 1235, Extremadura Insurgentes, 03740, M&eacute;xico, D.F. 
	            </td>
	        </tr>        
    </table>
</body>  