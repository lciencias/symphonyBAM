<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

use Application\Controller\BaseController;
use Application\Excel\ReportExcel;
use Application\Manager\FixManager;
use Application\Model\Catalog\ReasonsCatalog;



/**
 *
 * 
 */
class RegulatoryReportController extends BaseController{
    
     /**
     * @module Reports
     * @action Activity
     */
    public function indexAction()
    {
        
        $fixManager= new FixManager();
        $ini=$fixManager->getArrayTrimester();
        $this->view->combo=  array_reverse($ini);
        $this->view->errors=false;
        if( $this->getRequest()->isPost() )
        {
            $this->view->errors=false;
            $this->view->contentTitle = $this->i18n->_("Activity Report");
            $params = $this->getRequest()->getParams();
            $ini=explode("-",$params['ini']);
            
            $nuevafecha = strtotime ( '+ 3 month' , strtotime ( $params['ini'] ) ) ;
            $fin = date ( 'Y-m-d' , $nuevafecha );
            
            $trimester=$fixManager->getNameNumber($fixManager->getQuarterByMonth($ini[1]))." Trimestre ".$ini[0];
            
			$array_unicos  = array();            
            $sql=" SELECT tc.id_ticket_client,tc.folio,            		
            		convert(varchar,bt.registry, 103) as reclamation_date,
            		convert(varchar,tct.transaction_date, 103) as event_date,
            		case when p.especial=1 then tc.no_card else tc.account_number end as account_number,
            		p.name as product,
            		tc.no_card,tc.chanel as channel,r.name as reason,r.product as productCat,r.motive as motiveCat,
            		r.chanel as chanelCat,tct.amount as claimed, 
					CASE WHEN bt.status IN(4,5,7,8) THEN '402' else '401' END AS estado,res.name as resolution,
            		CASE WHEN res.type = '1' then '501' WHEN res.type != '1' then '502' else '503' end as typ,res.code,res.type as tipo,
            		convert(varchar,ass.resolution_date, 103) as resolution_date,res.code as resolution_cause,
					case when tct.good_faith_amount  != null then tct.good_faith_amount  else tct.amount end as importe,
            		case when tct.good_faith_date != null then convert(varchar,tct.good_faith_date, 103) else convert(varchar,ass.resolution_date, 103) end  as ammount_date,
            		ass.is_recovered_amount,
					case when ass.is_recovered_amount='1' then tct.amount else '' end as recovery_amount,
					case when ass.is_recovered_amount='0' then tct.amount else '' end as  quebranto,
					c.canal_acl as origen,bt.status,res.type,ass.id_resolution,
					tctn.num,tct.id_ticket_client_transaction as id_transaction,tc.folio_condusef
					FROM pcs_symphony_tickets_clients tc
						INNER JOIN pcs_symphony_base_tickets bt ON tc.id_base_ticket=bt.id_base_ticket
						INNER JOIN pcs_symphony_tickets_clients_transactions tct ON tc.id_ticket_client=tct.id_ticket_client
						LEFT JOIN ( SELECT COUNT(id_ticket_client_transaction) as num,id_ticket_client FROM pcs_symphony_tickets_clients_transactions GROUP BY id_ticket_client ) as tctn ON tc.id_ticket_client=tctn.id_ticket_client
						LEFT JOIN pcs_symphony_products p ON tc.id_product=p.id_product
						LEFT JOIN pcs_symphony_channels c ON bt.id_channel=c.id_channel
						LEFT JOIN pcs_symphony_client_categories r on tc.id_client_category=r.id_client_category
						LEFT JOIN pcs_symphony_assignments ass on ass.id_base_ticket=bt.id_base_ticket
						LEFT JOIN pcs_symphony_client_resolutions res on res.id_client_resolution=ass.id_resolution
					WHERE tc.expiration_date is not null AND bt.id_ticket_type=4  AND bt.status IN (3,4,5) 
           	      		AND 
            			(
            			  (bt.registry >='".$params['ini']."'  and bt.registry < '$fin' )
            				OR             			  
            			  (ass.resolution_date >='".$params['ini']."'  and ass.resolution_date < '$fin')
            			 )
            		ORDER BY tc.id_ticket_client,bt.registry,ass.resolution_date,tct.transaction_date";
           
            $data=$this->getReasonsCatalog()->getDb()->fetchAll($sql);
            if(count($data)>0)
            {               
                $this->view->setTpl("Index")->setLayoutFile(false);            
                $excel = new ReportExcel();
                $excel->setActiveSheetIndex(0);
                
                $headers=array('Reporte','Número secuencia','Folio','Fecha de Aclaración','Fecha Suceso','Número de Cuenta','Producto Catalogo CNBV',
                		'Canal Catalogo CNBV','Motivo Catalogo CNBV',
                		'Importe Reclamado','Estado','Resolución','Fecha Resolución','Causa Resolución','Importe Abonado',
                		'Fecha Abonado','Importe Recuperado','Quebranto','Origen');
                $headers= $fixManager->utf8_encode_array($headers);
                
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1 ,utf8_encode("Nombre de la institución: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1 ,utf8_encode("Banco Autofin México S.A Institución de Banca Multiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1 ,utf8_encode("Sector: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1 ,utf8_encode("Instituciones de Banca Múltiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 2 ,utf8_encode("Trimestre a Informar"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 2 ,$trimester);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 2 ,utf8_encode("Número de Aclaraciones"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 2 ,count($data));
                $excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A3:X3')->getFont()->setBold(true);
                $cols = array ('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                $c=0;
                foreach($headers as $column){
                	$col = $cols[$c];
                	$excel->getActiveSheet()->getColumnDimension($col)->setWidth(25);
                 	$excel->getActiveSheet()->setCellValueByColumnAndRow($c, 3 ,$column);                 
                 	$c++;
                }                
                $contador=1;
                $i = 4;
                foreach($data as $row){
                	//echo"<pre>";print_r($row);die();
                	if(substr(trim($row['folio']),0,1) != 'P'){                             		
	                	$semilla =  trim($row['id_ticket_client']).'-'.trim($row['id_transaction']);
	                	$folio=(!$row['folio'] || trim($row['folio'])=="")?$row['folio_prev']:$row['folio'];
	                	
	                    if($row['num']>1){
		                	$arrayFolios[$folio][] = $row['id_transaction'];
		                    $num   = count($arrayFolios[$folio]);
		                    $folio = $folio."-".$num;
						}
	                	$data = $this->getPartities($row['id_transaction']);
	               		$row['amount']    = $data['amount'];
	                	$row['partities'] = $data['partities'];
	
	                	if(in_array($semilla,$array_unicos)){
	                		$row['reclamation_date'] = $row['resolution_date'];
	                		if(trim($row['folio_condusef']) != ''){
	                			$folio = $row['folio_condusef'];
	                		}
	                	}
	                	$excel->getActiveSheet()->setCellValueByColumnAndRow(0, $i ,'2701');
	                    $excel->getActiveSheet()->setCellValueExplicit("B$i" ,$contador,PHPExcel_Cell_DataType::TYPE_NUMERIC);
	                    /*if(trim($row['folio_condusef']) != ''){
	                    	$excel->getActiveSheet()->setCellValueExplicit("C$i",utf8_encode($row['folio_condusef']),PHPExcel_Cell_DataType::TYPE_STRING);
	                    }else{*/
	                    	$excel->getActiveSheet()->setCellValueExplicit("C$i",utf8_encode($folio),PHPExcel_Cell_DataType::TYPE_STRING);
	                    //}
	                    $excel->getActiveSheet()->setCellValueExplicit("D$i",utf8_encode($row['reclamation_date']),PHPExcel_Cell_DataType::TYPE_STRING);
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i ,utf8_encode($row['event_date']));
	                    $excel->getActiveSheet()->setCellValueExplicit("F$i" ,utf8_encode($row['account_number']),PHPExcel_Cell_DataType::TYPE_STRING);
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i ,utf8_encode($row['productCat']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i ,utf8_encode($row['chanelCat']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(8, $i ,utf8_encode($row['motiveCat']));
	                    if(trim($row['partities'])!= ''){
	                    	$row['partities'] = (double) ($row['partities']) *(-1);
	                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,number_format($row['partities'],2,'.',','));
	                    }else{
	                    	if((double) $row['amount'] < 0){
	                    		$row['amount'] = (double) $row['amount'] * (-1);
	                    	}
	                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,number_format($row['amount'],2,'.',','));
	                    }
	                    if($row['id_resolution'] != null && $row['id_resolution'] != ''){
	                    	$row['estado'] = 402;
	                    	$row['typ']= 501;
	                    }
	                    else{
	                    	if(in_array($semilla,$array_unicos)){
	                    		$row['estado'] = 403;
								$row['typ']= 503;
	                    		$row['resolution_date']="";
	                    	}
	                    	else{
	                    		$row['estado'] = 401;
	                    		$row['typ']= 503;
	                    		$row['resolution_date']="";
	                    	}
	                    }
	                    if(!in_array($semilla,$array_unicos)){
		                    $array_unicos[] = $semilla;
	                    }
						$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,utf8_encode($row['estado']));
		                $excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,utf8_encode($row['typ']));
		                if($row['id_resolution'] != null && $row['id_resolution'] != ''){
		                $excel->getActiveSheet()->setCellValueByColumnAndRow(12, $i ,utf8_encode($row['resolution_date']));
		                }else{
		                	$excel->getActiveSheet()->setCellValueByColumnAndRow(12, $i ,'');
		                }
		                if(trim($row['resolution_cause']) != '')
		                	$excel->getActiveSheet()->setCellValueByColumnAndRow(13, $i ,utf8_encode($row['resolution_cause']));
		                else
		                	$excel->getActiveSheet()->setCellValueByColumnAndRow(13, $i ,utf8_encode('654'));
		                    
		                if(trim(utf8_encode($row['tipo'])) == '1'){                    	                    	
		                	if((double) $row['importe'] < 0){
		                    	$row['importe'] = (double) $row['importe'] * (-1);
		                    }                    	
		                    //die("importe:  ".$row['importe']);
		                    $excel->getActiveSheet()->setCellValueByColumnAndRow(14, $i ,number_format($row['importe'],2,'.',','));
		                    $excel->getActiveSheet()->setCellValueByColumnAndRow(15, $i ,utf8_encode($row['ammount_date']));
		                }else{
		                	$excel->getActiveSheet()->setCellValueByColumnAndRow(14, $i ,'');
		                    $excel->getActiveSheet()->setCellValueByColumnAndRow(15, $i ,'');
		                }
						if($row['is_recovered_amount'] == 1){                    	
		                	if(trim($row['partities'])!= ''){
		                    	if((double) $row['partities'] <0){
		                    		$row['partities'] = (double) $row['partities'] * (-1);
		                    	}                    		
		                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(16, $i ,number_format($row['partities'],2,'.',','));
		                    }else{
		                    	if((double) $row['recovery_amount'] <0){
		                    		$row['recovery_amount'] = (double) $row['recovery_amount'] * (-1);
		                    	}                    		
		                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(16, $i ,number_format($row['recovery_amount'],2,'.',','));
		                    }
		                    $excel->getActiveSheet()->setCellValueByColumnAndRow(17, $i ,'');
		               }else{
		               		$excel->getActiveSheet()->setCellValueByColumnAndRow(16, $i ,'');
		                    if(trim($row['partities'])!= ''){
		                    	if((double) $row['partities'] <0){
		                    		$row['partities'] = (double) $row['partities'] * (-1);
		                    	}
		                    	if((trim(utf8_encode($row['tipo'])) == '1') ){
			                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(17, $i ,number_format($row['partities'],2,'.',','));
		                    	}else{
		                    		$excel->getActiveSheet()->setCellValueByColumnAndRow(17, $i ,"");
		                    	}
		                    }else{
		                   		if((double) $row['quebranto'] <0){
		                   			$row['quebranto'] = (double) $row['quebranto'] * (-1);
		                   		}
		                   		if ( (trim(utf8_encode($row['tipo'])) == '1')){
		                   			$excel->getActiveSheet()->setCellValueByColumnAndRow(17, $i ,number_format($row['quebranto'],2,'.',','));
		                   		}
		                   		else{
		                   			$excel->getActiveSheet()->setCellValueByColumnAndRow(17, $i ,"");
		                   		}
		                   	}
		                }
		                $excel->getActiveSheet()->setCellValueByColumnAndRow(18, $i ,utf8_encode($row['origen']));
						$i++;
		                $contador++;
                	}
                }
	            $excel->toBrowser2("Reporte_Regulatorio_R27_Aclaraciones");
	        }
			else{
	        	$this->view->seleccion=$params['ini'];
	            $this->view->errors=" No existen resultados con el filtro ingresado";
	       }
        }
    }
    
    
    public function getPartities($idTransaction){
    	$data = array();
    	$sql = "select a.amount as amount, b.amount as partities
				FROM pcs_symphony_tickets_clients_transactions as a
				LEFT JOIN pcs_symphony_tickets_clients_transactions_partialities b
				ON a.id_ticket_client_transaction = b.id_ticket_client_transaction
				WHERE a.id_ticket_client_transaction = '".$idTransaction."';";
    	$res = $this->getReasonsCatalog()->getDb()->fetchAll($sql);
    	if(count($res) > 0){
    		foreach($res as $tmp){    		
    			$data['amount']    = $tmp['amount'];
    			$data['partities'] = $tmp['partities'];
    		}
    	}
    	return $data;
    }
    public function getPartitiesRRR($idTicketClient){
    	$data = array();
    	$sql = "select a.id_ticket_client_transaction, a.amount as amount, b.amount as partities 
				FROM pcs_symphony_tickets_clients_transactions as a
				LEFT JOIN pcs_symphony_tickets_clients_transactions_partialities b 
				ON a.id_ticket_client_transaction = b.id_ticket_client_transaction
				WHERE a.id_ticket_client = '".$idTicketClient."' ORDER BY  a.id_ticket_client,a.id_ticket_client_transaction;";
    	$res = $this->getReasonsCatalog()->getDb()->fetchAll($sql);
    	if(count($res) > 0){
    		foreach($res as $tmp){
    			$id = $tmp['id_ticket_client_transaction'];
    			$data[$id]['amount'] 	= $tmp['amount'];
    			$data[$id]['partities'] = $tmp['partities'];
    		}
    	}
    	return $data;   		 
    }
    
    /**
     * Metodo para consultas
     */
    public function reuneAction()
    {
        $fixManager= new FixManager();
        $ini=$fixManager->getArrayTrimester();
        $this->view->combo=  array_reverse($ini);
        $this->view->errors=false;
        if( $this->getRequest()->isPost() )
        {
            $params = $this->getRequest()->getParams();
            $ini=explode("-",$params['ini']);
            $trimester=$fixManager->getNameNumber($fixManager->getQuarterByMonth($ini[1]))." Trimestre ".$ini[0];
            $nuevafecha = strtotime ( '+ 3 month' , strtotime ( $params['ini'] ) ) ;
            $fin = date ( 'Y-m-d' , $nuevafecha );
            $sql=" SELECT tc.folio, CASE WHEN bt.status IN(1,2,3,5,6,7,8) THEN 'CONCLUIDO' else 'PENDIENTE' END AS estado_ticket,
            		convert(varchar,ass.resolution_date, 103)  as resolution_date,
					convert(varchar,ass.resolution_date, 103) as fecha_notificacion,
            		tc.id_entidad AS entidad,convert(varchar,bt.created, 103) as fecha_recepcion,c.canal_recl as medio,
            		p.name as producto,r.name as causa
			FROM pcs_symphony_tickets_clients tc
			INNER JOIN pcs_symphony_base_tickets bt ON tc.id_base_ticket=bt.id_base_ticket
			LEFT JOIN ( SELECT COUNT(id_ticket_client_transaction) as num,id_ticket_client FROM pcs_symphony_tickets_clients_transactions GROUP BY id_ticket_client ) as tctn ON tc.id_ticket_client=tctn.id_ticket_client
			LEFT JOIN pcs_symphony_products p ON tc.id_product=p.id_product
			LEFT JOIN pcs_symphony_channels c ON bt.id_channel=c.id_channel
			LEFT JOIN pcs_symphony_client_categories r on tc.id_client_category=r.id_client_category
			LEFT JOIN pcs_symphony_assignments ass on ass.id_base_ticket=bt.id_base_ticket
			LEFT JOIN pcs_symphony_client_resolutions res on res.id_client_resolution=ass.id_resolution
			WHERE bt.id_ticket_type=3  and bt.registry >='".$params['ini']."'  and bt.registry < '$fin' AND bt.status IN (3,5) ";
            $data=$this->getReasonsCatalog()->getDb()->fetchAll($sql);
            if(count($data)>0)
            {
                $this->view->setTpl("Index")->setLayoutFile(false);            
                $excel = new ReportExcel();
                $excel->setActiveSheetIndex(0);

                $headers=array('Folio','Estado:','Fecha de notificación al usuario','Entidad federativa',
                        'Fecha de recepción','Medios de recepción','Producto y servicio','Causa');
                $headers= $fixManager->utf8_encode_array($headers);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1 ,utf8_encode("Nombre de la institución: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1 ,utf8_encode("Banco Autofin México S.A Institución de Banca Multiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1 ,utf8_encode("Sector: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1 ,utf8_encode("Instituciones de Banca Múltiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 2 ,utf8_encode("Trimestre a Informar"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 2 ,$trimester);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 2 ,utf8_encode("Número de Consultas"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 2 ,count($data));
                $excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A3:Q3')->getFont()->setBold(true);                
                $c=0;
                foreach($headers as $column){
					$excel->getActiveSheet()->setCellValueByColumnAndRow($c, 3 ,$column);
					$c++;
                }
                $i = 4;
                $arrayFolios=array();
                foreach($data as $row){
                	if(trim($row['folio']) != ''){
	                	$folio=$row['folio'];
	                    if($row['num']>1){
	                    	$arrayFolios[$folio][]=$row['id_transaction'];
	                        $num=count($arrayFolios[$folio]);
	                        $folio=$folio."-".$num;
						}
	                    if($row['id_resolution'] != null && $row['id_resolution'] != ''){
	                    	$row['estado_ticket'] = 1;
	                    }
	                    else{
	                    	$row['estado_ticket'] = 2;
	                    }
	                    $excel->getActiveSheet()->setCellValueExplicit("A$i",utf8_encode($folio),PHPExcel_Cell_DataType::TYPE_STRING);
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i ,utf8_encode($row['estado_ticket']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(2, $i ,utf8_encode($row['fecha_recepcion']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i ,utf8_encode($row['entidad']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i ,utf8_encode($row['fecha_recepcion']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i ,utf8_encode($row['medio']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i ,utf8_encode($row['producto']));
	                    $excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i ,utf8_encode($row['causa']));
	                    $i++;
					}
            	}
                $excel->toBrowser2("Reporte_Regulatorio_REUNE_Consultas");
            }
            else{
           		$this->view->seleccion=$params['ini'];
                $this->view->errors=" No existen resultados con el filtro ingresado";
           }
        }
    }
    
    /**
     * Metodo
     */
    public function reuneAclAction()
    {
        $fixManager= new FixManager();
        $ini=$fixManager->getArrayTrimester();
        $this->view->combo=  array_reverse($ini);
        $this->view->errors=false;
        if( $this->getRequest()->isPost() )
        {
            $params = $this->getRequest()->getParams();
            $ini=explode("-",$params['ini']);
            $trimester=$fixManager->getNameNumber($fixManager->getQuarterByMonth($ini[1]))." Trimestre ".$ini[0];
            $nuevafecha = strtotime ( '+ 3 month' , strtotime ( $params['ini'] ) ) ;
            $fin = date ( 'Y-m-d' , $nuevafecha );
            $sql="SELECT tc.id_ticket_client,tc.folio,tc.folio_prev,CASE WHEN bt.status IN(4,5,7,8) THEN 'CONCLUIDO' else 'PENDIENTE' END AS estado_ticket, 
					convert(varchar,ASS.resolution_date, 103) as fecha_resolucion, convert(varchar,ASS.resolution_date, 103) as fecha_notificacion, tc.id_entidad AS entidad,convert(varchar,bt.registry, 103) as fecha_recepcion,
					c.canal_recl as medio, convert(varchar,bt.registry, 103) as reclamation_date,tct.transaction_date as event_date,tc.account_number,p.name as producto,
			 		r.name as causa,tct.amount as claimed, CASE WHEN bt.status IN(5,7,8) THEN 'CONCLUIDO' else 'PENDIENTE' END AS estado,
			  		res.name as resolution,bt.scheduled_date as resolution_date,ass.note as resolution_cause,
					case when tct.good_faith_amount  != null then tct.good_faith_amount  else tct.amount end as importe,
            		case when tct.good_faith_date != null then convert(varchar,tct.good_faith_date, 103) else convert(varchar,ass.resolution_date, 103) end  as ammount_date,            		
			 		--case when(tct.good_faith_amount ='' OR tct.good_faith_amount IS NULL ) then tct.amount else tct.good_faith_amount end as importe_usuario,
			 		--case when (tct.good_faith_amount ='' OR tct.good_faith_amount IS NULL ) then convert(varchar,ass.resolution_date, 103) else convert(varchar,tct.good_faith_date, 103) end as fecha_importe,
			 		'' as folio_ins,
			 		'0' as reversa,bt.status,res.type,
            		ass.id_resolution, 
            		tct.amount as monto,
            		convert(varchar,ass.resolution_date, 103) as resolutionDate,
            		convert(varchar,tct.good_faith_date, 103) as good_faith_date,good_faith_amount,
			  		case when ass.is_recovered_amount='1' then tct.amount else '' end as recovery_amount,
		      		case when ass.is_recovered_amount='0' then tct.amount else '' end as quebranto, c.name as origen, 
			  		tctn.num,tct.id_ticket_client_transaction as id_transaction
			  FROM pcs_symphony_tickets_clients tc 
			  INNER JOIN pcs_symphony_base_tickets bt ON tc.id_base_ticket=bt.id_base_ticket 
			  LEFT JOIN pcs_symphony_tickets_clients_transactions tct ON tc.id_ticket_client=tct.id_ticket_client 
			  LEFT JOIN ( SELECT COUNT(id_ticket_client_transaction) as num,id_ticket_client FROM pcs_symphony_tickets_clients_transactions GROUP BY id_ticket_client ) as tctn ON tc.id_ticket_client=tctn.id_ticket_client 
			  LEFT JOIN pcs_symphony_products p ON tc.id_product=p.id_product 
			  LEFT JOIN pcs_symphony_channels c ON bt.id_channel=c.id_channel 
			  LEFT JOIN pcs_symphony_client_categories r on tc.id_client_category=r.id_client_category 
			  LEFT JOIN pcs_symphony_assignments ass on ass.id_base_ticket=bt.id_base_ticket
			  LEFT JOIN pcs_symphony_client_resolutions res on res.id_client_resolution=ass.id_resolution 
              WHERE bt.id_ticket_type=4 AND  
            		(bt.registry >='".$params['ini']."'  and bt.registry < '$fin' or ass.resolution_date >='".$params['ini']."'  and ass.resolution_date < '$fin')
            		AND bt.status IN (3,4,5)";            
            $data=$this->getReasonsCatalog()->getDb()->fetchAll($sql);
            if(count($data)>0)
            {
                $this->view->setTpl("Index")->setLayoutFile(false);            
                $excel = new ReportExcel();
                $excel->setActiveSheetIndex(0);
                $headers=array('Folio','Estado de concluido o pendiente','Fecha de resolución',
                        'Fecha de notificación al usuario','Entidad federativa',
                        'Fecha de recepción','Medios de recepción','Producto y servicio','Causa',"Importe reclamado","Importe que se restituyó al Usuario",
                    	"Fecha en que se restituyó el importe al Usuario","Folio Inst","Reversa SIGEO");
                $headers= $fixManager->utf8_encode_array($headers);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1 ,utf8_encode("Nombre de la institución: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1 ,utf8_encode("Banco Autofin México S.A Institución de Banca Multiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1 ,utf8_encode("Sector: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1 ,utf8_encode("Instituciones de Banca Múltiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 2 ,utf8_encode("Trimestre a Informar"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 2 ,$trimester);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 2 ,utf8_encode("Número de Aclaraciones"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 2 ,count($data));
                $excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);                
                $c=0;
                foreach($headers as $column){
                 $excel->getActiveSheet()->setCellValueByColumnAndRow($c, 3 ,$column);
                 $c++;
                }
                $i = 4;
                $array_unicos = array();
                foreach($data as $row){
                	if(substr(trim($row['folio']),0,1) != 'P'){
		               	$semilla = trim($row['id_ticket_client']).'-'.trim($row['id_transaction']);
		               	if(!in_array($semilla,$array_unicos)){
		               		$folio=(!$row['folio'] || trim($row['folio'])=="")?$row['folio_prev']:$row['folio'];
		                    if($row['num']>1){
		                    	$arrayFolios[$folio][]=$row['id_transaction'];
		                        $num=count($arrayFolios[$folio]);
		                        $folio=$folio."-".$num;
		                    }
		                    
		                    $dataP = $this->getPartities($row['id_transaction']);
		                    $row['amount']    = $dataP['amount'];
		                    $row['partities'] = $dataP['partities'];
							$excel->getActiveSheet()->setCellValueExplicit("A$i",utf8_encode($folio),PHPExcel_Cell_DataType::TYPE_STRING);		                    
				            if($row['id_resolution'] != null && $row['id_resolution'] != ''){
				            	$row['estado_ticket'] = 2;
				            }
				            else{
				            	if(in_array($semilla,$array_unicos)){
				                	$row['estado_ticket'] = 1;
				                    $row['fecha_notificacion'] = $row['fecha_resolucion'];
				                    $row['fecha_resolucion']= "";
				                }
				                else{
				                	$row['estado_ticket'] = 1;
				                    $row['fecha_resolucion'] ='';
				                    $row['fecha_notificacion'] = '';		                    		
				                }
							}
		                	if(!in_array($semilla,$array_unicos)){
				            	$array_unicos[] = $semilla;
			                }		                    
			                
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i ,utf8_encode($row['estado_ticket']));				            
				            if(trim($row['fecha_resolucion']) != ''){
				            	$row['fecha_notificacion'] = $row['fecha_resolucion'];
				            }else{
				            	$row['fecha_resolucion'] = '';
				            	$row['fecha_notificacion'] = '';
				            }
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(2, $i ,utf8_encode($row['fecha_resolucion']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i ,utf8_encode($row['fecha_notificacion']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i ,utf8_encode($row['entidad']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i ,utf8_encode($row['fecha_recepcion']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i ,utf8_encode($row['medio']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i ,utf8_encode($row['producto']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(8, $i ,utf8_encode($row['causa']));
							if(trim($row['partities'])!= ''){
				            	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,utf8_encode(str_replace('-','',$row['partities'])));
				            }else{
				            	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,utf8_encode(str_replace('-','',$row['importe'])));
				            }
				            if($row['id_resolution'] != null && $row['id_resolution'] != ""){
				            	if((int) $row['type'] == 1){
				            		if((double) $row['importe'] == 0){
				            			$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,'');
				            			$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,'');				            			
				            		}else{
				            			if((double) $row['importe'] <0){
					            			$row['importe'] = $row['importe'] * (-1);
				            			}
				                		$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,utf8_encode($row['importe']));
				                    	$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,utf8_encode($row['ammount_date']));
				            		}
				                }else{
				                    $excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,'');
				                    $excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,'');
				                }
				            }else{
				            	$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,"");
				                $excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,"");
				            }
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(12, $i ,utf8_encode($row['folio_ins']));
				            $excel->getActiveSheet()->setCellValueByColumnAndRow(13, $i ,utf8_encode($row['reversa']));
				            $i++;
                		}
                	}
               }
               $excel->toBrowser2("Reporte_Regulatorio_REUNE_Aclaraciones");
			}
            else{
            	$this->view->seleccion=$params['ini'];
                $this->view->errors=" No existen resultados con el filtro ingresado";
            }
        }
    }
    
    /**
     * Metodo
     */
    public function reuneRecAction()
    {
        $fixManager= new FixManager();
        $ini=$fixManager->getArrayTrimester();
        $this->view->combo=  array_reverse($ini);
        $this->view->errors=false;
        if( $this->getRequest()->isPost() )
        {
            $params = $this->getRequest()->getParams();
            $ini=explode("-",$params['ini']);
            $trimester=$fixManager->getNameNumber($fixManager->getQuarterByMonth($ini[1]))." Trimestre ".$ini[0];
            $nuevafecha = strtotime ( '+ 3 month' , strtotime ( $params['ini'] ) ) ;
            $fin = date ( 'Y-m-d' , $nuevafecha );
            $sql="SELECT tc.id_ticket_client,tc.folio,CASE WHEN bt.status IN(4,5,7,8) THEN 'CONCLUIDO' else 'PENDIENTE' END AS estado_ticket,
                convert(varchar, ass.resolution_date, 103) as fecha_resolucion,
				convert(varchar, ass.resolution_date, 103)  as fecha_notificacion,
            	convert(varchar,  bt.registry, 103)as fecha_recepcion,	
            	convert(varchar,  bt.registry, 103) as reclamation_date,	
            	convert(varchar, tct.transaction_date, 103) as event_date,
            	convert(varchar, ass.assignment_date, 103) as fecha_asignacion,
                tc.id_entidad AS entidad, c.canal_recl as medio,
                tc.account_number,p.name as producto,
				r.name as causa,tct.amount as claimed, 
				CASE WHEN bt.status IN(5,7,8) THEN 'CERRADO' else 'PENDIENTE' END AS estado,
				res.name as resolution,bt.scheduled_date as resolution_date,ass.note as resolution_cause,
				case when tct.good_faith_amount  != null then tct.good_faith_amount  else tct.amount end as importe,
            	case when tct.good_faith_date != null then convert(varchar,tct.good_faith_date, 103) else convert(varchar,ass.resolution_date, 103) end  as ammount_date,
				case when ass.is_recovered_amount='1' then tct.amount else '' end as recovery_amount,
				case when ass.is_recovered_amount='0' then tct.amount else '' end as  quebranto,            		
				c.canal_recl as origen,
            	r.prod_ser_Rec,r.causa_rec,
				tctn.num,tct.id_ticket_client_transaction as id_transaction,tc.folio_condusef,
	            reop.amount as reopen_amount,bt.status,
            	CASE WHEN res.type = '1' then '501' WHEN res.type != '1' then '502' else '503' end as typ,
            	res.type,ass.id_resolution,
	            reop.good_faith_payment as reopen_good_faith_payment,
	            reop.good_faith_date as reopen_good_faith_date,
	            reop.good_faith_amount as reopen_good_faith_amount,
            	ass.status
				FROM pcs_symphony_tickets_clients tc
				INNER JOIN pcs_symphony_base_tickets bt ON tc.id_base_ticket=bt.id_base_ticket
				LEFT JOIN pcs_symphony_tickets_clients_transactions tct ON tc.id_ticket_client=tct.id_ticket_client
				LEFT JOIN ( SELECT COUNT(id_ticket_client_transaction) as num,id_ticket_client FROM pcs_symphony_tickets_clients_transactions GROUP BY id_ticket_client ) as tctn ON tc.id_ticket_client=tctn.id_ticket_client
				LEFT JOIN pcs_symphony_products p ON tc.id_product=p.id_product
				LEFT JOIN pcs_symphony_channels c ON bt.id_channel=c.id_channel
				LEFT JOIN pcs_symphony_client_categories r on tc.id_client_category=r.id_client_category
				LEFT JOIN pcs_symphony_assignments ass on ass.id_base_ticket=bt.id_base_ticket
				LEFT JOIN pcs_symphony_client_resolutions res on res.id_client_resolution=ass.id_resolution
	            LEFT JOIN pcs_symphony_tickets_clients_reopen reop on reop.id_ticket_client_transaction = tct.id_ticket_client_transaction
	            WHERE 
            		(bt.registry >='".$params['ini']."'  and bt.registry < '$fin' or ass.resolution_date >='".$params['ini']."'  and ass.resolution_date < '$fin')
            		AND bt.status IN (3,4,5,6)  AND ass.status = 1 
	            	AND (bt.id_ticket_type = 2 or ( bt.id_ticket_type = 4 and tc.complaint = 1))
	            ORDER BY tc.id_ticket_client,ass.resolution_date desc,bt.registry,tct.transaction_date";
            $data = $this->getReasonsCatalog()->getDb()->fetchAll($sql);
            if(count($data)>0)
            {
                $this->view->setTpl("Index")->setLayoutFile(false);            
                $excel = new ReportExcel();
                $excel->setActiveSheetIndex(0);
                $headers=array('Folio','Estado','Fecha de resolución','Fecha de notificación al usuario','Entidad federativa',
                        'Fecha de recepción','Medios de recepción','Producto y servicio','Causa','Importe reclamado',
                		'Importe que se restituyó al Usuario','Fecha en que se restituyó el importe al Usuario','Folio Inst','Reversa SIGEO');
                
                $headers= $fixManager->utf8_encode_array($headers);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 1 ,utf8_encode("Nombre de la institución: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 1 ,utf8_encode("Banco Autofin México S.A Institución de Banca Multiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 1 ,utf8_encode("Sector: "));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 1 ,utf8_encode("Instituciones de Banca Múltiple"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(0, 2 ,utf8_encode("Trimestre a Informar"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, 2 ,$trimester);
                $excel->getActiveSheet()->setCellValueByColumnAndRow(3, 2 ,utf8_encode("Número de Reclamaciones"));
                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, 2 ,count($data));
                $excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
                $excel->getActiveSheet()->getStyle('A3:N3')->getFont()->setBold(true);
                
                $c=0;
                foreach($headers as $column){
                 $excel->getActiveSheet()->setCellValueByColumnAndRow($c, 3 ,$column);
                 $c++;
                }
                $i = 4;
                $array_unicos  = array();
                $nmFolio="";
                foreach($data as $row){
                	$semilla =  trim($row['id_ticket_client']).'-'.trim($row['id_transaction']);
					$folio = $row['folio'];
					if($row['num'] > 1){
		               	$arrayFolios[$folio][] = $row['id_transaction'];
		               	$num                   = count($arrayFolios[$folio]);
		            	$folio				   = $folio."-".$num;
		            }
					if(trim($row['folio_condusef']) == ''){
						$nmFolio = $folio;		                	
		            }else{
		            	$nmFolio = $row['folio_condusef'];
		            }		         
	                if($row['id_resolution'] != null && $row['id_resolution'] != ''){
	                	$row['estado_ticket'] = 2;
	                }
	                else{
	                	if(in_array($semilla,$array_unicos)){
	                		if($row['id_resolution'] != null && $row['id_resolution'] != ''){
	                			$row['estado_ticket'] = 2;
	                		}
	                		else{
	                			$row['estado_ticket'] = 1;
	                		}
	                    	$row['fecha_notificacion'] = $row['fecha_resolucion'];
	                    	$row['fecha_resolucion']= "";	                		
	                	}
	                	else{
		                	$row['estado_ticket'] = 1;
		                	$row['fecha_resolucion']= $row['fecha_asignacion'];
	                	}
	                }
                	if(!in_array($semilla,$array_unicos)){
		            	$array_unicos[] = $semilla;
	                }	                
	                $excel->getActiveSheet()->setCellValueExplicit("A$i",utf8_encode($nmFolio),PHPExcel_Cell_DataType::TYPE_STRING);
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(1, $i ,utf8_encode($row['estado_ticket']));	    
	                if(trim($row['estado_ticket']) == 1){
	                	$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $i ,'');
	                 	$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i ,"");
	                }else{
	                	$excel->getActiveSheet()->setCellValueByColumnAndRow(2, $i ,utf8_encode($row['fecha_resolucion']));
	                  	$excel->getActiveSheet()->setCellValueByColumnAndRow(3, $i ,utf8_encode($row['fecha_notificacion']));
	                }	                
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(4, $i ,utf8_encode($row['entidad']));
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(5, $i ,utf8_encode($row['fecha_recepcion']));
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(6, $i ,utf8_encode($row['medio']));
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(7, $i ,utf8_encode($row['producto']));
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(8, $i ,utf8_encode($row['causa']));
	                if(trim($row['claimed']) != ''){
	                	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,((double) $row['claimed'] * -1));
	                }
		            else{
	                	$excel->getActiveSheet()->setCellValueByColumnAndRow(9, $i ,utf8_encode((double) $row['reopen_amount'] * -1));
		            }
					//$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,utf8_encode($row['importe_usuario']));
	                //$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,utf8_encode($row['fecha_importe']));
		            //$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,utf8_encode($row['importe']));
	                //$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,utf8_encode($row['ammount_date']));
	                
		            if(trim(utf8_encode($row['typ'])) == '501'){
		            	if((double) $row['importe'] == 0){
		            		$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,'');
		            		$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,'');
		            	}
						else{		            	
		            		if((double) $row['importe'] <0){
			            		$row['importe'] = (double) $row['importe'] * (-1);
		            		}		            	
		            		$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,number_format($row['importe'],2,'.',','));
		            		$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,utf8_encode($row['ammount_date']));
						}
		            }else{
		            	$excel->getActiveSheet()->setCellValueByColumnAndRow(10, $i ,'');
		            	$excel->getActiveSheet()->setCellValueByColumnAndRow(11, $i ,'');
		            }
		            
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(12, $i ,utf8_encode($row['folio_ins']));
	                $excel->getActiveSheet()->setCellValueByColumnAndRow(13, $i ,utf8_encode((int)$row['reversa']));
	                $i++;
                }
                $excel->toBrowser2("Reporte_Regulatorio_REUNE_Reclamaciones");
            }
            else{
                $this->view->seleccion=$params['ini'];
                $this->view->errors=" No existen resultados con el filtro ingresado";
            }
        }
    }
    
    /**
     * Metodo
     */
    public function reporteDireccionGeneralAction()
    {
    	
    }
    
    /**
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getReasonsCatalog(){
        return $this->getContainer()->get('ReasonsCatalog');
    }
    
    private function getTicketClientFieldCatalog(){
    	return $this->getCatalog('TicketClientFieldCatalog');
    }
}
?>