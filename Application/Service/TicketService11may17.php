<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Service;
use Application\Automata\TicketAutomata;
use Application\Event\EmailEvent;
use Application\Model\Bean\Assignment;
use Application\Model\Bean\Attachment;
use Application\Model\Bean\BaseTicket;
use Application\Model\Bean\ClientResolution;
use Application\Model\Bean\Condition;
use Application\Model\Bean\File;
use Application\Model\Bean\Resolution;
use Application\Model\Bean\Ticket;
use Application\Model\Bean\TicketClient;
use Application\Model\Bean\TicketLog;
use Application\Model\Bean\User;

use Application\Model\Catalog\AssignmentCatalog;
use Application\Model\Catalog\AttachmentCatalog;
use Application\Model\Catalog\TicketCatalog;
use Application\Model\Catalog\TicketClientCatalog;
use Application\Model\Catalog\TicketLogCatalog;
use Application\Model\Catalog\TicketsClientsTransactionsCatalog;
use Application\Model\Exception\TicketException;
use Application\Model\Factory\AssignmentFactory;
use Application\Model\Factory\AttachmentFactory;
use Application\Model\Factory\TicketClientFactory;
use Application\Model\Factory\TicketFactory;
use Application\Model\Factory\TicketLogFactory;
use Application\Model\Factory\TicketsClientsTransactionsFactory;
use Application\Query\AssignmentQuery;
use Application\Model\Bean\TicketsClientsTransactions;
use Application\Query\TicketClientQuery;
use Application\Query\FileTmpQuery;
use Application\Model\Bean\FileTmp;
use Application\Model\Catalog\FileCatalog;
use Application\Model\Bean\TransactionsPartialities;
use Application\Model\Catalog\TransactionsPartialitiesCatalog;
use Application\Query\GroupQuery;
use Application\Model\Bean\Group;
use Application\Query\UserQuery;
use Application\Query\EmailQuery;
use Application\Model\Bean\Email;
use Application\Model\Catalog\EmailCatalog;
use Application\Query\PersonQuery;
use Application\Model\Bean\Person;
use Application\Model\Bean\TicketType;
use Application\Query\TicketLogQuery;

/**
 *
 * TicketService
 *
 * @category Application\Service
 * @author guadalupe, chente
 */
class TicketService extends AbstractService
{
    /**
     *
     */
	//const SIN_FOLIO_STATUS = "Pending";
    const INITIAL_STATUS = "Unread";

    /**
     * @var \Application\Model\Catalog\TicketCatalog
     */
    protected $ticketCatalog;
    
    /**
     * @var \Application\Model\Catalog\TicketClientCatalog
     */
    protected $ticketClientCatalog;
    
    /**
     * @var \Application\Model\Catalog\TicketLogCatalog
     */
    protected $ticketLogCatalog;

    /**
     *
     * @var \Application\Automata\TicketAutomata
     */
    protected $ticketAutomata;

    /**
     * @var \Application\Model\Catalog\AssignmentCatalog
     */
    protected $assignmentCatalog;
    
    
    /**
     * @var \Application\Model\Catalog\TicketsClientsTransactionsCatalog
     */
    protected $ticketsClientsTransactionsCatalog;
    
    /**
     * @var \Application\Model\Catalog\FileCatalog
     */
    protected $fileCatalog;
    
    /**
     * @var \Application\Model\Catalog\TransactionPartialitiesCatalog
     */
    protected $transactionsPartialitiesCatalog;

    /**
     * @var \Application\Model\Catalog\EmailCatalog
     */
    protected $emailCatalog;
    /**
     * 
     * @var \Application\Model\Catalog\AttachmentCatalog
     */
	private $attachmentCatalog;
    /**
     * 
     * @param array $params
     * @param User $user
     * @param bool $validate
     * @throws Exception
     * @return Ambigous <\Application\Model\Bean\Ticket, \Application\Model\Bean\TicketClient>
     */
    public function create($params, User $user, $validate = true)
    {
    	
    	
    	if(!empty($params['id_reason'])){
    		$tmp = explode('-',$params['id_reason']);
    		$params['id_reason'] = $tmp[0];
    	}
        if( $validate ){
            $this->validate($params);
        }
        try {
            $this->getTicketCatalog()->beginTransaction();
			
            $now = new \Zend_Date();
            
//            $status = array_search(self::INITIAL_STATUS, Ticket::$Statuses);
            if($params['status_to'])
            $status = array_search($params['status_to'], Ticket::$Statuses);
            else
                $status = array_search(self::INITIAL_STATUS, Ticket::$Statuses);
            if($params['controller'] == 'ticket'){
            	$ticket =TicketFactory::createFromArray($params);
            	$ticket->setStatus($status);
            	$ticket->setCreated($now->get('yyyy-MM-dd HH:mm:ss'));
            	$ticket->setIdUser($user->getIdUser());
            	$ticket->setType(BaseTicket::$Type['Ticket']);
            	$this->getTicketCatalog()->create($ticket);
            }
            else if ($params['controller'] == 'ticket-client'){
            	$ticket = TicketClientFactory::createFromArray($params);
            	$ticket->setStatus($status);
            	$ticket->setCreated($now->get('yyyy-MM-dd HH:mm:ss'));
            	$ticket->setScheduledDate($now->get('yyyy-MM-dd HH:mm:ss'));
            	$ticket->setIdUser($user->getIdUser());
            	$ticket->setIdProduct((int) $params['id_product']);
            	$ticket->setEmail($params['email']);
            	$ticket->setStateClient($params['state_client']);
            	$ticket->setClientNumber($params['client_number']);
            	$ticket->setTelefono($params['telefono']);
            	$ticket->setType(BaseTicket::$Type['TicketClient']);
            	$ticket->setCardType($params['card_type']);
            	$ticket->setNameClient($params['name_client']);
            	$ticket->setChanel($params['chanel']);
            	$ticket->setAccountType($params['account_type']);
            	$ticket->setIdEntidad($params['id_entidad']);
            	if(trim($params['card_type']) == ""){
            		$ticket->setCardType("3");
            	}
            	$ticket->setEmployee($params['employee']);
            	if(trim($params['employee']) == ""){
            		$ticket->setEmployee(2);
            	}
            	$ticket->setNoCard($params['no_card']);
            	if((int) $params['id_ticket_type'] == 3){
            		//$ticket->setIdClientCategory(1);
            		$ticket->setIdAssignment($user->getIdUser());
            	}
            	$this->getTicketClientCatalog()->create($ticket);
                if($params['folio_condition']==1){
                	$ticket->setFolio($this->generateFolio($ticket->getIdBaseTicket()));
                }
            	else{
            		//$folioPrev = $this->generateFolioPrevio();
            		//$ticket->setFolio($folioPrev);
            		$folioPrev = $this->generateFolio($ticket->getIdBaseTicket());
            		$ticket->setFolio("P".$folioPrev);
            		$ticket->setFolioPrev("P".$folioPrev);
            	}
            	$this->getTicketClientCatalog()->update($ticket);
            }            
            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Create'],
                'changed_from' => $user->getIdUser(),
                'changed_to' => $user->getIdUser(),
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);

            
            $ticketLog->setIdTicketLog(null);
            $ticketLog->setEventType(TicketLog::$EventTypes['Response_Start_Time']);
            $this->getTicketLogCatalog()->create($ticketLog);

            
            $logInfo = array_merge(array(
                'event_type' => TicketLog::$EventTypes['Status'],
                'changed_to' => 1,
            ), $ticketLog->toArrayFor(array('id_base_ticket', 'id_user', 'date_log', 'changed_from', 'note')));
            $ticketLog = TicketLogFactory::createFromArray($logInfo);
            $this->getTicketLogCatalog()->create($ticketLog);
            foreach($params as $key => $value){
            	if(substr($key,0,9) == "checkbox-"){
            		$tmp = explode('*',$value);
            		$ticketsClientsTransactions = TicketsClientsTransactionsFactory::createFromArray(array(
            				'id_ticket_client'   => $ticket->getIdTicketClient(), 
            				'id_transaction_bam' => $tmp[0],
            				'transaction_date'   => substr($tmp[1],6,4)."-".substr($tmp[1],3,2)."-".substr($tmp[1],0,2)." 00:00:00",
            				'amount' => (double) $tmp[2],
            				'type' => (double) $tmp[3],
            				'commerce'=> $tmp[4],
            				'reference' =>$tmp[5],
            				'afiliation' => $tmp[6],
            				'idT24' => $tmp[7],
            				'description' => $tmp[8]
            		));
            		$this->getTicketsClientsTransactionsCatalog()->create($ticketsClientsTransactions);
            		$fileTmp = FileTmpQuery::create()->whereAdd(FileTmp::ID_TRANSACTION,$tmp[0])
            				   ->page(1,1)->orderBy(FileTmp::ID_TRANSACTION,'desc')->find();
            		if($fileTmp != null && count($fileTmp) > 0){
            			$file = new File();
            			$file->setOriginalName($fileTmp->getOne()->getOriginalName()); 
            			$file->setUri($fileTmp->getOne()->getUri());
						$this->getFileCatalog()->create($file);            			
						$transactionPartialities = new TransactionsPartialities();
						$transactionPartialities->setIdTicketClientTransaction($ticketsClientsTransactions->getIdTicketClientTransaction());
						$transactionPartialities->setAmount($fileTmp->getOne()->getAmountDeposit());
						$transactionPartialities->setDepositDate($fileTmp->getOne()->getDateDeposit()); 
						$transactionPartialities->setType($fileTmp->getOne()->getTypeDeposit()); 
						$transactionPartialities->setVoucher($file->getIndex());
						$this->getTransactionsPartialitiesCatalog()->create($transactionPartialities);
            		}            		
            	}
            }  
            //Eliminar los regitros de la tabla personal
            foreach($params as $key => $value){
            	if(substr($key,0,9) == "checkbox-"){
            		$tmp = explode('*',$value);
            		$del = "DELETE FROM pcs_symphony_files_tmp where id_transaction = '".$tmp[0]."';";
            		$this->getFileCatalog()->getDb()->query($del);
            	}
            }
            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_CREATE : EmailEvent::TICKET_CREATE;
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));
            $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
        return $ticket;
    }

    
    
    /**
     *
     * @param BaseTicket $ticket
     * @param array $params
     * @param User $user
     * @throws Exception
     * @return Ambigous <BaseTicket, \Application\Model\Bean\Ticket, \Application\Model\Bean\TicketClient>
     */
    public function update(BaseTicket $ticket, array $params, User $user)
    {
        if(!empty($params['id_reason'])){
    		$tmp = explode('-',$params['id_reason']);
    		$params['id_reason'] = $tmp[0];
    	}    	
    	$this->validateUpdate($params, $ticket);
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $now = new \Zend_Date();
			if ($ticket instanceof Ticket){
				TicketFactory::populate($ticket, $params);
				$this->getTicketCatalog()->update($ticket);
			}
			else if ($ticket instanceof TicketClient){
				TicketClientFactory::populate($ticket, $params);
				$this->getTicketClientCatalog()->update($ticket);
			}
            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Update'],
                'changed_from' => 0,
                'changed_to' => 0,
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);
           	$event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_UPDATE : EmailEvent::TICKET_UPDATE;
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));
            $this->getTicketCatalog()->commit();
            
        }
        catch (\Exception $e) {
        	die($e->getMessage());
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
        return $ticket;
    }
    
    public function updateFolio($ticket){
        if ($ticket instanceof TicketClient ){
        	$folioPrev = $ticket->getFolioPrev();
        	$folioPrev = str_replace("P","",$folioPrev);
	        //if(trim($ticket->getFolio())==""){
	        $documentsRequired = \Application\Query\RequiredDocumentQuery::create()
	          					->innerJoinDocument()
	                            ->whereAdd(\Application\Model\Bean\RequiredField::ID_CLIENT_CATEGORY, $ticket->getIdClientCategory())
	                            ->count();
			$documentsTicket= \Application\Query\TicketClientDocumentQuery::create()
	          					->whereAdd(\Application\Model\Bean\TicketClientDocument::ID_TICKET_CLIENT, $ticket->getIdTicketClient())
	                            ->count();
			if($documentsRequired == $documentsTicket)
	        {
	        	//$ticket->setFolio($this->generateFolio($ticket->getIdBaseTicket()));
	        	$ticket->setFolio($folioPrev);
	//          $ticket->setFolioPrev('');
	            $this->getTicketClientCatalog()->update($ticket);
	        }
        }
        //}
            return $ticket;
    }

    /**
     * @param BaseTicket $ticket
     * @param array $params
     * @param string $note
     */
    public function cancel(BaseTicket $ticket, User $user, $note = '', $dateLog = null)
    {
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $this->getTicketMachine()->handle($ticket, Condition::CANCEL, array(
                'user' => $user,
                'note' => $note,
                'date_log' => $dateLog,
            ));
            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_CANCEL : EmailEvent::TICKET_CANCEL;
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));

            $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }

    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function working(BaseTicket $ticket, User $user){
        $this->getTicketMachine()->handle($ticket, Condition::WORK, array('user' => $user));
    }
    
    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function pending(BaseTicket $ticket, User $user){    	
    	$status = array_search(self::INITIAL_STATUS, Ticket::$Statuses);
        //$this->getTicketMachine()->handle($ticket, Condition::READ, array('user' => $user));    	
        try{
	        $this->getTicketCatalog()->beginTransaction();
	        $ticket->setFolio($this->generateFolioPrevio());
	        $ticket->setStatus($status);
	        $this->getTicketClientCatalog()->update($ticket);
	        $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
        	//$this->getTicketCatalog()->rollBack();
        	throw $e;
        }
    }

    public function getResponseTime($arrayTicket){
    	$arrayReturn = $arrayIdsTicket = array();
    	if(count($arrayTicket) > 0){
    		foreach($arrayTicket as $data){
    			foreach($arrayTicket as $data){    				
    				if(!in_array( (int) $data['id_ticket_client'], $arrayIdsTicket)){
    					$arrayIdsTicket[] = (int) $data['id_ticket_client'];
    				}    				
    			}
    		}
   			$sql="select a.id_ticket_client,b.response_time from 
   					pcs_symphony_tickets_clients a 
   					inner join pcs_symphony_client_categories c  ON c.id_client_category  = a.id_client_category
   					inner join pcs_symphony_service_levels as b  ON b.id_service_level = c .id_service_level 
   					WHERE a.id_ticket_client IN (".implode(',',$arrayIdsTicket).") ;";
    			$res = $this->getTicketsClientsTransactionsCatalog()->getDb()->fetchAll($sql);
    			if(count($res) > 0){
    				foreach($res as $tmp){
    					$arrayReturn[$tmp['id_ticket_client']] = (double) $tmp['response_time'];
    				}
    			}    			 
    	}
    	return $arrayReturn;
    }
    
    /**
     * Metodo que calcula la suma del monto de transacciones del ticket
     * @param array $arrayTicket
     */
    public function getAmount($arrayTicket){
    	$arrayIds = $arrayReturn = array();
    	if(count($arrayTicket) > 0){
    		foreach($arrayTicket as $data){
    			if(!in_array( (int) $data['id_ticket_client'], $arrayIds)){
    				$arrayIds[] = (int) $data['id_ticket_client'];
    			}
    		}
    		$amount = 0;
    		$sql = "SELECT a.id_ticket_client,a.amount as amountTransaction,b.amount as amountPartities
					FROM pcs_symphony_tickets_clients_transactions as a 
					LEFT JOIN pcs_symphony_tickets_clients_transactions_partialities as b 
					ON a.id_ticket_client_transaction = b.id_ticket_client_transaction
					WHERE id_ticket_client iN (".implode(',',$arrayIds).") ORDER BY a.id_ticket_client;";
    		$res = $this->getTicketsClientsTransactionsCatalog()->getDb()->fetchAll($sql);
			if(count($res) > 0){
				foreach($res as $tmp){
					$id = $tmp['id_ticket_client'];
					$amountTrans =  $tmp['amountTransaction'];
					$amountParti =  $tmp['amountPartities'];
					$amount      = 0;
					if(trim($amountParti) != ''){
						$amount = $amountParti;
					}else{
						$amount = $amountTrans;
					}
					$arrayReturn[$id] = (double)$arrayReturn[$id] + (double) $amount + 0;
				}
			}
    	}
    	return $arrayReturn;
    }
    

    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function read(BaseTicket $ticket, User $user){
        $this->getTicketMachine()->handle($ticket, Condition::READ, array('user' => $user));
    }

    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function reopen(BaseTicket $ticket, User $user){    	
    	$this->getTicketCatalog()->beginTransaction();
    	$ticket->setIdAssignment(null);
    	try {
    		if ($ticket instanceof Ticket){
    			$this->getTicketCatalog()->update($ticket);
    		}    			
    		else if ($ticket instanceof TicketClient){
    			$ticket->setIdResolver($user->getIdUser());
    			$this->getTicketClientCatalog()->update($ticket);
    		}
    	}catch (Exception $e){
			    		
    	}
    	$this->getTicketCatalog()->commit();
        $this->getTicketMachine()->handle($ticket, Condition::OPEN, array('user' => $user));
        if ($ticket instanceof TicketClient){
        	$event = EmailEvent::TICKET_CLIENT_REOPEN_CONDUSET; //luis
        	$this->getEventDispatcher()->dispatch($event, new EmailEvent(array('ticket' => $ticket,'user' =>  $user,)));
        }       
    }

    
    public function updateCondusef (TicketClient $ticketClient,$folioConduset,$channel){
    	$this->getTicketClientCatalog()->beginTransaction();
    	try {
    		if($channel == 2){
    			$ticketClient->setFolioCondusef("R".$ticketClient->getFolio());
    		}else{
	    		$ticketClient->setFolioCondusef($folioConduset);
    		}
	    	$ticketClient->setIdChannel($channel);
	    	$ticketClient->setComplaint(1);
	    	$this->getTicketClientCatalog()->update($ticketClient);
	    	$this->getTicketClientCatalog()->commit();	    	
    	}
    	catch(Exception $e){
    		$this->getTicketClientCatalog()->rollBack();
    	}
    	 
    }
    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function close(BaseTicket $ticket, User $user, $dateLog = null){
        $now = new \Zend_Date();
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $this->getTicketMachine()->handle($ticket, Condition::CLOSE, array(
                'user' => $user,
                'date_log' => $dateLog,
            ));

            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $dateLog ?: $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Resolution_End_Time'],
                'changed_from' => 0,
                'changed_to' => 0,
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);
            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_CLOSE : EmailEvent::TICKET_CLOSE;
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));

            $this->getTicketCatalog()->commit();
        }
        catch (Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }

    /**
     * @param BaseTicket $ticket
     * @param array $params
     */
    public function resolve(BaseTicket $ticket, Resolution $resolution, User $user, $note, $dateLog = null)
    {
        $now = new \Zend_Date();
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $assignment = $this->findAssignment($ticket->getIdAssignment());

            $assignment->setIdResolution($resolution->getIdResolution());
            $assignment->setResolutionDate($dateLog ?: $now->get('yyyy-MM-dd HH:mm:ss'));
            $assignment->setNote($note);
            $this->getAssignmentCatalog()->update($assignment);

            $this->getTicketMachine()->handle($ticket, Condition::RESOLVE, array(
                'user' => $user,
                'date_log' => $dateLog,
            ));
            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_RESOLVE : EmailEvent::TICKET_RESOLVE;
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));

            $this->getTicketCatalog()->commit();
        }
        catch (Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }
    /**
     * 
     * @param BaseTicket $ticket
     * @param ClientResolution $resolution
     * @param User $user
     * @param string $note
     * @param string $dateLog
     * @param File $file
     * @throws Exception
     */
    public function resolveTicketClient(BaseTicket $ticket, ClientResolution $resolution, User $user, $note, $dateLog = null, File $file = null,$recoveryAmount = null,$isRecoveredAmount = null)
    {
    	$now = new \Zend_Date();
    	try
    	{
    		$this->getTicketCatalog()->beginTransaction();
    		if($file != null){
    			$attachment = AttachmentFactory::createFromArray($file->toArray());
    			$attachment->setIdBaseTicket($ticket->getIdBaseTicket());
    			$attachment->setIdUser($user->getIdUser());
    		}
    		$assignment = $this->findAssignment($ticket->getIdAssignment());
    		$assignment->setIdResolution($resolution->getIdClientResolution());
    		$assignment->setResolutionDate($dateLog ?: $now->get('yyyy-MM-dd HH:mm:ss'));
    		$assignment->setNote($note);
    		$assignment->setRecoveryAmount($recoveryAmount); 
    		$assignment->setIsRecoveredAmount($isRecoveredAmount);
    		if ($file)
    			$assignment->setIdFile($file->getIdFile());
    		$this->getAssignmentCatalog()->update($assignment);
    		if($dateLog == null){
    			$dateLog = $now->get('yyyy-MM-dd HH:mm:ss');
    		}
    		$this->getTicketMachine()->handle($ticket, Condition::RESOLVE, array(
    				'user' => $user,
    				'date_log' => $dateLog,
    		));
    		$event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_RESOLVE : EmailEvent::TICKET_RESOLVE;
    		$this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
    				'ticket' => $ticket,
    				'user' =>  $user,
    		)));
    		$this->getTicketCatalog()->commit();
    	}
    	catch (Exception $e) {
    		$this->getTicketCatalog()->rollBack();
    		throw $e;    		
    	}
    }
    
    public function updateIdResolucionFile($idFile,$idBaseTicket){
		$update = "UPDATE  pcs_symphony_assignments SET id_resolution_file = '".$idFile."' where id_base_ticket = '".$idBaseTicket."'";
    	$this->getAssignmentCatalog()->getDb()->query($update);
        }
    
    
    public function updateEmail($params){
    	try{
    		if((int) $params['id_ticket_client'] > 0 && trim($params['emailClient']) !=""){
    			$ticketClient = TicketClientQuery::create()->findByPK($params['id_ticket_client']);
    			$this->getTicketClientCatalog()->beginTransaction(); 
    			$ticketClient->setEmail(trim($params['emailClient']));
    			$this->getTicketClientCatalog()->update($ticketClient); 
    			$this->getTicketClientCatalog()->commit();    
    		}
    	}
    	catch(Exception $e){
    		$this->getTicketClientCatalog()->rollBack();
    		die($e->getMessage());
    	}
    }
    
    
    public function getEmailUser(){
    	try{    		
    		$group = GroupQuery::create()->whereAdd(Group::ACL,1)->findOne();
    		if ($group != null){
    			$user = UserQuery::create()->findByPK($group->getIdUser());
    			if($user != null){
    				$idPerson = PersonQuery::create()->innerJoinEmail()
    						  ->addColumn("Person2Email."."id_email")
    						  ->whereAdd("Person.".Person::ID_PERSON, $user->getIdPerson())->fetchOne();
    				if((int) $idPerson > 0){
    					$emails = EmailQuery::create()->findByPK($idPerson);
    					return $emails->getEmail();
    				}
    			}				
    		}
    	}catch(Exception $e){
    		return "";
    	}
    	return "";
    }

    public function getEmailUserLogueado(User $user){
    	try{   			
			if($user != null){
    				$idPerson = PersonQuery::create()->innerJoinEmail()
    				->addColumn("Person2Email."."id_email")
    				->whereAdd("Person.".Person::ID_PERSON, $user->getIdPerson())->fetchOne();
    				if((int) $idPerson > 0){
    					$emails = EmailQuery::create()->findByPK($idPerson);
    					return $emails->getEmail();
    				}
    			}
    	}catch(Exception $e){
    		return "";
    	}
    	return "";
    }
    
    /**
     * 
     */
    private function saveResolutionFile(){
    	
    }
    
    public function updateTicket(TicketClient $ticket){
    	try{
    			
    		$now = new \Zend_Date();
    		$hoy = $now->get('yyyy-MM-dd HH:mm:ss');
    		$ticketTmp = TicketClientQuery::create()->findByPKOrThrow($ticket->getIdTicketClient(), 'id');
    		$this->getTicketClientCatalog()->beginTransaction();
    		$cambios  = 0;
    		if( ($ticket->getIdTicketType() == TicketType::$TicketType['Aclaración']) || ($ticket->getIdTicketType() == TicketType::$TicketType['Queja']) ){
    			if( (int) $ticket->getIdBaseTicket() > 0){
    				$ticketTmp->setCreated($now->get('yyyy-MM-dd HH:mm:ss'));
    				$ticketTmp->setScheduledDate($now->get('yyyy-MM-dd HH:mm:ss'));
	    			$this->getTicketClientCatalog()->update($ticketTmp);
    				$this->getTicketClientCatalog()->commit();
    			}
    		}
    		return $ticketTmp;
    	}
    	catch(Excception $e){
    		$this->getTicketClientCatalog()->rollBack();
    		return null;
    	}
    }
    
    public function getUpdatedateLogs($ticketClient){
    	$now = new \Zend_Date();    	
    	$ticketLogs = TicketLogQuery::create()->whereAdd(TicketLog::ID_BASE_TICKET, $ticketClient->getIdBaseTicket())->fetchAll();
    	if(count($ticketLogs) > 0){
    		try{
	    		$this->getTicketLogCatalog()->beginTransaction();    		
	    		foreach($ticketLogs as $ticketLog){
	    			$log = TicketLogQuery::create()->findByPKOrThrow($ticketLog['id_ticket_log'], "No especifica la llave primaria");
	    			$log->setDateLog($now->get('yyyy-MM-dd HH:mm:ss'));
	   				$this->getTicketLogCatalog()->update($log);    			
	    		}
	    		$this->getTicketLogCatalog()->commit();
    		}
    		catch(Exception $e){
    			$this->getTicketLogCatalog()->rollback();
    		}    		
    	}    	
    }
    
    public function expirationDateTicket(TicketClient $ticket, $expirationDate, $idUser){
		try{
			
			$date = new \DateTime($expirationDate);
			$date2 =  date_create($expirationDate);
			$now = new \Zend_Date();
			$hoy = $now->get('yyyy-MM-dd HH:mm:ss');
			$ticketTmp = TicketClientQuery::create()->findByPKOrThrow($ticket->getIdTicketClient(), 'id');
			$this->getTicketClientCatalog()->beginTransaction();
			$cambios  = 0;
			if(trim($expirationDate) != ''){							
				$ticketTmp->setExpirationDate($date->format('Y-m-d H:i:s'));
				$cambios = 1;
			}
			if( ($ticket->getIdTicketType() == TicketType::$TicketType['Aclaración']) || ($ticket->getIdTicketType() == TicketType::$TicketType['Queja']) ){ 
				if( (int) $idUser > 0){
					$ticketTmp->setIdResolver($idUser);
					$cambios = 1;
				}		
				if( (int) $ticket->getIdBaseTicket() > 0){
					$ticketTmp->setCreated($now->get('yyyy-MM-dd HH:mm:ss'));
					$ticketTmp->setScheduledDate($now->get('yyyy-MM-dd HH:mm:ss'));
					$cambios = 1;
				}
			}			
			if($cambios){
				$this->getTicketClientCatalog()->update($ticketTmp);
				$this->getTicketClientCatalog()->commit();
			}
					
		}
		catch(Excception $e){
			$this->getTicketClientCatalog()->rollBack();
			die("Error:   ".$e->getMessage());
		}
    }

    public function expirationDate(TicketClient $ticket, $expirationDate){
    	try{    			
    		$date = new \DateTime($expirationDate);
    		$ticketTmp = TicketClientQuery::create()->findByPKOrThrow($ticket->getIdTicketClient(), 'id');
    		$this->getTicketClientCatalog()->beginTransaction();
    		$cambios  = 0;
    		if(trim($expirationDate) != ''){
    			$ticketTmp->setExpirationDate($date->format('Y-m-d H:i:s'));
    			$this->getTicketClientCatalog()->update($ticketTmp);
    			$this->getTicketClientCatalog()->commit();
    		}    			
    	}
    	catch(Excception $e){
    		$this->getTicketClientCatalog()->rollBack();
    		die("Error:   ".$e->getMessage());
    	}
    }
    
    /**
     * @param BaseTicket $ticket
     * @param User $userAssigned
     * @param array $params
     */
    public function assign(BaseTicket $ticket, User $userAssigned, User $userResponsible)
    {
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            if( in_array($ticket->getStatusName(), array('Assigned', 'Working')) ){
                $assignment = $this->findAssignment($ticket->getIdAssignment());
                $assignment->setIdUser($userAssigned->getIdUser());
                $this->getAssignmentCatalog()->update($assignment);
                $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_REASSIGN : EmailEvent::TICKET_REASSIGN;
                $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                    'ticket' => $ticket,
                    'user' =>  $userResponsible,
                )));
            }
            else{
            	$event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_ASSIGN : EmailEvent::TICKET_ASSIGN;
            	
                $assignment = $this->createNewAssignment($ticket, $userAssigned, $userResponsible);
                $this->getTicketMachine()->handle($ticket, Condition::ASSIGN, array('user' => $userResponsible));

                $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                    'ticket' => $ticket,
                    'user' =>  $userResponsible,
                )));
            }
            $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }

    public function updateLastAssign(BaseTicket $ticket,$idUser){
    	$query = "";    	
    	try
    	{
    		$this->getTicketClientCatalog()->beginTransaction();
    		$query = "UPDATE pcs_symphony_tickets_clients SET id_user_last_assign = '".$idUser."' 
    				WHERE id_ticket_client = '".$ticket->getIdTicketClient()."';";
    		$this->getTicketClientCatalog()->getDb()->query($query);
    		$this->getTicketClientCatalog()->commit();
    	}
    	catch (\Exception $e) {
    		$this->getTicketClientCatalog()->rollBack();
    		throw $e;
    	}
    	 
    	
    	
    }
    /**
     *
     * @param BaseTicket $ticket
     * @param User $user
     * @throws TicketException
     * @throws Exception
     */
    public function pause(BaseTicket $ticket, User $user)
    {
        if( $ticket->getIsStopped() ){
            throw new TicketException("The Ticket is already paused");
        }
        $now = new \Zend_Date();
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $ticket->setIsStopped(1);
            if ($ticket instanceof Ticket)
            	$this->getTicketCatalog()->update($ticket);
            else 
            	$this->getTicketClientCatalog()->update($ticket);

            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Pause'],
                'changed_from' => 0,
                'changed_to' => 0,
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);

            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_PAUSE : EmailEvent::TICKET_PAUSE;
            
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));

            $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }

    /**
     *
     * @param BaseTicket $ticket
     * @param User $user
     * @throws TicketException
     * @throws Exception
     */
    public function resume(BaseTicket $ticket, User $user)
    {
        if( !$ticket->getIsStopped() ){
            throw new TicketException("The Ticket is already resumed");
        }

        $now = new \Zend_Date();
        try
        {
            $this->getTicketCatalog()->beginTransaction();

            $ticket->setIsStopped(0);
             if ($ticket instanceof Ticket)
            	$this->getTicketCatalog()->update($ticket);
            else 
            	$this->getTicketClientCatalog()->update($ticket);

            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Resume'],
                'changed_from' => 0,
                'changed_to' => 0,
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);

            $event = $ticket instanceof TicketClient ? EmailEvent::TICKET_CLIENT_RESUME : EmailEvent::TICKET_RESUME;
            
            $this->getEventDispatcher()->dispatch($event, new EmailEvent(array(
                'ticket' => $ticket,
                'user' =>  $user,
            )));

            $this->getTicketCatalog()->commit();
        }
        catch (\Exception $e) {
            $this->getTicketCatalog()->rollBack();
            throw $e;
        }
    }

    public function updateUserTicket(TicketClient $ticket,$idUserResolved){
    	$this->getTicketClientCatalog()->beginTransaction();
    	try{
    		$upd = "UPDATE pcs_symphony_base_tickets SET id_user = '".$idUserResolved."' WHERE id_base_ticket = '".$ticket->getIdBaseTicket()."';";
    		$this->getTicketClientCatalog()->getDb()->query($upd);
    		$this->getTicketClientCatalog()->commit();
    	}catch(Exception $e){
    		$this->getTicketClientCatalog()->rollBack();
    	}
    }
    
    public function updateStatusAssigment($idAssignment){
    	try{
	    	$assignment = AssignmentQuery::create()->findByPK($idAssignment);
	    	$this->getAssignmentCatalog()->beginTransaction();
	    	$assignment->setStatus(0);
	    	$this->getAssignmentCatalog()->update($assignment);
	    	$this->getAssignmentCatalog()->commit();
    	}catch(Exception $e){
    		$this->getAssignmentCatalog()->rollBack();
    	}
    }

    /**
     *
     * @param BaseTicket $ticket
     * @param User $userAssigned
     * @param User $userResponsible
     * @return Assignment
     */
    private function createNewAssignment(BaseTicket $ticket, User $userAssigned, User $userResponsible)
    {
        $now = new \Zend_Date();
        $oldAssignment = $ticket->getIdAssignment();
        $assignment = AssignmentFactory::createFromArray(array(
            'id_base_ticket' => $ticket->getIdBaseTicket(),
            'id_user' => $userAssigned->getIdUser(),
        	'status' => 1,
            'assignment_date' => $now->get('yyyy-MM-dd HH:mm:ss'),
        ));
        $this->getAssignmentCatalog()->create($assignment);

        $ticket->setIdAssignment($assignment->getIdAssignment());
       if ($ticket instanceof Ticket)
            	$this->getTicketCatalog()->update($ticket);
            else 
            	$this->getTicketClientCatalog()->update($ticket);

        $newAssignment = $ticket->getIdAssignment();

        if( $oldAssignment != $newAssignment ){

            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $userResponsible->getIdUser(),
                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Assign'],
                'changed_from' => (int) $oldAssignment,
                'changed_to' => (int) $newAssignment,
                'note' => '',
            ));
            $this->getTicketLogCatalog()->create($ticketLog);
        }

        if( $oldAssignment == 0 ){
        	if( !in_array($ticket->getStatusName(), array('Reopen')) ){
            	$ticketLog = TicketLogFactory::createFromArray(array(
	                'id_base_ticket' => $ticket->getIdBaseTicket(),
	                'id_user' => $userResponsible->getIdUser(),
	                'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
	                'event_type' => TicketLog::$EventTypes['Response_End_Time'],
	                'changed_from' => 0,
	                'changed_to' => 0,
	                'note' => '',
	            ));
	            $this->getTicketLogCatalog()->create($ticketLog);
    	        $ticketLog->setIdTicketLog(null);
            	$ticketLog->setEventType(TicketLog::$EventTypes['Resolution_Start_Time']);
            	$this->getTicketLogCatalog()->create($ticketLog);
        	}
        }

        return $assignment;
    }

    /**
     *
     * @param unknown_type $params
     * @param Ticekt $ticket
     */
    private function validateUpdate($params, BaseTicket $ticket)
    {
        if( isset($params['scheduled_date']) && !empty($params['scheduled_date']) ){
            if( substr($ticket->getScheduledDate(), 0, 16) != $params['scheduled_date'] ){
                $this->validateDate($params['scheduled_date']);
            }
        }
    }

    /**
     *
     * @param unknown_type $params
     */
    private function validate($params)
    {
        if( isset($params['scheduled_date']) && !empty($params['scheduled_date']) ){
            $this->validateDate($params['scheduled_date']);
        }
    }

    /**
     *
     * @param string $date
     * @throws TicketException
     */
    private function validateDate($date)
    {
        if( !\Zend_Date::isDate($date, 'yyyy-MM-dd HH:mm') ){
            throw new TicketException("The date is invalid ". $params['scheduled_date']);
        }
        $scheduledDate = new \Zend_Date($date, 'yyyy-MM-dd HH:mm');
        $now = new \Zend_Date();
        $now->subMinute(10);
        if( $scheduledDate->isEarlier($now->get('yyyy-MM-dd HH:mm'), 'yyyy-MM-dd HH:mm') ){
            throw new TicketException("The date is invalid ". $date .", the date can not be earlier than ".$now->get('yyyy-MM-dd HH:mm'));
        }
    }

    /**
     *
     * @param int $id
     * @return Assignment
     */
    private function findAssignment($id){
        return AssignmentQuery::create()
            ->findByPKOrThrow($id, "The Assignment not exists");
    }

    /**
     * @param TicketLogCatalog $fileCatalog
     */
    public function setEmailCatalog(EmailCatalog $emailCatalog){
    	$this->emailCatalog = $emailCatalog;
    }
    
    
    /**
     * @return \Application\Model\Catalog\EmailCatalog
     */
    public function getEmailCatalog(){
    	return $this->emailCatalog;
    }
    
    /**
     * @param TicketCatalog $ticketCatalog
     */
    public function setTicketCatalog(TicketCatalog $ticketCatalog){
        $this->ticketCatalog = $ticketCatalog;
    }

    /**
     * @return \Application\Model\Catalog\TicketCatalog
     */
    public function getTicketCatalog(){
        return $this->ticketCatalog;
    }
    
    /**
     * @param TicketCatalog $ticketCatalog
     */
    public function setTicketClientCatalog(TicketClientCatalog $ticketClientCatalog){
    	$this->ticketClientCatalog = $ticketClientCatalog;
    }
    /**
     * @return \Application\Model\Catalog\TicketClientCatalog
     */
    public function getTicketClientCatalog(){
    	return $this->ticketClientCatalog;
    }
    /**
     * @param TicketLogCatalog $ticketCatalog
     */
    public function setTicketLogCatalog(TicketLogCatalog $ticketLogCatalog){
        $this->ticketLogCatalog = $ticketLogCatalog;
    }

    /**
     * @return \Application\Model\Catalog\TicketLogCatalog
     */
    public function getTicketLogCatalog(){
        return $this->ticketLogCatalog;
    }

    /**
     * @param TicketLogCatalog $fileCatalog
     */
    public function setFileCatalog(FileCatalog $fileCatalog){
    	$this->fileCatalog = $fileCatalog;
    }
    
    
    /**
     * @return \Application\Model\Catalog\FileCatalog
     */    
    public function getFileCatalog(){
    	return $this->fileCatalog;
    }
    
    /**
     * @param TransactionsPartialitiesCatalog $transactionsPartialitiesCatalog
     */
    public function setTransactionsPartialitiesCatalog(TransactionsPartialitiesCatalog $transactionsPartialitiesCatalog){
    	$this->transactionsPartialitiesCatalog = $transactionsPartialitiesCatalog;
    }
    
    
    /**
     * @return \Application\Model\Catalog\TransactionsPartialitiesCatalog
     */
    public function getTransactionsPartialitiesCatalog(){
    	return $this->transactionsPartialitiesCatalog;
    }
    
    
    
    /**
     * @param TicketsClientsTransactionsCatalog $ticketsClientsTransactionsCatalog
     */
    public function setTicketsClientsTransactionsCatalog(TicketsClientsTransactionsCatalog $ticketsClientsTransactionsCatalog){
    	$this->ticketsClientsTransactionsCatalog = $ticketsClientsTransactionsCatalog;
    }
    
    
    /**
     * @return \Application\Model\Catalog\TicketsClientsTransactionsCatalog
     */
    public function getTicketsClientsTransactionsCatalog(){
    	return $this->ticketsClientsTransactionsCatalog;
    }
    
    /**
     * @param Application\Automata\TicketAutomata $ticketAutomata
     */
    public function setTicketAutomata(TicketAutomata $ticketAutomata){
        $this->ticketAutomata = $ticketAutomata;
    }

    /**
     * @return \Application\Automata\TicketAutomata
     */
    public function getTicketAutomata(){
        return $this->ticketAutomata;
    }

    /**
     *
     * @return \Automatic\Machine
     */
    public function getTicketMachine(){
        return $this->getTicketAutomata()->getMachine();
    }

    /**
     * @param AssignmentCatalog $assignmentCatalog
     */
    public function setAssignmentCatalog(AssignmentCatalog $assignmentCatalog){
        $this->assignmentCatalog = $assignmentCatalog;
    }

    /**
     * @return \Application\Model\Catalog\AssignmentCatalog
     */
    public function getAssignmentCatalog(){
        return $this->assignmentCatalog;
    }
    
    /**
     * 
     * @param AttachmentCatalog $attachmentCatalog
     */
    public function setAttachmentCatalog(AttachmentCatalog $attachmentCatalog){
    	$this->attachmentCatalog = $attachmentCatalog;
    }
    /**
     * @return \Application\Model\Catalog\AttachmentCatalog
     */
    public function getAttachmentCatalog(){
    	return $this->attachmentCatalog;
    }
    
    
    protected function generateFolioPrevio(){
    	$folio = 1;
    	$arrayFolioPrev = TicketClientQuery::create()->addColumn(TicketClient::FOLIO_PREV)->page(1,1)->orderBy(TicketClient::FOLIO_PREV,' DESC')->fetchCol();
    	if ( $arrayFolioPrev['0'] != null && !empty($arrayFolioPrev['0']) ){    		
    		$folio = (int) substr($arrayFolioPrev['0'],1,12) + 1;
		}
		return  "P".str_pad($folio,10,'0',STR_PAD_LEFT); 
    }
    
    /**
     * Generates the folio for Ticket Client
     * @param int $id
     * @return string
     */
	protected function generateFolio($id){
		$folio = '';
		$length = 9;
		$spaces = $length - strlen($id);
		for ($i = 0; $i<$spaces; $i++){
			$folio .= '0';
		}
		$folio .= $id;
		return $folio;
	}
}
