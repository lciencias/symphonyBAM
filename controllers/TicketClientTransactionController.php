<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    
 * @version   2
 */
use Application\Controller\BaseController;
use Application\Model\Bean\ControversyChargebacks;
use Application\Model\Bean\ControversyIssues;
use Application\Model\Catalog\SessionCatalog;
use Application\Model\Catalog\TicketsClientsTransactionsCatalog;
use Application\Query\ControversyChargebacksQuery;
use Application\Query\TicketsClientsTransactionsQuery;
use Application\Webservice\WSClient;

use Application\Manager\FixManager;
use Application\Model\Bean\File;
use Application\Model\Bean\TicketsClients;
use Application\Query\ControversyIssuesQuery;
use Application\Query\ControversyReasonsQuery;
use Application\File\FileUploader;
use Application\Model\Bean\TicketsClientsTransactions;

/**
 *
 * @author chente
 */
class TicketClientTransactionController extends BaseController{

	private $uploadPath = 'tickets-clients-transactions';
	
    public function init(){
        parent::initI18n();
        parent::toView();
    }

    public function formatoFecha($fecha){
    	$date = date_create($fecha);
    	return date_format($date, 'd-m-Y');
    }
    public function transactionByTypeAction(){
    	$sql="";
        $params = $this->getRequest()->getParams();
        $id     = $params['id_transaction'];
        $type   = $params['type'];        
        $WSClient = new WSClient();
        $sql="SELECT a.amount,a.commerce,a.delivered_payment,a.description,a.file_delivery,a.file_payment,
				a.good_faith_amount,a.good_faith_date,a.good_faith_payment,a.good_faith_request,a.id_controversy_chargeback,a.id_ticket_client,
				a.id_ticket_client_transaction,a.id_transaction_bam,a.idT24,a.payment_delivery_date,a.payment_request_date,a.reference,a.transaction_date,
				a.type,b.amount as amount_partial,b.deposit_date as deposit_date_partial,b.id_ticket_client_transaction,b.id_ticket_client_transaction_partiality,b.not_aplied_deposit,
				b.type,b.voucher        
        		from pcs_symphony_tickets_clients_transactions as a LEFT JOIN pcs_symphony_tickets_clients_transactions_partialities as b 
             	ON a.id_ticket_client_transaction = b.id_ticket_client_transaction WHERE a.id_ticket_client_transaction='$id'";        
        $query=$this->getSessionCatalog()->getDb()->fetchAll($sql);
        $idTransactionBam = $query[0]['id_transaction_bam'];
        if(trim($idTransactionBam) != ""){
        	$data_array=array();        	
        	$data_array += $query;        	
        	switch($type){
                  case '0':
        			$detalleb = $WSClient->getDetailTransactionId($idTransactionBam);        			
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '1':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);        		
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '2':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '3':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);        			 
        			die(json_encode($res));
        			break;
        		case '4':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '5':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);        		
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '6':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);        		
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '7':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$res[0]=array_merge($data_array[0],$detalleb);
        			$res[0]['transaction_date']=self::formatoFecha($res[0]['transaction_date']);
        			$res[0]['date_deposit']=self::formatoFecha($res[0]['date_deposit']);        		
        			$res[0]['deposit_date_partial']=self::formatoFecha($res[0]['deposit_date_partial']);
        			die(json_encode($res));
        			break;
        		case '8':
        			$detalleb = $WSClient->getTransactionByType($type,$idTransactionBam);
        			$contracargos[0]  = array("direct"=> 0, "trad" => 0, "id_controversy_chargeback" => array('id_controversy_chargeback' => "","name" =>""));
        			$transactionBd = TicketsClientsTransactionsQuery::create()->findByPK($id);        			 
        			if($transactionBd != null){
        				$sql_data = "select a.id_ticket_client_transaction,a.id_ticket_client,a.id_transaction_bam,
        								a.transaction_date,a.amount,a.good_faith_payment,a.good_faith_date,a.good_faith_amount,
        								a.id_controversy_chargeback,a.payment_request_date,a.payment_delivery_date,
        								a.accepted_payment,a.delivered_payment,a.type as type_transaction,a.file_payment,
        								a.good_faith_request,a.reference,a.afiliation,a.commerce,a.description,a.idT24,
        								a.file_delivery,
        								b.name,b.type,b.status,
										b.id_controversy_reason,
										c.name as reason, c.type as reason_type,c.debit_time
										FROM pcs_symphony_tickets_clients_transactions as a
										LEFT JOIN pcs_symphony_controversy_chargebacks AS b
										ON b.id_controversy_chargeback = a.id_controversy_chargeback
										LEFT JOIN pcs_symphony_controversy_reasons AS c
										ON c.id_controversy_reason = b.id_controversy_reason
										where a.id_ticket_client_transaction = '".$id."';";
        				$res_data =$this->getSessionCatalog()->getDb()->fetchAll($sql_data);
						if(count($res_data) > 0){
							$idReason = $res_data[0]['id_controversy_reason'];
							if((int) $idReason > 0){
								$s_issues_c="SELECT * FROM pcs_symphony_controversy_issues WHERE id_controversy_reason='".$idReason."' AND type=1";
								$issues_condition=$this->getSessionCatalog()->getDb()->fetchAll($s_issues_c);
								$res_data[0]['type1'] = self::createData($issues_condition);
								$s_issues_d="SELECT * FROM pcs_symphony_controversy_issues WHERE id_controversy_reason='".$idReason."' AND type=2";
								$issues_docs=$this->getSessionCatalog()->getDb()->fetchAll($s_issues_d);
								$res_data[0]['type2'] = self::createData($issues_docs);
								$s_issues_r="SELECT * FROM pcs_symphony_controversy_issues WHERE id_controversy_reason='".$idReason."' AND type=3";
								$issues_rep=$this->getSessionCatalog()->getDb()->fetchAll($s_issues_r);
								$res_data[0]['type3'] = self::createData($issues_rep);
							}							
						}
						$transactionBd->setTransactionDate($transactionBd->getTransactiondateAsZendDate()->toString('yyyy-MM-dd'));
						$listTransaction=$transactionBd->toArray();						
        				$idCharger=$transactionBd->getIdControversyChargeback();
        				if((int) $idCharger > 0){
        					$sql_charger="SELECT * FROM pcs_symphony_controversy_chargebacks WHERE id_controversy_chargeback='$idCharger'";
        					$charger=$this->getSessionCatalog()->getDb()->fetchAll($sql_charger);
        					$contracargos[0]=array("direct"=>0,"trad"=>0,"id_controversy_chargeback"=>$charger[0]['id_controversy_chargeback'],"name"=>$charger[0]['name']);        					 
        					if(count($charger)>0){
        						if($charger[0]['type']==1)
        							$contracargos[0]["direct"] = $charger[0]['name'];
        						if($charger[0]['type']==2)
        							$contracargos[0]["trad"]   = $charger[0]['name'];
        					}
        				}
        				$datos=array();
        				$tmp = self::datosExtra($query,$id);
        				//echo"<pre>";print_r($detalleb);        				
        				$tmp[0]['date_deposit_partial'] = self::formatoFecha($tmp[0]['deposit_date_partial']);
        				$tmp[0]['deposit_date_partial'] = self::formatoFecha($tmp[0]['deposit_date_partial']);
        				$datos['transaction']   = $detalleb;        				
        				$datos['contracargos']  = $contracargos;
        				$datos['partial']       = self::encode($tmp);        				
        				$datos['transactionBd'] = self::encode($res_data);
        				//echo"<pre>";print_r($datos);die();
        				die(json_encode($datos));
        			}
        			break;
        	}			        	
        }
        die();
    }
    
    public function encode($data){
    	$array = array();
    	if(count($data) > 0){
    		foreach($data as $ind => $tmp){
    			foreach($tmp as $key => $value){
    				if($value != '')
    					$array[$ind][$key] = utf8_encode($value);
    			}
    		}
    	}
    	return $array;
    }
    
    
    public function createData($array){
    	$datos = array();
    	if(count($array) > 0){
    		foreach($array as $tmp){
    			$datos[] = $tmp['name'];
    		}
    	}
    	return implode("<br>",$datos);
    }
    
	/**
	 * Metodo para cargos los contoversy
	 */
    public function controversyReasonAction(){
    	$fixManager= new FixManager();
    	$params = $this->getRequest()->getParams();
    	$datos=array();
    	$id   = $params['id_controversy_reason'];
    	if((int) $id > 0){    		
    		try{
	    		$reason = ControversyReasonsQuery::create()->findByPK($id);	    		
	    		$reasonIssues = ControversyIssuesQuery::create()->whereAdd(ControversyIssues::ID_CONTROVERSY_REASON,$id)->fetchAll();
	    		$reasonCharge = ControversyChargebacksQuery::create()->whereAdd(ControversyChargebacks::ID_CONTROVERSY_REASON, $id)->fetchAll();
	    		$datos ['exito']  = 1;
	    		$datos ['reason'] = $fixManager->utf8_encode_array($reason->toArray());
	    		$datos ['issues'] = $fixManager->utf8_encode_array($reasonIssues);
	    		$datos ['charge'] = $fixManager->utf8_encode_array($reasonCharge);	    		
    		}
    		catch(Exception $e){
    			$datos ['exito']  = 0;
    			$datos ['reason'] = $e->getMessage();
    		}
    	}
    	die(json_encode($datos));
    }

    /**
     * Metodo que consume el web service para generar el log
     */
    public function viewLogAction(){
    	$result = array();
    	$WSClient = new WSClient();
    	$params = $this->getRequest()->getParams();    
//     	print_r($params);
//     	die();
    	$id_transaction    = $params['id_transaction'];
    	$fecha_transaction = $params['fecha_transaction'];
    	if( $id_transaction != ""){
    		$fecha_transaction = substr($fecha_transaction,6,4)."-".substr($fecha_transaction,3,2)."-".substr($fecha_transaction,0,2);
    		$result = $WSClient->getViewLog($id_transaction, $fecha_transaction);			
    	}
    	die(json_encode($result));
    }
     
    /**
     * Metodo para llamar al webservice con los datos de las amortizaciones
     */
    public function amortizationAction(){
    	$result = array();
        $WSClient = new WSClient();
        $params = $this->getRequest()->getParams();
        $accountNumber=$params['account_number'];
        $accountNumber="LD0819700016";
        $result = $WSClient->getAmortizaciones($accountNumber);
        $result['verAmotizaciones']=$result;
        
//    	$result['verAmotizaciones']= array('15-12-2011'=>'2056.89','16-12-2011'=>'1253.50','17-12-2011'=>'1526.20','17-12-2011'=>'1526.20');
    	die(json_encode($result));
    	
    }
    
    private function datosExtra($query,$id){
    	$array = array();
    	$sql="SELECT b.amount as amount_partial,b.deposit_date as deposit_date_partial,b.id_ticket_client_transaction,b.id_ticket_client_transaction_partiality,b.not_aplied_deposit,
				b.type,b.voucher from pcs_symphony_tickets_clients_transactions_partialities as b WHERE b.id_ticket_client_transaction='$id'";
    	$array =$this->getSessionCatalog()->getDb()->fetchAll($sql);
    	if(count($query) >= 0  && count($array)> 0){
    		foreach($query as $indice => $tmp){
    			$tmp = $array[$indice];
    			foreach($tmp as $key => $value){
    				$query[$indice][$key] = $value;    				
    			}
    		}
    	}
    	return $query;
    }

    /**
     * @return Application\Model\Catalog\TicketsClientsTransactionsCatalog
     */
    private function getTicketsClientsTransactionsCatalog(){
    	return $this->getContainer()->get('TicketsClientsTransactionsCatalog');
    }
    
    /**
     * @return Catalog
     */
    private function getSessionCatalog(){
        return $this->getCatalog('SessionCatalog');
    }
    
}
