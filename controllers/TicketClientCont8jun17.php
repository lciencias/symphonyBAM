<?php
use Application\Controller\CrudController;
use Application\Event\EmailEvent;
use Application\Excel\SimpleListReport;
use Application\File\FileUploader;
use Application\Manager\FixManager;
use Application\Model\Bean\AccessRole;
use Application\Model\Bean\Activity;
use Application\Model\Bean\Assignment;
use Application\Model\Bean\Attachment;
use Application\Model\Bean\Branch;
use Application\Model\Bean\Channel;
use Application\Model\Bean\ClientAccount;
use Application\Model\Bean\ClientCategoriesProducts;
use Application\Model\Bean\ClientCategory;
use Application\Model\Bean\ClientCategoryResolution;
use Application\Model\Bean\ClientData;
use Application\Model\Bean\ClientResolution;
use Application\Model\Bean\Comments;
use Application\Model\Bean\Document;
use Application\Model\Bean\Field;
use Application\Model\Bean\File;
use Application\Model\Bean\FileTmp;
use Application\Model\Bean\Group;
use Application\Model\Bean\Notification;
use Application\Model\Bean\Option;
use Application\Model\Bean\Products;
use Application\Model\Bean\RequiredDocument;
use Application\Model\Bean\RequiredField;
use Application\Model\Bean\Resolution;
use Application\Model\Bean\TemplateEmail;
use Application\Model\Bean\TicketClient;
use Application\Model\Bean\TicketClientDocument;
use Application\Model\Bean\TicketClientField;
use Application\Model\Bean\TicketLog;
use Application\Model\Bean\TicketsClientsTransactions;
use Application\Model\Bean\TicketType;
use Application\Model\Bean\TransactionsPartialities;
use Application\Model\Bean\User;
use Application\Model\Catalog\CommentsCatalog;
use Application\Model\Catalog\SecurityActionCatalog;
use Application\Model\Catalog\TicketLogCatalog;
use Application\Model\Catalog\TicketsClientsTransactionsCatalog;
use Application\Model\Collection\ClientAccountCollection;
use Application\Model\Collection\ClientDataCollection;
use Application\Model\Collection\ProdCollection;
use Application\Model\Collection\TransactionsCollection;
use Application\Model\Factory\CommentsFactory;
use Application\Model\Factory\FileFactory;
use Application\Model\Factory\NotificationFactory;
use Application\Model\Factory\TicketLogFactory;
use Application\Query\ActivityQuery;
use Application\Query\AssignmentQuery;
use Application\Query\BranchQuery;
use Application\Query\CategoryQuery;
use Application\Query\ChannelQuery;
use Application\Query\ClientCategoryQuery;
use Application\Query\ClientCategoryResolutionQuery;
use Application\Query\ClientResolutionQuery;
use Application\Query\CommentsQuery;
use Application\Query\ControversyReasonsQuery;
use Application\Query\FieldQuery;
use Application\Query\FileQuery;
use Application\Query\FileTmpQuery;
use Application\Query\GroupQuery;
use Application\Query\OptionQuery;
use Application\Query\ProductsQuery;
use Application\Query\RequiredDocumentQuery;
use Application\Query\RequiredFieldQuery;
use Application\Query\ResolutionQuery;
use Application\Query\ServiceLevelQuery;
use Application\Query\TemplateEmailQuery;
use Application\Query\TicketClientDocumentQuery;
use Application\Query\TicketClientFieldQuery;
use Application\Query\TicketClientQuery;
use Application\Query\TicketLogQuery;
use Application\Query\TicketsClientsTransactionsQuery;
use Application\Query\TicketTypeQuery;
use Application\Query\UserQuery;
use Application\Webservice\WSClient;
use EasyCSV\Exception;
use Application\Model\Bean\TicketsClientsReopen;
use Application\Model\Bean\Ticket;

require_once 'dompdf/dompdf_config.inc.php';



final class TicketClientController extends CrudController{
	/**
	 *
	 */
	private $uploadPath = 'tickets-clients';

	/**
     * @module Ticket Client
     * @action New
	 */
	
	public function newAction(){
		
		$sinEstatus = 0;
		$nestedCategories = $times = array();
		$header  = $this->i18n->_('Select');
		$scripts = array('modules/ticket-client/new.js');
		$page    = $this->getRequest()->getParam('page') ?: 1;
		$params  = $this->getRequest()->getParams();
		$noParams= $this->countParams($params);
		if($params['id_ticket_type'] == '')
			$params['id_ticket_type_sin'] = 3;
		
		if($this->permissions($this->getUser()->getBean()->getIdAccessRole(),'view-all-tickets') == 0){			
			if( (int) $params['findBD'] == 0){
				$params ['id_user'] = $this->getUser()->getBean()->getIdUser();
			}
			if(trim($params ['status'] ) == ''){
				$sinEstatus = 1;
			}				
		}
		else{
			if(trim($params ['status'] ) == ''){
				$sinEstatus = 1;				
			}				
		}
		
		
		if(trim($params ['status']) == ''){
			if((int)$params['findBD'] == 1 ){
				$params ['status'] = "";
			}				
		}
		if(trim($params ['type']) == ''){		
			if((int)$params['findBD'] == 1){
				$params ['type'] = "";
			}
		}		
		$campoOrdernado = array();
		if(trim($params['head']) != ''){
			$campoOrdernado = $this->getField($params['head'], $params['orden']);
		}
		
		
		if($this->permissions($this->getUser()->getBean()->getIdAccessRole(),'view-all-tickets') == 0){			
			if((int)$noParams == 0){
				$params ['status'] = TicketType::$states;
			}
			$totalObj   = TicketClientQuery::create()->filter($params)->find();
			$tickets = 	TicketClientQuery::create()->filter($params);
			if(count($campoOrdernado) > 0){
				$tickets =$tickets->orderBy($campoOrdernado[0],$campoOrdernado[1]);
			}		
			
			if(trim($params['head']) != 'Tstatus'){
				$tickets =$tickets->orderBy(TicketClient::STATUS,TicketClientQuery::ASC);
			}			
			if(trim($params['head']) != 'Texpiration'){
				$tickets =$tickets->orderBy(TicketClient::EXPIRATION_DATE,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Tdassign'){
				$tickets =$tickets->orderBy(TicketClient::CREATED,TicketClientQuery::ASC);
			}
			$tickets =$tickets->page($page, $this->getMaxPerPage())->find();
			
		}else{						
			$assignments = AssignmentQuery::create()->whereAdd(Assignment::ID_USER, $this->getUser()->getBean()->getIdUser())->fetchIds();
			$totalObj = TicketClientQuery::create()->filter($params)
					->where()->setOR()					
					->Add(TicketClient::STATUS,5);
					//->Add(TicketClient::COMPLAINT,0,'>=');
			if( (int) $params['findBD'] == 0){
				$totalObj = $totalObj->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
							->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser());
			}
			/*if(count($assignments) > 0){
					$totalObj = $totalObj->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}*/			
			$totalObj = $totalObj->endWhere();
			$totalObj = $totalObj->where()->setAND()
			->Add(TicketClient::STATUS,3);
			//->Add(TicketClient::COMPLAINT,0,'>=');
			if( (int) $params['findBD'] == 0){
				$totalObj = $totalObj->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
				->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser());
			}
				
			/*if(count($assignments) > 0){
				$totalObj = $totalObj->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}*/				
			$totalObj = $totalObj->endWhere()->find();

			$tickets = 	TicketClientQuery::create()->filter($params)
				->where()->setOR()
				->Add(TicketClient::STATUS, 5);
				//->Add(TicketClient::COMPLAINT,0,' >= ');
				if( (int) $params['findBD'] == 0){
					$tickets = $tickets->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
					->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser());
				}				
			/*if(count($assignments) > 0){
					$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}*/
			$tickets = $tickets->endWhere();
			$tickets = $tickets->where()->setAND()
				->Add(TicketClient::STATUS,3);
				//->Add(TicketClient::COMPLAINT,0, ' >= ');
			if( (int) $params['findBD'] == 0){
				$tickets = $tickets->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
				->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser());
			}				
			/*if(count($assignments) > 0){
				$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}*/								
			$tickets = $tickets->endWhere();
			if(count($campoOrdernado) > 0){
				$tickets =$tickets->orderBy($campoOrdernado[0],$campoOrdernado[1]);
			}				
			if(trim($params['head']) != 'Tstatus'){
				$tickets =$tickets->orderBy(TicketClient::STATUS,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Texpiration'){
				$tickets =$tickets->orderBy(TicketClient::EXPIRATION_DATE,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Tdassign'){
				$tickets =$tickets->orderBy(TicketClient::CREATED,TicketClientQuery::ASC);
			}
			$tickets =$tickets->page($page, $this->getMaxPerPage())->find();
				
		}
		$total = count($totalObj);		
		$this->view->tickets = $arrayTicket = $tickets->toArrayForList();		
		$this->view->paginator = $this->createPaginator($total, $page);
		$this->view->tAmounts  = $this->getTicketService()->getAmount($arrayTicket);
		//$this->view->tTimes    = $this->getResponseTicketTime($tickets);
		$this->view->color     = $this->getHours($tickets);
		$this->view->scripts   = $scripts;
		$ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo();
		foreach ($ticketTypes as $idTicketType => $ticketType){
			$categories = ClientCategoryQuery::create()->whereAdd(ClientCategory::ID_TICKET_TYPE, $idTicketType)->actives()->find();
			$nestedCategories[$idTicketType] = $categories->filterRoot()->toNestedArray($categories);
		}
		
		$this->view->nestedCategories = $nestedCategories;
		$this->view->clientCategories = ClientCategoryQuery::create()->actives()->isLeaf()->find()->toCombo($header);
		$this->view->ticketTypes 	  = TicketTypeQuery::create()->actives()->orderBy(TicketType::NAME)->find()->toCombo($header);
		$this->view->ticketTypesJurid = TicketTypeQuery::create()->whereAdd(TicketType::ID_TICKET_TYPE,2,' != ')->actives()->orderBy(TicketType::NAME)->find()->toCombo($header);
		$this->view->channels   	  = ChannelQuery::create()->actives()->find()->toCombo($header);
		$this->view->branches   	  = BranchQuery::create()->actives()->find()->toCombo($header);
		$this->view->statuses   	  = $this->getStatusCombo($header);
		$this->view->periods    	  = array_flip(TicketClient::$periods);
		$this->view->reasons    	  = ClientCategoryQuery::create()->actives()->find()->toComboConcat($header);
		$this->view->reasonsC    	  = ClientCategoryQuery::create()->actives()->find()->toCombo($header);
		$this->view->products   	  = ProductsQuery::create()->actives()->find()->toCombo($header);
		$this->view->canalUser  	  = (int) $this->getUser()->getBean()->getIdChannel();
		$this->view->branchUser 	  = (int) $this->getUser()->getBean()->getIdBranch();
		$this->view->users      	  = UserQuery::create()->actives()->find()->toCombo($header);
		if($sinEstatus){
			$params ['status'] = $params ['type'] = '';
		}
		$this->view->params 		  = $params;
		$this->view->page             = $page;           
 		$this->view->onsubmit 		  = 'create';
 		
	}
	
	
	/**
     * @module Ticket Client
     * @action List
	 */
	public function indexAction(){
		$this->_redirect('ticket-client/list');

	}
	/**
     * @module Ticket Client
     * @action List
	 */
	public function listAction(){
		$scripts = array('modules/ticket-client/list.js');
		$this->view->scripts = $scripts;
		$header = $this->i18n->_('All');
		$this->view->params = $params = $this->getRequest()->getParams();
		$total = TicketClientQuery::create()
		->filter($params)
		->addGroupBy("TicketClient.".TicketClient::ID_TICKET_CLIENT)
		->orderBy("TicketClient.".TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->count();
		$page = $this->getRequest()->getParam('page', 1);
		$this->view->clientCategories = ClientCategoryQuery::create()->actives()->isLeaf()->find()->toCombo($header);
		$this->view->ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo($header);
		$this->view->channels = ChannelQuery::create()->actives()->find()->toCombo($header);
		$this->view->branches = BranchQuery::create()->actives()->find()->toCombo($header);
		$this->view->users = UserQuery::create()->actives()->find()->toCombo($header);
		$this->view->statuses = $this->getStatusCombo($header);
		$this->view->tickets = $tickets = TicketClientQuery::create()->filter($params)
		->orderBy(TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->page($page, $this->getMaxPerPage())
		->find()
		->toArrayForList();
		$this->view->tAmounts  = $xx = $this->getTicketService()->getAmount($tickets);
		$this->view->paginator = $this->createPaginator($total, $page);
	}
	/**
	 * @module Ticket Client
	 * @action List By Group
	 */
	public function listByGroupAction(){
		$scripts = array('modules/ticket-client/list.js');
		$this->view->scripts = $scripts;
		$header = $this->i18n->_('All');
		$this->view->params = $params = $this->getRequest()->getParams();
		$groups = UserQuery::create()->innerJoinGroup()->addColumn('Group.id_group')
		->whereAdd('User.'.User::ID_USER, $this->getUser()->getBean()->getIdUser())
		->fetchCol();
		$clientCategory = ClientCategoryQuery::create()->whereAdd(ClientCategory::ID_GROUP, $groups)
		->find();
		$total = TicketClientQuery::create()
		->filter($params)
		->whereAdd(TicketClient::ID_CLIENT_CATEGORY, $clientCategory->getPrimaryKeys())
		->addGroupBy("TicketClient.".TicketClient::ID_TICKET_CLIENT)
		->orderBy(TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->count();
		$page = $this->getRequest()->getParam('page', 1);
		$this->view->clientCategories = ClientCategoryQuery::create()
		->actives()
		->isLeaf()
		->whereAdd(ClientCategory::ID_GROUP, $groups)
		->find()
		->toCombo($header);
		$this->view->ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo($header);
		$this->view->channels = ChannelQuery::create()->actives()->find()->toCombo($header);
		$this->view->branches = BranchQuery::create()->actives()->find()->toCombo($header);
		$this->view->users = UserQuery::create()->actives()->find()->toCombo($header);
		$this->view->statuses = $this->getStatusCombo($header);
		$this->view->tickets = $tickets = TicketClientQuery::create()
		->filter($params)
		->whereAdd(TicketClient::ID_CLIENT_CATEGORY, $clientCategory->getPrimaryKeys())
		->orderBy(TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->page($page, $this->getMaxPerPage())
		->find()
		->toArrayForList();
		$this->view->tAmounts  = $xx = $this->getTicketService()->getAmount($tickets);
		$this->view->paginator = $this->createPaginator($total, $page);
		$this->view->setTpl('List');
	}
	private function getStatusCombo($header){
		$statuses = TicketClient::getStatusCombo($header);
		foreach ($statuses as $key => $status){
			$combo[$key] = $this->i18n->_($status); 
		}
		return $combo;
	}
	/**
     * @module Ticket Client
     * @action My Tickets
	 */
	public function myTicketsAction(){
		$header = $this->i18n->_('All');
		$params = $this->getRequest()->getParams();
		$noParams=$this->countParamsAclaracion($params);		
		$scripts = array('modules/ticket-client/new.js');
		if($params['id_ticket_type'] == ''){
			$params['id_ticket_type_sin'] = 3;
		}
		if((int)$noParams == 0){
			$params ['status'] = TicketType::$states;
		}
		$this->view->params = $params;		
		$this->view->clientCategories = ClientCategoryQuery::create()->actives()->isLeaf()->find()->toCombo($header);
		$this->view->ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo($header);
		$this->view->channels = ChannelQuery::create()->actives()->find()->toCombo($header);
		$this->view->branches = BranchQuery::create()->actives()->find()->toCombo($header);
		$this->view->users = UserQuery::create()->actives()->find()->toCombo($header);
		$this->view->statuses = $this->getStatusCombo($header);
		$page = $this->getRequest()->getParam('page', 1);
		
		$assignments = AssignmentQuery::create()->whereAdd(Assignment::ID_USER, $this->getUser()->getBean()->getIdUser())->fetchIds();
		
		$total = TicketClientQuery::create()->filter($params)
		->addGroupBy("TicketClient.".TicketClient::ID_TICKET_CLIENT)
		->where()->setOR()
			->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN)
			->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser())
		->endWhere()		
		->count();
		
		
		$ticket = TicketClientQuery::create()
		->filter($params)
		->where()->setOR()
			->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN)
			->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser())
		->endWhere()
		->orderBy(TicketClient::STATUS,TicketClientQuery::DESC)
		->orderBy(TicketClient::EXPIRATION_DATE,TicketClientQuery::ASC)
		//->orderBy(TicketClient::CREATED,TicketClientQuery::ASC)		
		->orderBy(TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->find();
		
		
		$this->view->products  = ProductsQuery::create()->actives()->find()->toCombo();
		$this->view->tickets   = $ticket->toArrayForList();
		$this->view->tAmounts  = $this->getTicketService()->getAmount($ticket->toArray());
		$this->view->paginator = $this->createPaginator($total, $page);
		$this->view->scripts   = $scripts;
		$params ['status'] = '';
		$this->view->params = $params;
		$this->view->setTpl('List');
	}
	/**
     * @module Ticket Client
     * @action Delete
	 */
	public function deleteAction(){
	}
	/**
     * @module Ticket Client
     * @action Edit
	 */
	public function editAction(){
		$header  = $this->i18n->_('Select');
		$this->view->setTpl('New');
		$this->view->action = $this->getRequest()->getParam('action');
		$id = $this->getRequest()->getParam('id');		
		$flagGoodFaith = true;
		$flagFolioGoodFaith = true;
		$flagsGoodArray= array();
		$flagsGoodFolioArray = array();
		try{
			$scripts = array('modules/ticket-client/new.js');
			$this->view->scripts = $scripts;
			$ticketClient  = TicketClientQuery::create()->findByPK($id);
            $query_created = "SELECT convert(varchar,created, 103) as date_created FROM pcs_symphony_base_tickets WHERE id_base_ticket=".$ticketClient->getIdBaseTicket();
		    $date_created=$this->getTicketClientFieldCatalog()->getDb()->fetchAll($query_created);
			
			
            $clientCategory    = ClientCategoryQuery::create()->findByPK($ticketClient->getIdClientCategory());
			$ticketClientArray = $ticketClient->toArrayForList();
            $comments=  CommentsQuery::create()->whereAdd(Comments::ID_BASE_TICKET, $ticketClientArray['id_base_ticket'])->orderBy(Comments::ID_COMMENT, CommentsQuery::DESC)->findOne();
            $loggedInUser = $this->getUser()->getBean();
            if(!$comments){
            	// si el usuario logueado es igual al que est� asigando
                if($loggedInUser->getIdUser()==$ticketClientArray['id_user']){
                	$idUserAssign = AssignmentQuery::create()->whereAdd(Assignment::ID_BASE_TICKET, $ticketClientArray['id_base_ticket'])->orderBy(Assignment::ID_ASSIGNMENT,AssignmentQuery::DESC)->findOne();
                    if($idUserAssign)
                    	$this->view->comboTo = UserQuery::create()->whereAdd(User::ID_USER, $idUserAssign->getIdUser())->find()->toCombo();
                    }else{
                    	$this->view->comboTo = UserQuery::create()->whereAdd(User::ID_USER, $ticketClientArray['id_user'])->find()->toCombo();
                    }   
			}else{
				if($loggedInUser->getIdUser()==$comments->getIdUserOrigin()){
                	$this->view->comboTo = UserQuery::create()->whereAdd(User::ID_USER, $comments->getIdUserDestiny())->find()->toCombo();
                }
                if($loggedInUser->getIdUser()==$comments->getIdUserDestiny()){
                	$this->view->comboTo = UserQuery::create()->whereAdd(User::ID_USER, $comments->getIdUserOrigin())->find()->toCombo();
                }
            }
            $arrayComments=CommentsQuery::create()
                                ->addColumns(array("id_comment","id_base_ticket","id_user_origin","id_user_destiny","creation_date","note"))
                                ->addColumn("Employee2Person.name")
                                ->addColumn("Employee2Person.last_name")
                                ->addColumn("Employee2Person.middle_name")
                                ->innerJoinUsers()->whereAdd(Comments::ID_BASE_TICKET, $ticketClientArray['id_base_ticket'])->orderBy(Comments::ID_COMMENT, CommentsQuery::DESC)->fetchAll();
            
            $this->view->arrayComments  = $arrayComments;
			$datosAvance = $this->getServiceLevelService()->getServiceTimeNew($ticketClient);
			$this->view->timeOfService  = $datosAvance[0];
			$this->view->percentageOfService= $datosAvance[1];
			$this->view->timeToExpireS= $datosAvance[2];
			$this->view->expirationDate = $expirationDate = $this->getServiceLevelService()->getExpirationDateNvo($ticketClient);
			$this->view->expirationDateS = substr($expirationDate,8,2)."-".substr($expirationDate,5,2)."-".substr($expirationDate,0,4)." ".substr($expirationDate,10,19); 
			$this->view->expiredTime    = $this->getServiceLevelService()->getExpiredTime($ticketClient);
			$this->view->timeToExpire   = $this->getServiceLevelService()->getTimeToExpire($ticketClient);			
			$serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($clientCategory->getIdServiceLevel(), "The Service Level not exists");			
			$this->view->serviceLevel   = $serviceLevel->getDuration();
			//$this->view->percentageOfService = $this->getServiceLevelService()->getPercentageService($ticketClient);
			$this->view->elapsedNaturalDays  = $this->getServiceLevelService()->getElapsedDays($ticketClient, true);
			$this->view->elapsedDays 		 = $this->getServiceLevelService()->getElapsedDays($ticketClient);
			$this->view->resolutionTime 	 = $serviceLevel->getResolutionDuration();
			$this->view->responseTime = $serviceLevel->getResponseDuration();
			$this->view->reasons      = ClientCategoryQuery::create()->actives()->find()->toComboConcat($header);

			$products      = ProductsQuery::create()->addColumns(array(Products::ID_PRODUCT,Products::ID_PRODUCT_BAM))->fetchPairs();
			$arrayTransaction = array();
            $transaction_q="SELECT a.*,convert(varchar,a.transaction_date, 103) as transaction_date_v,b.amount as ammount_p   FROM ".TicketsClientsTransactions::TABLENAME." a "
	                        . "LEFT JOIN ".TransactionsPartialities::TABLENAME." b ON a.id_ticket_client_transaction=b.id_ticket_client_transaction WHERE ".TicketsClientsTransactions::ID_TICKET_CLIENT."=$id";
			$transactionBd=$this->getTicketClientFieldCatalog()->getDb()->fetchAll($transaction_q);
			if(count($transactionBd) > 0){
				foreach($transactionBd as $temporal){
					$idTrans = $temporal['id_ticket_client_transaction'];
					if( (int) $temporal['id_transaction_bam'] > 0){
						$flagsGoodArray[$idTrans]      = 1;
						$flagsGoodFolioArray[$idTrans] = 1;						
						$arrayTransaction[] = array_merge($temporal,self::getTransaccionId($temporal['id_transaction_bam'])->toArray());
						if(trim($temporal['good_faith_request']) != null && trim($temporal['good_faith_request']) != ''){
							$flagGoodFaith = false;
							$flagsGoodArray[$idTrans]      = 2;
						}
						if(trim($temporal['good_faith_payment']) != null && trim($temporal['good_faith_payment']) != ''){
							$flagFolioGoodFaith = false;
							$flagsGoodFolioArray[$idTrans] = 2;
						}
					}
				}
			}
			$query_parcial="SELECT SUM(c.amount)as total FROM pcs_symphony_tickets_clients a 
	        				INNER JOIN pcs_symphony_tickets_clients_transactions b ON a.id_ticket_client=b.id_ticket_client 
	                        INNER JOIN pcs_symphony_tickets_clients_transactions_partialities c ON b.id_ticket_client_transaction=c.id_ticket_client_transaction
	                        WHERE a.id_ticket_client=$id";
			$effect_partial=$this->getTicketClientFieldCatalog()->getDb()->fetchAll($query_parcial);
			$this->view->amountTransactions = number_format($this->sumTransactions($transactionBd),2,'.',',');
			$arrayReopen = array();
			if($ticketClient->getFolioCondusef() != 'NULL' && $ticketClient->getFolioCondusef() != ''){
				$query_reopen =" SELECT * FROM ".TicketsClientsReopen::TABLENAME." WHERE id_ticket_client = $id;";
				$arrayReopen =$this->getTicketClientFieldCatalog()->getDb()->fetchAll($query_reopen);
			}		
			$clientDataTemporal = array();
			$mostrarAmortizacion = 0;
			if(count($arrayTransaction) > 0){
				foreach($arrayTransaction as $transTmp){
					if($transTmp['idT24'] != '' && strpos($transTmp['idT24'],'LD') !== false){
						$mostrarAmortizacion = 1;
						break;
					}
				}
			}
			$branchesBam = BranchQuery::create()->findByPK($ticketClient->getIdOriginBranch()); 
	 		$clientDataTemporal['folio']  		   = $ticketClient->getFolio(); 			
	 		$clientDataTemporal['folio_prev']  	   = $ticketClient->getFolioPrev();
	 		$clientDataTemporal['id_base_ticket']  = $ticketClient->getIdBaseTicket();
	 		$clientDataTemporal['account_number']  = $ticketClient->getAccountNumber();
	 		$clientDataTemporal['client_number']   = $ticketClient->getClientNumber();
	 		$clientDataTemporal['name']  		   = $ticketClient->getNameClient();
	 		$clientDataTemporal['email']  		   = $ticketClient->getEmail();	 			
	 		$clientDataTemporal['account_type']    = $ticketClient->getAccountType();
	 		$clientDataTemporal['employee']   	   = $ticketClient->getEmployee() == 1 ? "Si":"No";
	 		$clientDataTemporal['telefono']    	   = $ticketClient->getTelefono();
	        if($ticketClient->getCardType()==0)$cardType="N/A";
	        if($ticketClient->getCardType()==1)$cardType="Si";
	        if($ticketClient->getCardType()==2)$cardType="No";
	 		$clientDataTemporal['card_type']   = $cardType;
	 		$clientDataTemporal['no_card']    = $ticketClient->getNoCard();
	 		$clientDataTemporal['id_branch']  = $ticketClient->getIdOriginBranch();
	 		$clientDataTemporal['branch']     = self::getBranch($ticketClient->getIdOriginBranch());
			$clientDataTemporal['id_bam']     = $branchesBam->getIdBam();
	        $clientDataTemporal['client_category_name']     = $clientCategory->getName();
	        $clientDataTemporal['description_report']     = $ticketClient->getDescription();
	        $clientDataTemporal['effect_partial']     = $effect_partial[0]['total'];
	        $clientDataTemporal['created'] = $date_created[0]['date_created'];
	        $moreInfo= TicketClientQuery::create()->addColumn("Products.name","product")
	                                ->addColumn("Channel.name","channel")
	                                ->innerJoinProducts()
	                                ->innerJoinChannel2()
	                                ->whereAdd(TicketClient::ID_TICKET_CLIENT,$id)->fetchAll();                        
			$clientDataTemporal['product']=$moreInfo[0]['product'];
	        $clientDataTemporal['channel']=$moreInfo[0]['channel'];    
			$this->view->transactions     = $arrayTransaction;
			$this->view->reopens          = $arrayReopen;
			$this->view->clientData       = $clientDataTemporal;
	 		$this->view->clientDataJson   = self::buildString($clientDataTemporal);
	 		$this->view->transactionsJson = self::buildStringTransaction($arrayTransaction);
			$this->view->flagGoodFaith    = $flagGoodFaith;
			$this->view->flagFolioGoodFaith   = $flagFolioGoodFaith;			
			$this->view->flagsGoodArray       = $flagsGoodArray;
			$this->view->flagsGoodFolioArray  = $flagsGoodFolioArray;
			$this->view->mostrarAmortizacion  = $mostrarAmortizacion;
			$this->view->channels = ChannelQuery::create()->actives()->find()->toCombo();
			$this->view->ticketTypes = TicketTypeQuery::create()->actives()->orderBy(TicketType::NAME)->find()->toCombo();
			$emailTicket = $clientDataTemporal['email'];
			if(trim($ticketClientArray['email']) != ""){
					$emailTicket  = $ticketClientArray['email'];
				}
			$complemento = "";
			if((int) $ticketClientArray['id_client_category'] > 0){
				$reason = CategoryQuery::create()->findByPK($ticketClientArray['id_reason']);
				$complemento = $ticketClientArray['id_reason']."-".$reason->getFinancialMovement()."-".$reason->getPartialities();
			}
			$this->view->emailTicket 		= $emailTicket;
			$this->view->complemento 		= $complemento;
			$this->view->ticketClient 		= $ticketClientArray;			
			$this->view->idProductBam 		= $products[$ticketClientArray['id_product']];
			$this->view->branches 			= BranchQuery::create()->actives()->find()->toCombo();
			$this->view->requiredFields 	= $this->getRequiredFields($clientCategory->getIdClientCategory(),false);
			$this->view->ticketClientFields = TicketClientFieldQuery::create()
												->addColumns(array(TicketClientField::ID_FIELD, TicketClientField::VALUE))
												->whereAdd(TicketClientField::ID_TICKET_CLIENT, $id)
												->fetchPairs();
			$this->view->requiredDocuments  = $documents = $this->getRequiredDocuments($clientCategory->getIdClientCategory(),false);
			$this->view->documentsJson 		= self::buildStringDocuments($documents);
			$this->view->ticketClientDocuments = TicketClientDocumentQuery::create()
												->addColumns(array('TicketClientDocument.' . TicketClientDocument::ID_DOCUMENT,File::TABLENAME . '.' . File::URI))
												->innerJoinFile('TicketClientDocument', File::TABLENAME)
												->whereAdd('TicketClientDocument.'.TicketClientDocument::ID_TICKET_CLIENT, $id)
												->fetchPairs();
			$categories = ClientCategoryQuery::create()->actives()->find();
			$this->view->ticketMachine 	  = $this->ticketMachineIsCapplableArray($ticketClient);
			$this->view->nestedCategories = $categories->filterRoot()->toNestedArray($categories);
			$this->view->category 		  = $clientCategory->getName();
			$this->view->users 			  = UserQuery::create()->actives()->innerJoinGroup()->whereAdd('Group.id_group', $clientCategory->getIdGroup())->find()->toCombo($this->i18n->_('All'));
			$this->view->allUsers 		  = UserQuery::create()->find()->toCombo();
			$this->view->activities 	  = ActivityQuery::create()->whereAdd(Activity::ID_BASE_TICKET, $ticketClient->getIdBaseTicket())->find()->toArray();
			$this->view->trackings 		  = TicketLogQuery::create()
											->whereAdd(TicketLog::ID_BASE_TICKET, $ticketClient->getIdBaseTicket())
											->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$TrackeableEvents)
											->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$TrackeableEvents['Status'],TicketLogQuery::NOT_EQUAL)
											->find()->toArray();
			$clientCategoryResolutions = ClientCategoryResolutionQuery::create()
											->addColumn(ClientCategoryResolution::ID_CLIENT_RESOLUTION)
											->whereAdd(ClientCategoryResolution::ID_CLIENT_CATEGORY, $clientCategory->getIdClientCategory())
											->fetchCol();
			$this->view->clientResolutions = ClientResolutionQuery::create()
											->whereAdd(ClientResolution::ID_CLIENT_RESOLUTION, $clientCategoryResolutions, ClientResolutionQuery::IN)
											->find()->toComboA($header);
			$this->view->clientResolutionsType = self::buildStringResolution(ClientResolutionQuery::create()->addColumns(array(ClientResolution::ID_CLIENT_RESOLUTION,ClientResolution::TYPE))->fetchPairs());
			$this->view->events 	= array_flip(TicketLog::$TrackeableEvents);
			$this->view->no_card 	= $ticketClient->getNoCard();
			$this->view->assignable = $this->getAssignable($ticketClient);
			$this->view->onsubmit   = 'update';
			$this->view->modifyTicket = $this->allowToModifyTicket($ticketClient);
			$this->view->resolutions  = ClientResolutionQuery::create()->find();
			$assignments = AssignmentQuery::create()
									->whereAdd(Assignment::ID_BASE_TICKET, $ticketClient->getIdBaseTicket())
									->find();
			
			$this->view->assignments = $xx = $assignments->toArray();
			$resolutionDate = "";
			if(count($xx) > 0){
				foreach($xx as $tmpDate){
					$resolutionDate = $tmpDate['resolution_date'];
				}
			}
			$this->getTicketService()->expirationDate($ticketClient,$expirationDate);
	        //$arrayAssignments = $assignments->getFileIds();
	        $this->view->resolutionDate  = $resolutionDate;
			$this->view->resolutionFiles = FileQuery::create()->whereAdd(File::ID_FILE, $assignments->getFileResolutionIds())->find();
	        $this->view->assignmentFiles = FileQuery::create()->whereAdd(File::ID_FILE, $assignments->getFileIds())->find();
			$this->view->uploadFiles = $this->allowToUploadFiles();
			$this->view->periods    = array_flip(TicketClient::$periods);
				
			$this->view->canalUser  = (int) $this->getUser()->getBean()->getIdChannel();
			$this->view->branchUser = (int) $this->getUser()->getBean()->getIdBranch();
			$this->view->products   = ProductsQuery::create()->actives()->find()->toCombo();
			$this->view->chargeBackD = array(''  => $header);
			$this->view->chargeBackT = array(''  => $header);
			$this->view->ControlReasons = ControversyReasonsQuery::create()->actives()->find()->toCombo($header);
			$this->view->recovered = array(''  => '','1' => $this->i18n->_('Yes'),'2' => $this->i18n->_('No'));
			$this->view->boolean   = array('1' => $this->i18n->_('Yes'),'2' => $this->i18n->_('No'));
			$this->view->typeTransactions = TicketsClientsTransactions::typeTransactions();
			$this->view->ticketTypesJurid = TicketTypeQuery::create()->whereAdd(TicketType::ID_TICKET_TYPE,2,' != ')->actives()->orderBy(TicketType::NAME)->find()->toCombo($header);
			$this->view->channelReopen    = ChannelQuery::create()->whereAdd(Channel::REOPEN, 1)->find()->toCombo($header);
			$this->view->userChannel      = $this->getUser()->getBean()->getIdChannel();			
		}catch (Exception $e){
			$this->view->id = $id;
			$this->view->errorStatus = true;
			$this->view->errorMessage = $e->getMessage();
		}
	}
		
	/**
	 * @module Ticket Client
	 * @action Questions
	 */
	public function questionAction(){
	}
	
	/**
	 * 
	 * @param TicketClient $ticketClient
	 * @return boolean
	 */
	private function allowToModifyTicket(TicketClient $ticketClient){
		return true;
// 		$creator = UserQuery::create()->findByPK($ticketClient->getIdUser());
// 		$loggedInUser = $this->getUser()->getBean();
// 		if($creator->getIdUser() == $loggedInUser->getIdUser())
// 			return true;
// 		if($creator->getIdAccessRole() == AccessRole::GESTOR && (in_array($loggedInUser->getIdAccessRole(), array(AccessRole::ADMINISTRATOR, AccessRole::COMPTROLLER))))
// 			return true;
// 		elseif($creator->getIdAccessRole() != AccessRole::GESTOR)
// 			return true;
// 		elseif($loggedInUser->getIdAccessRole() == AccessRole::GESTOR)
// 			return true;
// 		else 
// 			return false;
	}
	private function allowToUploadFiles(){
		$loggedInUser = $this->getUser()->getBean();
		if (in_array($loggedInUser->getIdAccessRole(), array(AccessRole::SUPERVISOR, AccessRole::RESOLUTOR, AccessRole::GROUP_SUPERVISOR)))
			return false;
		else 
			return true;
		
	}
	/**
	 * @return array
	 * @param TicketClient $ticketClient
	 */
	private function ticketMachineIsCapplableArray($ticketClient){
		$ticketMachine = $this->getTicketMachine();
		$values['Cancel'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Cancel');
		$values['Work'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Work');
		$values['Read'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Read');
		$values['Close'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Close');
		$values['Open'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Open');
		$values['Assign'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Assign');
		$values['Resolve'] = $ticketMachine->isCappableByConditionName($ticketClient, 'Resolve');
		return $values;
	}
		
	/**
	 * @return string
	 * @param TicketClient $ticketClient
	 */
	protected function getTimeOfServiceForView(TicketClient $ticketClient){
		$duration = $this->getServiceLevelService()->getServiceTime($ticketClient);
		return $duration->getHoursPart() . 
		$this->i18n->_(' hours ') 
		. $duration->getMinutesPart() . 
		$this->i18n->_(' minutes ') . 
		$duration->getSecondsPart() . 
		$this->i18n->_(' seconds');
	}
	/**
	 * @return string
	 * @param TicketClient $ticketClient
	 */
	protected function getExpirationTimeForView(TicketClient $ticketClient){
		$duration = $this->getServiceLevelService()->getExpiredTime($ticketClient);
		return $duration->getHoursPart() . 
		$this->i18n->_(' hours ') . 
		$duration->getMinutesPart() . 
		$this->i18n->_(' minutes ') . 
		$duration->getSecondsPart() . 
		$this->i18n->_(' seconds');
	}
	/**
     * @module Ticket Client
     * @action Tracking
	 */
	public function trackingAction(){
		$id = $this->getRequest()->getParam('id');
		$ticket = TicketClientQuery::create()->findByPK($id);
		$this->view->users = UserQuery::create()->find()->toCombo();
		$this->view->events = array_flip(TicketLog::$TrackeableEvents);
		$this->view->trackings = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$TrackeableEvents)
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$TrackeableEvents['Status'],TicketLogQuery::NOT_EQUAL)
		->find()->toArray();
		$this->view->assignments = AssignmentQuery::create()->whereAdd(Assignment::ID_BASE_TICKET, $ticket->getIdBaseTicket())->find()->toArray();
		$this->view->resolutions = ClientResolutionQuery::create()->find();
                
                $assignments = AssignmentQuery::create()
			->whereAdd(Assignment::ID_BASE_TICKET, $ticket->getIdBaseTicket())
			->find();

		$this->view->assignments = $assignments->toArray();
		$this->view->assignmentFiles = FileQuery::create()->whereAdd(File::ID_FILE, $assignments->getFileIds())->find();
                
		$this->view->setTpl('new-tabs/Tracking');
	}
	/**
     * @module Ticket Client
     * @action Create
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$number_files=$params['number_files'];
			$params['id_client_category']= $params['clientCategoryHidden'];
			$full_file=0;
            foreach($_FILES as $file){
            	if($file['name'] !='')
                	$full_file++;
            }
            $status_to=($full_file < $number_files)?"Unread":"Unread";            
            $params['folio_condition']=($full_file < $number_files)?0:1;
            $params['status_to']=$status_to;           
			$ticket = $this->getTicketService()->create($params, $this->getUser()->getBean());
			$this->getTicketService()->read($ticket, $this->getUser()->getBean());
			$this->getTicketClientFieldCatalog()->beginTransaction();
			try {
				if (!empty($params['requiredFields']))
					$this->saveRequiredFields($params['requiredFields'], $ticket->getIdTicketClient());
				if($params['id_client_category'] != null && (int) $params['id_ticket_type'] != 3)
					$this->saveRequiredDocuments($params['id_client_category'], $ticket->getIdTicketClient());
			}catch (Exception $e){
				$this->setFlash('error', $e->getMessage());
			}
			$this->getTicketClientFieldCatalog()->commit();
			$this->assign($ticket);
			if((int) $params['id_ticket_type'] == 3){
				//es consulta y cambio el estatus
				$resolution = ResolutionQuery::create()->whereAdd(Resolution::ID_RESOLUTION,1)->findOne();
				if($resolution instanceof Resolution){					
					$this->getTicketService()->resolve($ticket, $resolution, $this->getUser()->getBean(), $params['description']);
				}
			}
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}

	/**
	 * @module Ticket Client
	 * @action Create para consulta via Ajax
	 */
	public function creaetAjaxAction(){
		$exito = 0;
		$user   = UserQuery::create()->whereAdd(User::ID_USER, $this->getUser()->getBean()->getIdUser())->findOne();		
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			
			$reason = explode("-",$params['id_reason']);
			$params['id_reason'] 		= $reason[0];
			$params['id_client_category'] = $reason[0];
			$params['id_channel'] 		= 1;
			$params['id_origin_branch'] = $user->getIdBranch();
			$params['id_ticket_type']   = 3;
			$params['controller'] 	    = 'ticket-client';
			$params['folio_condition']  = 1;
			
			$ticket = $this->getTicketService()->create($params, $this->getUser()->getBean());
			$resolution = ClientResolutionQuery::create()->findByPK(1); // numero fijo para las consultas
			$this->getTicketService()->assign($ticket,$this->getUser()->getBean(), $this->getUser()->getBean());
			$this->getTicketService()->resolveTicketClient($ticket,$resolution, $this->getUser()->getBean(), $note, null, null);
			if((int) $ticket->getIndex() > 0){
				
				$exito = 1;
			}			
			die(json_encode(array('exito' => $exito)));
		}
	}
	/**
	 *
	 * @param array $fields
	 * @param int $idTicketClient
	 */
	private function saveRequiredFields(array $fields, $idTicketClient){
		foreach ($fields as $index => $field){
			if (!empty($field)){
				$ticketClientField = new TicketClientField();
				$ticketClientField->setIdField($index);
				$ticketClientField->setValue($field);
				$ticketClientField->setIdTicketClient($idTicketClient);
				if (TicketClientFieldQuery::create()->whereAdd(TicketClientField::ID_FIELD, $index)->whereAdd(TicketClientField::ID_TICKET_CLIENT, $idTicketClient)->count()){
					$ticketClientField = TicketClientFieldQuery::create()->whereAdd(TicketClientField::ID_FIELD, $index)->whereAdd(TicketClientField::ID_TICKET_CLIENT, $idTicketClient)->findOne();	
					$this->getTicketClientFieldCatalog()->update($ticketClientField);
				}
				else
					$this->getTicketClientFieldCatalog()->create($ticketClientField);
			}
		}
	}
	private function saveRequiredDocuments($idClientCategory, $idTicketClient){
		$contadorFiles = 0;
		$path = $this->uploadPath . '/' . $idTicketClient . '/';
		$idDocuments = RequiredDocumentQuery::create()
		->addColumn(RequiredDocument::ID_DOCUMENT)
		->whereAdd(RequiredDocument::ID_CLIENT_CATEGORY, $idClientCategory)
		->fetchCol();		
		foreach ($idDocuments as $idDocument){
			$fileField = 'requiredDocuments' . $idDocument;
			if (TicketClientDocumentQuery::create()
					->whereAdd(TicketClientDocument::ID_DOCUMENT, $idDocument)
					->whereAdd(TicketClientDocument::ID_TICKET_CLIENT, $idTicketClient)
					->count()){

				$ticketClientDocument = TicketClientDocumentQuery::create()
				->whereAdd(TicketClientDocument::ID_DOCUMENT, $idDocument)
				->whereAdd(TicketClientDocument::ID_TICKET_CLIENT, $idTicketClient)
				->findOne();

				$newFile = $this->saveFile($fileField, $path);
				if ($newFile){
					$file = FileQuery::create()->findByPK($ticketClientDocument->getIdFile());
					$this->deleteFile($file->getUri());
					$file->setOriginalName($newFile->getOriginalName());
					$file->setUri($newFile->getUri());
					$this->getFileCatalog()->update($file);
					$contadorFiles++;
				}
			}else{
				$file = $this->saveFile($fileField, $path);
				if ($file){
					$this->getFileCatalog()->create($file);
					$ticketClientDocument = new TicketClientDocument();
					$ticketClientDocument->setIdDocument($idDocument);
					$ticketClientDocument->setIdFile($file->getIdFile());
					$ticketClientDocument->setIdTicketClient($idTicketClient);
					$this->getTicketClientDocumentCatalog()->create($ticketClientDocument);
					$contadorFiles++;
				}
			}
		}
		if(count($idDocuments)  ==  $contadorFiles){
			return true;
		}
		return false; 
	}
	/**
     * @module Ticket Client
     * @action Save
	 */
	public function updateAction(){
		$params = $this->getRequest()->getParams();                
		$ticket = TicketClientQuery::create()->findByPK($params['id_ticket_client']);
		
		$ticket = $this->getTicketService()->update($ticket, $params, $this->getUser()->getBean());
		$this->setFlash('ok', $this->i18n->_('The ticket has been updated'));	
		$this->getTicketClientFieldCatalog()->beginTransaction();
		try {
			if (!empty($params['requiredFields']))
            	$this->saveRequiredFields($params['requiredFields'], $ticket->getIdTicketClient());
			$this->saveRequiredDocuments($ticket->getIdClientCategory(), $ticket->getIdTicketClient());
			if((int)$ticket->getStatus() < 3)
	            $this->getTicketService()->updateFolio($ticket);
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->getTicketClientFieldCatalog()->commit();
		$statuses = array_flip(TicketClient::$Statuses);
		$this->assign($ticket);
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Work
	 */
	public function workAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->working($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been set as working on it.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Cancel
	 */
	public function cancelAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->cancel($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been cancel.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Reopen
	 */
	public function reopenAction(){
		$idUserResolved = $idAssignment = 0;
		try {
			$idUserNvo = $this->getUser()->getBean()->getIdUser();
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$type = TicketType::$TicketType;
			if($ticket->getIdTicketType() !=  $type['Consulta'] && $ticket->getIdTicketType() !=  $type['Servicios'] ){
				$idUserResolved = $ticket->getIdResolver();
				$idAssignment   = $ticket->getIdAssignment();
				$this->getTicketService()->updateStatusAssigment($idAssignment);
			}
			$this->getTicketService()->reopen($ticket, $this->getUser()->getBean());
			$this->registredReopen($ticket);
			$this->updateNullTransactions($ticket);
			if($ticket != null){
				$expirationDate = self::getExpirationDate($ticket);
				$this->getTicketService()->expirationDateTicket($ticket,$expirationDate,0);
				$this->getTicketService()->getUpdatedateLogs($ticket,$idUserNvo);
			}
				
			//asignamos el ticket al usuario que resolvio el ticket	
			if($ticket->getIdTicketType() !=  $type['Consulta'] && $ticket->getIdTicketType() !=  $type['Servicios'] ){
				if((int) $idUserResolved > 0){
					$user = UserQuery::create()->findByPK($idUserResolved);
					$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
					$this->getTicketService()->updateUserTicket($ticket,$this->getUser()->getBean()->getIdUser());
				}			
				$this->sendNotification($ticket,$idUserResolved);	//envio notificacion a quien resolvio el ticket
			}
			$this->setFlash('ok', $this->i18n->_('The ticket has been reopened.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	
	public function updateNullTransactions($ticket){
		$idTicketClient = $ticket->getIdTicketClient();
		if( (int) $idTicketClient > 0){
			try{
				$upd = "UPDATE pcs_symphony_tickets_clients_transactions
						SET good_faith_payment = null, good_faith_date = null,
						 	good_faith_amount = null, good_faith_request = null
						WHERE id_ticket_client = '".$idTicketClient."';";
				$this->getTicketClientFieldCatalog()->getDb()->query($upd);
			}
			catch(Exception $e){
					echo $e->getMessage();
			}				
		}
	}
	
	public function registredReopen($ticket){
		$idTicketClient = $ticket->getIdTicketClient();
		if( (int) $idTicketClient > 0){			
			$sql = "select id_ticket_client_transaction,amount,good_faith_payment,good_faith_date,good_faith_amount,good_faith_request 
					from pcs_symphony_tickets_clients_transactions WHERE id_ticket_client = '".$idTicketClient."';";
			$transactionBd=$this->getTicketClientFieldCatalog()->getDb()->fetchAll($sql);			
			if(count($transactionBd) > 0){		
				try{
					foreach($transactionBd as $temporal){
						$date = null;
						if((double) $temporal['good_faith_amount'])
						if(trim($temporal['good_faith_amount']) != 'NULL' && trim($temporal['good_faith_amount']) !=''){
							$ins = "INSERT INTO pcs_symphony_tickets_clients_reopen (id_ticket_client,id_ticket_client_transaction,
									amount,good_faith_payment,good_faith_date,good_faith_amount,good_faith_request)
									VALUES ('".$idTicketClient."','".$temporal['id_ticket_client_transaction']."',
									'".$temporal['amount']."','".$temporal['good_faith_payment']."',
									'".$temporal['good_faith_date']."','".$temporal['good_faith_amount']."','".$temporal['good_faith_request']."');";
							$this->getTicketClientFieldCatalog()->getDb()->query($ins);
						}
					}
				}
				catch(Exception $e){
					echo $e->getMessage();
				}
			}			
		}
	}
	
	/**
     * @module Ticket Client
     * @action Read
	 */
	public function readAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->read($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been read.'));
			$statuses = array_flip(TicketClient::$Statuses);
			if ($ticket->getStatus() == $statuses['Read']){
				$this->assign($ticket);
			}
			
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Close
	 */
	public function closeAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->close($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been closed.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Resume
	 */
	public function resumeAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->resume($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been resumed.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Edit
	 */
	public function pauseAction(){
		try {
			$pk = $this->getRequest()->getParam('id');
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$this->getTicketService()->pause($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been paused.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}

	/**
	 * Metodo de busqueda
	 */
	public function searchTicketMalAction(){
		$sinEstatus = 0;
		$header  = $this->i18n->_('Select');
		$params = $this->getRequest()->getParams();
		$params ['id_ticket_type_sin'] = 3;
		if($this->permissions($this->getUser()->getBean()->getIdAccessRole(),'view-all-tickets') == 0){
			$params ['id_user'] = $this->getUser()->getBean()->getIdUser();		
			if(trim($params ['status'] ) == ''){
				$sinEstatus = 1;
				$params ['type'] = TicketType::$Complaints;
				$params ['status'] = TicketType::$states;
			}
		}else{
			if(trim($params ['status'] ) == ''){
				$sinEstatus = 1;			
			}
		}
		if($this->permissions($this->getUser()->getBean()->getIdAccessRole(),'view-all-tickets') == 0){	
			$tickets = 	TicketClientQuery::create()->filter($params)
						->orderBy(TicketClient::STATUS,TicketClientQuery::ASC)
						->orderBy(TicketClient::FOLIO,TicketClientQuery::ASC)
						->orderBy(TicketClient::CREATED,TicketClientQuery::ASC)
						->find();
		}else{
			$assignments = AssignmentQuery::create()->whereAdd(Assignment::ID_USER, $this->getUser()->getBean()->getIdUser())->fetchIds();
			$tickets = 	TicketClientQuery::create()->filter($params)
			->where()->setOR()
			->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
			->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser())
			->Add(TicketClient::STATUS, 5);
			if(count($assignments) > 0){
				$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$tickets = $tickets->endWhere();
			$tickets = $tickets->where()->setAND()
			->Add(TicketClient::ID_USER,$this->getUser()->getBean()->getIdUser())
			->Add(TicketClient::ID_RESOLVER,$this->getUser()->getBean()->getIdUser())
			->Add(TicketClient::STATUS,3);
			if(count($assignments) > 0){
				$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$tickets = $tickets->endWhere()->orderBy(TicketClient::STATUS,TicketClientQuery::ASC)
			->orderBy(TicketClient::FOLIO,TicketClientQuery::ASC)
			->orderBy(TicketClient::CREATED,TicketClientQuery::ASC)
			->find();				
		}
		$arrayTicket = $tickets->toArrayForList();
		$amounts     = $this->getTicketService()->getAmount($arrayTicket);
		$products    = ProductsQuery::create()->actives()->find()->toCombo($header);
		$ticketTypes = TicketTypeQuery::create()->find()->toCombo($header);
		if(count($arrayTicket)>0){
			foreach($arrayTicket as $ind => $data){
				$arrayTicket[$ind]['nm_product'] = $products[$data['id_product']];
				$arrayTicket[$ind]['amount']     = $amounts[$data['id_ticket_client']];
				$arrayTicket[$ind]['nm_type']    = $ticketTypes[$data['id_ticket_type']];				
				$arrayTicket[$ind]['status']     = $this->i18n->_($data['status']);
			}
			foreach($arrayTicket as $ind => $data){
				foreach($data as $key => $value){
					if($key == 'amount'){
						$arrayTicket[$ind][$key] =  number_format($value,2,'.',',');
					}
					elseif($key == 'created'){
						$arrayTicket[$ind][$key] = substr($value,0,10);
					}
					elseif($key == 'expiration_date'){
						$date = new DateTime($value);
						$arrayTicket[$ind][$key] = $date->format('Y-m-d H:i');						
					}else{
						$arrayTicket[$ind][$key] = utf8_encode($value);
					}
				}
			}						
		}
		if($sinEstatus){
			$params ['status'] = $params ['type'] = '';
		}
		die(json_encode($arrayTicket));
	}
	
	public function searchTicketsAction(){
		$sinEstatus = 0;
		$nestedCategories = array();
		$header  = $this->i18n->_('Select');
		$scripts = array('modules/ticket-client/new.js');
		$this->view->params = $params = $this->getRequest()->getParams();
		$this->view->page   = $page = $this->getRequest()->getParam('page') ?: 1;
		if($params['id_ticket_type'] == '')
			$params['id_ticket_type_sin'] = 3;

		if($params['regs']){
			$params['regs'] = 6;
		}
		if((int) $page  < 2)
			$inicio= 1;
		else
			$inicio = ( ($page - 1) * $params['regs']) + 1 ;
			
		$nameClient = array();
		if(trim($params['name']) != ''){
			$nameClient[] = trim($params['name'])."%";	
		}
		if(trim($params['last_name']) != ''){
			$nameClient[] = trim($params['last_name']);
		}
		if(trim($params['last_name']) != ''){
			$nameClient[] = trim($params['middle_name']);
		}
		if(count($nameClient)>0){
			$params['name_client'] = implode(' ',$nameClient);
		}			
		$this->view->urlpaginador = $this->getUrlPaginator($params);		
		$params['id_user']="";
		
		if((int) $params['status'] == 0){
			$condition = " > ";
			$value     = 0;
		}else{
			$condition = " = ";
			$value     = $params['status'];
				
		}
		$campoOrdernado = array();
		if(trim($params['head']) != ''){
			$campoOrdernado = $this->getField($params['head'], $params['orden']);
		}		
		//if($this->permissions($this->getUser()->getBean()->getIdAccessRole(),'view-all-tickets') == 0){			
			$totalObj   = TicketClientQuery::create()->filter($params)->find();
			$tickets = 	TicketClientQuery::create()->filter($params);
			if(count($campoOrdernado) > 0){
				$tickets =$tickets->orderBy($campoOrdernado[0],$campoOrdernado[1]);				
			}
			if(trim($params['head']) != 'Tstatus'){
				$tickets =$tickets->orderBy(TicketClient::STATUS,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Texpiration'){
				$tickets =$tickets->orderBy(TicketClient::EXPIRATION_DATE,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Tdassign'){
				$tickets =$tickets->orderBy(TicketClient::CREATED,TicketClientQuery::ASC);
			}
			$tickets =$tickets->page($page, $this->getMaxPerPage())->find();
			
			
			$assignments = AssignmentQuery::create()->fetchIds();
			$totalObj = TicketClientQuery::create()->filter($params)
			->where()->setOR()
			->Add(TicketClient::STATUS,$value,$condition);
			if(count($assignments) > 0){
				$totalObj = $totalObj->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$totalObj = $totalObj->endWhere();
			$totalObj = $totalObj->where()->setAND()
			->Add(TicketClient::STATUS,$value,$condition);
			if(count($assignments) > 0){
				$totalObj = $totalObj->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$totalObj = $totalObj->endWhere()->find();				
			$tickets = 	TicketClientQuery::create()->filter($params)
			->where()->setOR()
			->Add(TicketClient::STATUS,$value,$condition);
			if(count($assignments) > 0){
				$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$tickets = $tickets->endWhere();
			$tickets = $tickets->where()->setAND()
			->Add(TicketClient::STATUS,$value,$condition);
			if(count($assignments) > 0){
				$tickets = $tickets->Add(TicketClient::ID_ASSIGNMENT, $assignments, TicketClientQuery::IN);
			}
			$tickets = $tickets->endWhere();
			if(count($campoOrdernado) > 0){
				$tickets =$tickets->orderBy($campoOrdernado[0],$campoOrdernado[1]);
			}				
			if(trim($params['head']) != 'Tstatus'){
				$tickets =$tickets->orderBy(TicketClient::STATUS,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Texpiration'){
				$tickets =$tickets->orderBy(TicketClient::EXPIRATION_DATE,TicketClientQuery::ASC);
			}
			if(trim($params['head']) != 'Tdassign'){
				$tickets =$tickets->orderBy(TicketClient::CREATED,TicketClientQuery::ASC);
			}
			$tickets =$tickets->page($page, $this->getMaxPerPage())->find();
		//}
		
		$this->view->total    = $total = count($totalObj);
		$this->view->tickets = $arrayTicket = $tickets->toArrayForList();
		$this->view->tAmounts  = $this->getTicketService()->getAmount($arrayTicket);
		$this->view->color     = $this->getHours($tickets);
		$this->view->scripts   = $scripts;
		$ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo();
		foreach ($ticketTypes as $idTicketType => $ticketType){
			$categories = ClientCategoryQuery::create()->whereAdd(ClientCategory::ID_TICKET_TYPE, $idTicketType)->actives()->find();
			$nestedCategories[$idTicketType] = $categories->filterRoot()->toNestedArray($categories);
		}
		
		$this->view->nestedCategories = $nestedCategories;
		$this->view->clientCategories = ClientCategoryQuery::create()->actives()->isLeaf()->find()->toCombo($header);
		$this->view->ticketTypes 	  = TicketTypeQuery::create()->actives()->orderBy(TicketType::NAME)->find()->toCombo($header);
		$this->view->ticketTypesJurid = TicketTypeQuery::create()->whereAdd(TicketType::ID_TICKET_TYPE,2,' != ')->actives()->orderBy(TicketType::NAME)->find()->toCombo($header);
		$this->view->channels   	  = ChannelQuery::create()->actives()->find()->toCombo($header);
		$this->view->branches   	  = BranchQuery::create()->actives()->find()->toCombo($header);
		$this->view->statuses   	  = $this->getStatusCombo($header);
		$this->view->periods    	  = array_flip(TicketClient::$periods);
		$this->view->reasons    	  = ClientCategoryQuery::create()->actives()->find()->toComboConcat($header);
		$this->view->reasonsC    	  = ClientCategoryQuery::create()->actives()->find()->toCombo($header);
		$this->view->products   	  = ProductsQuery::create()->actives()->find()->toCombo($header);
		$this->view->canalUser  	  = (int) $this->getUser()->getBean()->getIdChannel();
		$this->view->branchUser 	  = (int) $this->getUser()->getBean()->getIdBranch();
		$this->view->users      	  = UserQuery::create()->actives()->find()->toCombo($header);
		$this->view->page             = $page;
		
		if($sinEstatus){
			$params ['status'] = $params ['type'] = '';
		}		
		
		$this->view->params 		  = $params;
		$this->view->idregs           = $this->getMaxPerPage();
		$this->view->urlpaginador     = $xx= self::getUrlPaginator($params);
		$this->view->paginator 		  = $this->createPaginator($total, $page);
		$html = $this->view->getEngine()->fetch('ticket-client/search.tpl', true);
		$html = utf8_encode($html);
		die($html);
	}
	
	
	private function getUrlPaginator($params){
		$url="page=".$params['page'];
		$url="";
		foreach($params as $clave => $valor){
			if( ($clave != "page") &&  ($clave != "accion") &&  ($clave != "controller") && ($clave != "action") && ($clave != "module") ){
				$url.=$clave."=".$valor."&";
			}
			
		}
		return $url;
	}
	
	public function goodFaithAmountAction(){
		//{if "ticket-client/good-faith-amount"|isAllowed}
	}
	
	public function goodFaithAmountRequestAction(){
		//{if "ticket-client/good-faith-amount-request"|isAllowed}
	}
	
	public function viewModuleControversyAction(){
		//{if "ticket-client/view-module-controversy"|isAllowed}
	}

	public function viewModulePaymentAction(){
		//{if "ticket-client/view-module-payment"|isAllowed}
	}
	
	public function ticketLegalAction(){
		//{if "ticket-client/ticket-legal"|isAllowed}
	}
	public function viewButtonMoreAction(){
		//{if "ticket-client/view-button-more"|isAllowed}
	}

	public function viewButtonSeeLogAction(){
		//{if "ticket-client/view-button-see-log"|isAllowed}
	}
	public function viewButtonStateAccountAction(){
		//{if "ticket-client/view-button-state-account"|isAllowed}
	}
	
	public function viewButtonAmortizationAction(){
		//{if "ticket-client/view-button-amortization"|isAllowed}
	}
	public function viewAllTicketsAction(){
		//{if "ticket-client/view-all-tickets"|isAllowed}
	}
		
	private function sendNotification(TicketClient $ticket,$userId){
		if($userId > 0){
			$idTemplate      = (int)TemplateEmailQuery::create()->addColumn(TemplateEmail::ID_TEMPLATE_EMAIL)
			->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_REOPEN_CONDUSET)->fetchOne();
			$emailResolutor  = $this->getEmail($userId);
			if( (int) $ticket->getIdBaseTicket() > 0 && (int) $idTemplate > 0 && trim($emailResolutor) != ""){
				$this->notification($ticket->getIdBaseTicket(),$idTemplate,$emailResolutor);
			}
		}
	}
	
	private function getEmail($userId){
		try{
			$sql = "select a.id_employee,b.id_person,c.id_email,d.email
					from pcs_common_users as a 
					join pcs_symphony_employees as b on b.id_employee = a.id_employee 
					left join pcs_common_persons_emails as c on c.id_person = b.id_person
					join pcs_common_emails as d on d.id_email = c.id_email
					where a.id_user = '".$userId."';";
			$res = $this->getEmployeeCatalog()->getDb()->fetchAll($sql);
			return $res[0]['email'];
		}catch(Exception $e){
			return '';			
		}
	}
	
	
	private function getExpirationDate(TicketClient $ticket){
		$expirationDate = $this->getServiceLevelService()->getExpirationDateNvo($ticket); 
 		return $expirationDate;
	}
	/**
	 * 
	 * @param TicketClient $ticket
	 */
	private function assign(TicketClient $ticket){
		$ticketClient = TicketClientQuery::create()->findByPK($ticket->getIdTicketClient());
		$assigmentFlag = $this->getAssignable($ticket);		
		$option = OptionQuery::create()->findByPK(Option::$Options['AutoAssignedTicket']);
		$statuses =array_flip(TicketClient::$Statuses);			
	if ($assigmentFlag && $option->getValue() && $ticket->getStatus() == $statuses['Read']){
			if($ticket->getIsStopped()){
				$this->setFlash('warning', $this->i18n->_('El ticket se encuentra pausado, no se puede hacer la asignación autómatica.'));
			}else{
				$category = ClientCategoryQuery::create ()->findByPK ( $ticket->getIdClientCategory () );
				$group = GroupQuery::create ()->findByPK ( $category->getIdGroup () );
				if ($group->getIdUserAssignedForTickets ()) {
					$userAssigned = UserQuery::create ()->findByPK ( $group->getIdUserAssignedForTickets () );					
					try {
						$this->getTicketService ()->assign ( $ticket, $userAssigned, $this->getUser ()->getBean () );
						$ticketClientT = $this->getTicketService()->updateTicket($ticketClient);
						if($ticketClientT != null){
							$expirationDate = self::getExpirationDate($ticketClientT);
							$this->getTicketService()->expirationDateTicket($ticketClientT,$expirationDate,$userAssigned->getIdUser());
							$this->getTicketService()->getUpdatedateLogs($ticketClientT,$userAssigned->getIdUser());
						}
						$this->setFlash ( 'ok', $this->i18n->_ ( 'The ticket has been assigned.' ) );
						return true;
					} catch ( Exception $e ) {
						$this->setFlash ( 'error', $e->getMessage () );
						return false;
					}
				} else {
					$this->setFlash ( 'warning', $this->i18n->_ ( 'The auto-assigned ticket option is active but there is not a user assigned.' ) );
				}
			}
				
		}
	}
	/**
	 * 
	 * @param TicketClient $ticket
	 * @return boolean
	 */
	private function getAssignable (TicketClient $ticket){
		$assigmentFlag = true;
		$requiredDocuments = $this->getRequiredDocuments($ticket->getIdClientCategory());
		$requiredFields = $this->getRequiredFields($ticket->getIdClientCategory());
		foreach ($requiredDocuments as $requiredDocument){
			if (!TicketClientDocumentQuery::create()
					->whereAdd(TicketClientDocument::ID_TICKET_CLIENT, $ticket->getIdTicketClient())
					->whereAdd(TicketClientDocument::ID_DOCUMENT, $requiredDocument['id_document'])
					->count()){
				$assigmentFlag = false;
					}
		}
		foreach ($requiredFields as $requiredField){
			if (!TicketClientFieldQuery::create()
					->whereAdd(TicketClientField::ID_TICKET_CLIENT, $ticket->getIdTicketClient())
					->whereAdd(TicketClientField::ID_FIELD, $requiredField['id_field'])->count()){
				$assigmentFlag = false;
			}
		}
		return $assigmentFlag;
	}
	/**
     * @module Ticket Client
     * @action Assign
	 */
	public function assignAction(){
		try {
			$id = $this->getRequest()->getParam('id');
			$idUser = $this->getRequest()->getParam('id_user');
			$ticket = TicketClientQuery::create()->findByPK($id);
			$ticketClient = TicketClientQuery::create()->findByPK($id);					
			$user = UserQuery::create()->findByPK($idUser);
			$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
			$ticketClientT = $this->getTicketService()->updateTicket($ticketClient);
			if($ticketClientT != null){
				$expirationDate = self::getExpirationDate($ticketClientT);
				$this->getTicketService()->expirationDateTicket($ticketClientT,$expirationDate,$user->getIdUser());
				$this->getTicketService()->getUpdatedateLogs($ticketClientT,$user->getIdUser());
			}
			$this->setFlash('ok', $this->i18n->_('The ticket has been assigned.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
        
        /**
     * @module Ticket Client
     * @action Assign
	 */
	public function reassignAction(){
		try {
			$id = $this->getRequest()->getParam('id');
			$idUser = $this->getRequest()->getParam('id_user');
                        $note=$this->getRequest()->getParam('note');
			$ticket = TicketClientQuery::create()->findByPK($id);
                        $userOrigin=$this->getUser()->getBean()->getIdUser();
			$user = UserQuery::create()->findByPK($idUser);
			$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
			//$this->getTicketService ()->userIdResolver( $ticket, $user->getIdUser());
                        $now = \Zend_Date::now();
                        $comments=new Comments();
                        $fields=array('id_base_ticket'=>$ticket->getIdBaseTicket(),'id_user_origin'=>$userOrigin,'id_user_destiny'=>$idUser,'creation_date'=>$now->get('yyyy-MM-dd HH:mm:ss'),'note'=>$note);
                        CommentsFactory::populate($comments, $fields);
                        $this->getCommentsCatalog()->create($comments);
                        $ticketLog = TicketLogFactory::createFromArray(array(
                        'id_base_ticket' => $ticket->getIdBaseTicket(),
                        'id_user' => $userOrigin,
                        'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                        'event_type' => TicketLog::$EventTypes['Update'],
                        'changed_from' => 0,
                        'changed_to' => 0,
                        'note' => '',
                        ));
                        $this->getTicketLogCatalog()->create($ticketLog);
                        $ticketLog2 = TicketLogFactory::createFromArray(array(
                        'id_base_ticket' => $ticket->getIdBaseTicket(),
                        'id_user' => $userOrigin,
                        'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                        'event_type' => TicketLog::$EventTypes['Assign'],
                        'changed_from' => 0,
                        'changed_to' => 0,
                        'note' => '',
                        ));
                        $this->getTicketLogCatalog()->create($ticketLog2);
                        
//                        $now = new \Zend_Date();
//                        $notification= new Notification();
//                        $idTemplate = (int) TemplateEmailQuery::create()->whereAdd(TemplateEmail::EVENT, EmailEvent::ticket_client.letter)->fetchOne();
//                        $fields2=array("id_template_email" => $idTemplate,"id_base_ticket"=>$ticket->getIdBaseTicket(),"created"=>$now->get('yyyy-MM-dd HH:mm:ss'));
//                        NotificationFactory::populate($notification, $fields2);
//                        $this->getNotificationCatalog()->create($notification);      
			$this->setFlash('ok', $this->i18n->_('The ticket has been assigned.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	/**
     * @module Ticket Client
     * @action Resolve
	 */
	public function resolveAction(){
		try {
			$params = $this->getRequest()->getParams();
			$pk = $this->getRequest()->getParam('id');
			$idClientResolution = $this->getRequest()->getParam('id_client_resolution');
			$note = $this->getRequest()->getParam('note');
			$recoveryAmount = str_replace(',','',$this->getRequest()->getParam('recovery_amount'));
			$isRecoveredAmount = (int) $this->getRequest()->getParam('is_recovered_amount');
			
			if($isRecoveredAmount == 2){
				$isRecoveredAmount  = 0;
			}
			$ticket = TicketClientQuery::create()->findByPK($pk);
			$params['id_base_ticket'] = $ticket->getIdBaseTicket(); 
			$resolution = ClientResolutionQuery::create()->findByPK($idClientResolution);
			$transaction = $this->getTransactions($pk);				
			$file = null;
			if(trim($_FILES['file']['name']) != ""){
				$path = $this->uploadPath . $idTicketClient . '/resolution/';
				$file = $this->saveFile('file', $path);
				$this->getFileCatalog()->create($file);
			}			
			//para ambos casos cambiar el rol
			//TODO falta asignar nuevamente al usuario marcado en base de datos, revisar que lo haga
			$idUserAssign = $this->getUserAclaration();
			if((int) $idUserAssign > 0){
				$user = UserQuery::create()->findByPK($idUserAssign);
				if((int) $resolution->getType() == 1 && !$this->getPGoodFaith($transaction)){
					$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
				}
				if((int) $resolution->getType() != 1 && $this->getPGoodFaith($transaction)){
					$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
				}
			}				
			$this->getTicketService()->resolveTicketClient($ticket,$resolution, $this->getUser()->getBean(), $note, null, $file,$recoveryAmount,$isRecoveredAmount);
			$this->buildPdf($params);			
			$this->setFlash('ok', $this->i18n->_('The ticket has been resolved.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('ticket-client/edit/id/'.$ticket->getIdTicketClient());
	}
	
	/**
     * @module Ticket Client
     * @action New
	 * @return json
	 */
	public function getClientInformationAction(){
		$params = $this->getRequest()->getParams();
		$result = $this->getClientInformation($params['account'], $params['clientNumber'], $params['rfc'], $params['name'],$params['last_name'],$params['middle_name']);
                if(!$result || $result['error']){
                    die(json_encode(array("error"=>($result['error'])?$result['error']:"")));
                }
        die(json_encode($result->toArray()));
	}
	
public function savePaymentAction(){
		$validaFolio = 1;
		$array = array();
		$idUserAssign = 0;
		$params = $this->getRequest()->getParams();
		if($this->getRequest()->isPost()){
			$regreso = 1;
			if( (int) $this->getUser()->getBean()->getIdAccessRole() == (int) AccessRole::JURIDICO){
				$regreso = 2;
			}				
			try{
				$id   = $params['id_transaction'];
				$tipo = $params['tipo'];
				$transaction = TicketsClientsTransactionsQuery::create()->findByPK($id);
				if($transaction != null){
					$ticket = TicketClientQuery::create()->findByPK($transaction->getIdTicketClient());
					$this->getTicketsClientsTransactionsCatalog()->beginTransaction();
					if($tipo == 1){
						if(!empty($params['good_faith_request']) && trim($params['good_faith_request']) != "undefined"){
							$transaction->setGoodFaithRequest(str_replace(',','',$params['good_faith_request']));
							$idUserAssign = $this->getUserAclaration();							
						}						
					}else{
						if(!empty($params['good_faith_payment']) && trim($params['good_faith_payment']) != "undefined"){
							$transaction->setGoodFaithPayment($params['good_faith_payment']);
							$idUserAssign = $ticket->getIdUserLastAssign(); //$this->getUserAssign($idAssign);
							$arrayFolio   = $this->getFolioInformation($params['good_faith_payment']);
							if((double)$arrayFolio['good_faith_payment'] == -1){
								$validaFolio = 0;
							}else{
								if((double)$arrayFolio['good_faith_amount'] != (double) $transaction->getGoodFaithRequest()){
									$validaFolio = 0;
									$arrayFolio['error'] = $this->i18n->_('Amounts do not match');
								}else{
									$transaction->setGoodFaithAmount(str_replace(',','',$arrayFolio['good_faith_amount']));
									$transaction->setGoodFaithDate($arrayFolio['good_faith_date']);
								}		
							}	
						}
					}
					if($validaFolio){
						$this->getTicketsClientsTransactionsCatalog()->update($transaction);
						/** para asignar al call center **/
						if((int) $idUserAssign > 0){
							$user = UserQuery::create()->findByPK($idUserAssign);
							$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
							$this->getTicketService()->updateLastAssign($ticket,$this->getUser()->getIdUser());
                                                        $now = \Zend_Date::now();
                                                        $userLog = $this->getUser()->getBean();
                                                        $ticketLog = TicketLogFactory::createFromArray(array(
                                                        'id_base_ticket' => $ticket->getIdBaseTicket(),
                                                        'id_user' => $userLog->getIdUser(),
                                                        'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                                                        'event_type' => TicketLog::$EventTypes['Update'],
                                                        'changed_from' => 0,
                                                        'changed_to' => 0,
                                                        'note' => '',
                                                        ));
                                                        $this->getTicketLogCatalog()->create($ticketLog);
                                                        $ticketLog2 = TicketLogFactory::createFromArray(array(
                                                        'id_base_ticket' => $ticket->getIdBaseTicket(),
                                                        'id_user' => $userLog->getIdUser(),
                                                        'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
                                                        'event_type' => TicketLog::$EventTypes['Assign'],
                                                        'changed_from' => 0,
                                                        'changed_to' => 0,
                                                        'note' => '',
                                                        ));
                                                        $this->getTicketLogCatalog()->create($ticketLog2);
						}
						$this->getTicketsClientsTransactionsCatalog()->commit();
						$array = array('exito' => 1, 'mensaje' => $this->i18n->_('Data saved correctly'),
								'good_faith_date'    => $arrayFolio['good_faith_date'],
								'good_faith_amount'  => $arrayFolio['good_faith_amount'],
								'good_faith_payment' => $arrayFolio['good_faith_payment'],'url' => $regreso);
					}else{
						$array = array('exito' => 0, 'mensaje' => $arrayFolio['error'],
								'good_faith_date'    => $arrayFolio['good_faith_date'],
								'good_faith_amount'  => $arrayFolio['good_faith_amount'],
								'good_faith_payment' => $arrayFolio['good_faith_payment'],'url' => $regreso);
					}
				}
			}
			catch(Exception $e){
				$this->getTicketsClientsTransactionsCatalog()->rollBack();
				$array = array('exito' => 0, 'mensaje' => $e->getMessage());
			}			
		}
		die(json_encode($array));
	}
	
	/**
	 * Metodo para salvar los datos del formulario de todos los tipos menos el 8
	 */
	public function saveTypesAction(){
		$validaFolio = 1;
		$array = array();
		$file  = null;
		$params = $this->getRequest()->getParams();
		if($this->getRequest()->isPost()){
			try{
				$id = $params['id_transaction'];
				$transaction = TicketsClientsTransactionsQuery::create()->findByPK($id);
				if($transaction != null){
					$fileField = "file_payment";
					$path = $this->uploadPath . '/' . $transaction->getIdTicketClient(). '/';
					if(!empty($_FILES[$fileField]['name'])){
						$file 		 = $this->saveFile($fileField ,$path, null);
					}
					if($file instanceof File){
						$this->getFileCatalog()->create($file);
						$transaction->setFilePayment($file->getIdFile());
					}
					$fileField = "file_delivery";
					$path = $this->uploadPath . '/' . $transaction->getIdTicketClient(). '/';
					if(!empty($_FILES[$fileField]['name'])){
						$file = $this->saveFile($fileField ,$path, null);
					}
					if($file instanceof File){
						$this->getFileCatalog()->create($file);
						$transaction->setFileDelivery($file->getIdFile());
					}
										
					$this->getTicketsClientsTransactionsCatalog()->beginTransaction();
					if(empty($params['id_controversy_chargeback_d']) && empty($params['id_controversy_chargeback_t'])){
						$transaction->setIdControversyChargeback(null);						
					}
					if(!empty($params['id_controversy_chargeback_d']) && empty($params['id_controversy_chargeback_t'])){
						$transaction->setIdControversyChargeback($params['id_controversy_chargeback_d']);
					}
					if(empty($params['id_controversy_chargeback_d']) && !empty($params['id_controversy_chargeback_t'])){
						$transaction->setIdControversyChargeback($params['id_controversy_chargeback_t']);
					}
					if(!empty($params['id_controversy_chargeback_d']) && !empty($params['id_controversy_chargeback_t'])){
						$transaction->setIdControversyChargeback(null);
					}
					/*if(!empty($params['id_controversy_reason']) && trim($params['id_controversy_reason']) != "undefined"){
						$transaction->setIdControversyChargeback($params['id_controversy_reason']);
					}*/
					if(!empty($params['payment_request_date']) && trim($params['payment_request_date']) != "undefined"){
						$transaction->setPaymentRequestDate($params['payment_request_date']);
					}
					if(!empty($params['payment_delivery_date']) && trim($params['payment_delivery_date']) != "undefined"){
						$transaction->setPaymentDeliveryDate($params['payment_delivery_date']);
					}
					if(trim($params['accepted_payment']) != "undefined"){
						$params['accepted_payment'] = (int) $params['accepted_payment'];
						$transaction->setAcceptedPayment((int)$params['accepted_payment']);
					}
					if(trim($params['delivery_payment']) != "undefined"){
						$params['delivery_payment'] = (int) $params['delivery_payment'];
						$transaction->setDeliveryPayment((int)$params['delivery_payment']);
					}
					if($validaFolio){	
						$this->getTicketsClientsTransactionsCatalog()->update($transaction);
						$this->getTicketsClientsTransactionsCatalog()->commit();
						$array = array('exito' => 1, 'mensaje' => $this->i18n->_('Data saved correctly'));
					}else{
						$array = array('exito' => 0, 'mensaje' => $this->i18n->_('Amounts do not match'));
					}
				}
			}
			catch(Exception $e){
				$this->getTicketsClientsTransactionsCatalog()->rollBack();
				$array = array('exito' => 0, 'mensaje' => $e->getMessage());
			}
		}
		die(json_encode($array));
	
	}
	
	private function getUserAssign($idAssign){
		try{
			$assign = AssignmentQuery::create()->findByPK($idAssign);
			return $assign->getIdUser();
		}catch(Exception $e){
			return 0;		
		}
		return 0;
	}
	private function getUserAclaration(){
		try{
			$group = GroupQuery::create()->whereAdd(Group::ACL,1)->findOne();
			if ($group != null){
				return $group->getIdUserAssignedForTickets();
			}
		}catch(Exception $e){
			return 0;		
		}
		return 0;
	}
	
	/**
	 * Metodo que construye las preguntas
	 */ 
	private function buildQuestions($result){
		$array = array();
		if(count($result)> 0){
			foreach($result as $tmp){
				$array[1] = $this->i18n->_('RFC')+"|"+$tmp['rfc'];
				$array[2] = $this->i18n->_('BIRTHDATE')+"|"+$tmp['birthday'];
				$array[3] = $this->i18n->_('HOME PHONE')+"|"+$tmp['home_phone'];
				$array[4] = $this->i18n->_('MOBILE PHONE')+"|"+$tmp['mobile_phone'];
				$array[5] = $this->i18n->_('DOMICILE')+"|"+$this->i18n->_('Street')." - ".$tmp['street']+"$"+
														   $this->i18n->_('External number')." - ".$tmp['external_number']+"$"+
														   $this->i18n->_('Internal number')." - ".$tmp['internal_number']+"$"+
														   $this->i18n->_('Colony')." - ".$tmp['colony']+"$"+
														   $this->i18n->_('Town')." - ".$tmp['town']+"$"+
														   $this->i18n->_('Zip code')." - ".$tmp['zip_code']+"$"+
														   $this->i18n->_('State')." - ".$tmp['state'];
			}
		}
		return $array;
	}
	
	
	private function getFolioInformation($folio){
            $ws= new WSClient();
            $data=$ws->getBuenafe($folio);
            if(trim($data['datosAbonoBuenaFe']['fechaAbono'])!= ""){
            	$fecha=explode("/",$data['datosAbonoBuenaFe']['fechaAbono']);
            	return array('good_faith_date' => $fecha[2]."-".$fecha[1]."-".$fecha[0], 'good_faith_amount' => $data['datosAbonoBuenaFe']['cantidadAbono'],'good_faith_payment' => $folio,'error' => '');            	 
            }else{ 
				return array('good_faith_date' => null, 'good_faith_amount' => -1,'good_faith_payment' => -1, 'error' => $data['error']);            
            }
	}
	
	/**
	 * <ul>Array members: <li>account</li><li>clientNumber</li><li>rfc</li><li>name</li></ul>
	 * @return \Application\Model\Collection\ClientDataCollection
	 * @param array $params
	 * @author jlsn
	 *
	 */
	private function getClientInformation($account = null, $clientNumber = null, $rfc = null, $name = null, $lastName= null, $middleName= null, $folio = null){		
            if(!empty($account) || !empty($clientNumber) || !empty($rfc) || !empty($name) || !empty($lastName) || !empty($middleName)){
			$WSClient = new WSClient();
			if($WSClient->getError()){
            	return array("error"=>$WSClient->getError());
            }
			$result = $WSClient->getInformationByMixedSearch($account, $clientNumber, $rfc, $name,$lastName,$middleName,$folio);
			return $result;
        }else return new ClientDataCollection();
	}
	
	/**
	 * Metodo para consultar los productos al web service
	 */
	public function getProductInformationAction(){
		$tmp = "";
		if($this->getRequest()->isPost()){
			$products      = ProductsQuery::create()->addColumns(array(Products::ID_PRODUCT_BAM,Products::ID_PRODUCT))->fetchPairs();
			$clientNumber  = $this->getRequest()->getParam('clientNumber');
			$clientAccount = $this->getRequest()->getParam('clientAccount');		
			$result = $this->getAccountInformation($clientNumber);			
            
            if($result['error'])
               die(json_encode(array("error"=>($result['error'])?$result['error']:"")));
			if(trim($clientAccount) != ""){			
				$resultP = $this->getProductInformation($clientAccount);
            	if($resultP['error'])
                	die(json_encode(array("error"=>($resultP['error'])?$resultP['error']:"")));
				$resultsP= $resultP->toArray();
			}
			if($result->count()){
				$results = $result->toArray();
				foreach ($results as $k =>  $r){
					$results[$k]['clientNumber'] = $clientNumber;
					if(trim($clientAccount) != ""  && $clientAccount == $r['account'] && count($resultsP)> 0){
						$tmp="";
						foreach($resultsP as $tmpResult){			
							$tmp .= $products[$tmpResult['id_bam']]."|".$tmpResult['name']."|".$tmpResult['id_bam']."|".$tmpResult['no_tarjeta']."*";							
						}						
					}
					$results[$k]['p'] = $tmp;
				}
				die(json_encode($results));
			}				
			else die (null);
		}
	}
	
	
	/**
     * @module Ticket Client
     * @action New
	 * @return json
	 */
	public function getAccountInformationAction(){
		$tmp = "";
		if($this->getRequest()->isPost()){
			$products      = ProductsQuery::create()->addColumns(array(Products::ID_PRODUCT_BAM,Products::ID_PRODUCT))->fetchPairs();
			$clientNumber  = $this->getRequest()->getParam('clientNumber');
			$clientAccount = $this->getRequest()->getParam('clientAccount');
			$result = $this->getAccountInformation($clientNumber);
			if(trim($clientAccount) != ""){
				$resultP = $this->getProductInformation($clientAccount);
				$resultsP= $resultP->toArray();
				
			}
            if($result['error'])
				die(json_encode(array("error"=>($result['error'])?$result['error']:"")));
			if($result->count()){
				$results = $result->toArray();
				foreach ($results as $k =>  $r){
					$results[$k]['clientNumber'] = $clientNumber;
					if(trim($clientAccount) != ""  && $clientAccount == $r['account'] && count($resultsP)> 0){
						$tmp="";
						foreach($resultsP as $tmpResult){
							$tmp .= $products[$tmpResult['id_bam']]."|".$tmpResult['name']."|".$tmpResult['id_bam']."|".$tmpResult['no_tarjeta']."*";
						}						
					}
					$results[$k]['p'] = $tmp;
				}
				die(json_encode($results));
			}				
			else 
                            die (null);
		}
	}
		
	/**
	 * <ul>Array members:<li>clientNumber</li></ul>
	 * @return \Application\Model\Collection\ClientAccountCollection
	 * @param array $params
	 * @author jlsn
	 */
	private function getAccountInformation($clientNumber){
		if(!empty($clientNumber)){
			$WSClient = new WSClient();
			if($WSClient->getError()){            
            	return array("error"=>$WSClient->getError());
			}
			$result = $WSClient->getAccountInformation($clientNumber);
			return $result;
		}else{
			return new ClientAccountCollection();
		}
	}
	
	
	
	private function getProductInformation($clientAccount){
		if(!empty($clientAccount)){
			$WSClient = new WSClient();
            if($WSClient->getError()){
            	return array("error"=>$WSClient->getError());
            }
			$result = $WSClient->getProductInformation($clientAccount);
			return $result;
		}else{
			return new ProdCollection();
		}		
	}
	
	
	/**
	 * Metodo para obtener las transaciones del web service
	 */
	public function getTransactionsInformationAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$fechas = self::buildDates($params);
			if((int)$params['movments'] === -1){
				$result = $this->getTransactionsClient($params['clientNumber'],$params['clientAccount'],$fechas[0],$fechas[1], $params['clientIdProduct']);				
			}
			else{ 
				$result = $this->getTransactionsClientNumber($params['clientAccount'],$params['clientIdProduct'],$params['movments']);
			}
            if($result['error'])
            	die(json_encode(array("error"=>($result['error'])?$result['error']:"")));
            else
				die(json_encode($result->toArray()));
		}else{
			die(null);
		}
	}
	

	/**
	 * Metodo que regresa el saldo
	 */
	public function getSaldoInformationAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$result = $this->getSaldoClient($params['clientAccount']);
                        if($result['error'])
                        die(json_encode(array("error"=>($result['error'])?$result['error']:"")));
                        else
			die(json_encode($result));
		}else{
			die(null);
		}
	}
	
	/**
	 * Metodo que guarda gtemporalmente los datos del deposito de la transaccion
	 */
	public function depositTransactionAction(){
		$array = array();
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$path = $this->uploadPath."/tmps/";
			$array = $this->saveFileTmp('fileDeposit', $path,$params);
		}
		die(json_encode($array));
	}
	
	
	private function getTransaccionId($idTransaction){
		if((int) $idTransaction > 0){
			$WSClient = new WSClient();
			$result = $WSClient->getTransactionIdInformation($idTransaction);
			return $result;
		}else{
			return new TransactionsCollection();
		}
	}
        
        public function commentsAction(){
	}
	
	private function getTransactionsClient($clientNumber,$clientAccount,$fechaInicio,$fechaFin, $idProd){
		if(!empty($clientNumber) && !empty($clientAccount) && !empty($fechaInicio) && !empty($fechaFin)){
			$WSClient = new WSClient();
			if($WSClient->getError()){
            	return array("error"=>$WSClient->getError());
            }
			$result = $WSClient->getTransactionInformation($clientNumber, $clientAccount,$fechaInicio,$fechaFin, $idProd);
			return $result;
		}else{
			return new TransactionsCollection();
		}		
	}
	
	private function getTransactionsClientNumber($clientAccount,$idProd,$movments){		
			if(!empty($clientAccount) && (int) $idProd >= 0 && (int) $movments != -1){
			$WSClient = new WSClient();
                        if($WSClient->getError()){
                            return array("error"=>$WSClient->getError());
                        }                        
			$result = $WSClient->getTransactionInformationNumber($clientAccount, $idProd, $movments);
			return $result;
		}else{
			return new TransactionsCollection();
		}
	}
		
	private function getSaldoClient($clientAccount){
		$result = array();
		if(!empty($clientAccount)){
			$WSClient = new WSClient();
                        if($WSClient->getError()){
                            return array("error"=>$WSClient->getError());
                        }
			$result = $WSClient->getSaldo($clientAccount);
			return $result;				
		}else{
			return $result;
		}
	}
	
	/**
	 * Metodo para obtener las motivos en base a los productos
	 */
	public function getReasonsInformationAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			if((int) $params['clientIdProduct'] > 0 && (int) $params['idTicketType'] > 0 ){
				if((int) $params['idTicketType'] == 2 || (int) $params['idTicketType'] == 3 || (int) $params['idTicketType'] == 4){					
					$reasons = ClientCategoryQuery::create()->innerJoinClientCategoriesProducts()
							  ->addColumns(array("ClientCategory.".ClientCategory::ID_CLIENT_CATEGORY,"ClientCategory.".ClientCategory::NAME,"ClientCategory.".ClientCategory::FINANCIAL_MOVEMENT,"ClientCategory.".ClientCategory::PARTIALITIES,"ClientCategory.".ClientCategory::TYPE,"ClientCategory.".ClientCategory::MOVMENTS))
							  ->whereAdd("ClientCategory.".ClientCategory::IS_LEAF, 1)
							  ->whereAdd("ClientCategory.".ClientCategory::STATUS, 1)
							  ->whereAdd("ClientCategory.".ClientCategory::ID_TICKET_TYPE, $params['idTicketType'])
							  ->whereAdd("ClientCategoriesProducts.".ClientCategoriesProducts::ID_PRODUCT,$params['clientIdProduct']);
					if((int) $params['idTicketType'] == 3){
						$reasons = $reasons->whereAdd("ClientCategory.".ClientCategory::TYPE,4);
					}
					$reasons = 	$reasons->fetchAll();	
				}else{
					$reasons = ClientCategoryQuery::create()
							->addColumns(array(ClientCategory::ID_CLIENT_CATEGORY,ClientCategory::NAME,ClientCategory::FINANCIAL_MOVEMENT,ClientCategory::PARTIALITIES,ClientCategory::TYPE,ClientCategory::MOVMENTS))
							->whereAdd(ClientCategory::IS_LEAF, 1)
							->whereAdd(ClientCategory::STATUS, 1)
							->whereAdd(ClientCategory::ID_TICKET_TYPE, $params['idTicketType'])
							->fetchAll();
					
				}
				if (count($reasons)>0){
					foreach ($reasons as $key => $value){
						$reasons[$key]['name'] = utf8_encode($reasons[$key]['name']);
					}
				}
				die(json_encode($reasons));
			}else{
				die (null);
			}
		}else{
				die (null);
		}	
	}
	
	/**
	 * Metodo para enviar el formato de ticket por correo
	 */
	public function sendingEmailInformationAction(){
		if($this->getRequest()->isPost()){
			$idTicketClient = (int) $this->getRequest()->getParam("id_ticket_client");
			if($idTicketClient > 0){
				
			}			
		}
	}
	
	/**
     * @module Ticket Client
     * @action New
	 * @return json
	 */
	public function getRequiredFieldsAction(){
		if($this->getRequest()->isPost()){
			$idClientCategory = $this->getRequest()->getParam('id_client_category');
			$result = $this->getRequiredFields($idClientCategory);
			die(json_encode(!empty($result) ? $result : null));
		}
	}
	
	/** 
	 * Metodo que construya las fechas de inicio y fin para consultar transacciones
	 * @param unknown $params
	 */
	private function buildDates($params){
		$fecha = array();
		$fecha[0] = $params['clientStartDate'];
		$fecha[1] = $params['clientEndDate'];		
		if ( (int) $params['clientPeriod'] > 0 ){
			switch((int) $params['clientPeriod']){
				case 1:
					$tmpp = strtotime ( '- 0 day' , strtotime ( date("Y-m-d") ) );
					break;
				case 2:
					$tmpp = strtotime ( '- 6 day' , strtotime ( date("Y-m-d") ) );
					break;
				case 3:
					$tmpp = strtotime ( '- 29 day' , strtotime ( date("Y-m-d") ) );
					break;
				case 4:
					$tmpp = strtotime ( '- 89 day' , strtotime ( date("Y-m-d") ) );
					break;
				case 5:
					$tmpp = strtotime ( '- 179 day' , strtotime ( date("Y-m-d") ) );
					break;
				default:
					$tmpp = strtotime ( '- 0 day' , strtotime ( date("Y-m-d") ) );
					break;						
			}
			$fecha[0] = date ( 'Y-m-d' , $tmpp );
			$fecha[1] = date("Y-m-d");				
		}
		$fecha[0] = $fecha[0]." 00:00:01";
		$fecha[1] = $fecha[1]." 23:59:59";
		return $fecha;
	}
	/**
	 *
	 * @param int $idClientCategory
	 */
	private function getRequiredFields($idClientCategory, $encode = true){
		if(!empty($idClientCategory)){
			$columns = array(
					'Field.'.Field::NAME,
					'Field.'.Field::ID_FIELD,
					'Field.'.Field::REG_EX,
					'Field.'.Field::SAMPLE,
			);
			$result = RequiredFieldQuery::create()
			->addColumns($columns)
			->innerJoinField()
			->whereAdd(RequiredField::ID_CLIENT_CATEGORY, $idClientCategory)
			->fetchAll();
			if ($encode){
				foreach ($result as $key => $value){
					$result[$key]['name'] = utf8_encode($value['name']);
				}	
			}
			return $result;
		}else return array();
	}
	/**
     * @module Ticket Client
     * @action New
	 * @return json
	 */
	public function getRequiredDocumentsAction(){
		if($this->getRequest()->isPost()){
			$idClientCategory = $this->getRequest()->getParam('id_client_category');
			$result = $this->getRequiredDocuments($idClientCategory);
			die(json_encode(!empty($result) ? $result : null));
		}
	}
	/**
	 *
	 * @param int $idClientCategory
	 * @return multitype:
	 */
	private function getRequiredDocuments($idClientCategory, $encode = true){
		if(!empty($idClientCategory)){
			$columns = array(
					'Document.'.Document::NAME,
					'Document.'.Document::ID_DOCUMENT,
			);
			$result = RequiredDocumentQuery::create()
			->addColumns($columns)
			->innerJoinDocument()
			->whereAdd(RequiredField::ID_CLIENT_CATEGORY, $idClientCategory)
			->fetchAll();
			if($encode){
				foreach ($result as $key => $value){
					$result[$key]['name'] = utf8_encode($value['name']);
				}				
			}
			return $result;
		}else return array();
	}
	/**
	 * Uploads the file and returns an \Application\Model\Bean\File
	 * @author joseluis
	 * @param String $fileField
	 * @param String $path
	 * @return \Application\Model\Bean\File if success, false otherwise
	 */
	private function saveFile($fileField ,$path, $name = null){
		$type = $_FILES[$fileField]['type'];
		$originalName =  $_FILES[$fileField]['name'];
		if($type){
			try{
				$uploadPath = 'public/uploads/'.$path;
				$fileUploader = new FileUploader($fileField);
				if (strstr($type, "image") != false ) {
					$folder = 'images';
					$uploadPath.= $folder;
					$fileUploader->saveFile($uploadPath, false);
					$fileType = 1;
				}
				else {
					$folder = 'files';
					$uploadPath.=$folder;
					$fileUploader->saveFile($uploadPath, false);
					$fileType = 2;
				}
				$myFile = new File();
				$myFile->setUri($uploadPath.$fileUploader->getFileName());
				$myFile->setOriginalName($originalName);
				return $myFile;
			}catch(Exception $e){
				throw $e;
			}
		}
	}
	
	
	/**
	 * Uploads the file and returns an \Application\Model\Bean\File
	 * @author joseluis
	 * @param String $fileField
	 * @param String $path
	 * @return \Application\Model\Bean\File if success, false otherwise
	 */
	private function saveFileTmp($fileField ,$path, $params){
		$array = array();
		$uriTmp = $namTmp = "";
		try{
			if(trim($_FILES[$fileField]['name']) != ''){
				$type 		  = $_FILES[$fileField]['type'];
				$originalName = $_FILES[$fileField]['name'];				
				$uploadPath = 'public/uploads/'.$path;
				$fileUploader = new FileUploader($fileField);
				if (strstr($type, "image") != false ) {
					$folder = 'images';
					$uploadPath.= $folder;
					$fileUploader->saveFileTmp($uploadPath, false);
				}
				else {
					$folder = 'files';
					$uploadPath.=$folder;
					$fileUploader->saveFileTmp($uploadPath, false);
				}
				$uriTmp = $uploadPath.$fileUploader->getFileName();
				$namTmp = $originalName;
			}
			$this->getFileTmpCatalog()->beginTransaction();
			$fileTmp = FileTmpQuery::create()->whereAdd(FileTmp::ID_TRANSACTION, $params['id_transaction'])->findOne();
			if(count($fileTmp) == 0){
				$params['amount_deposit'] = str_replace(",","",$params['amount_deposit']);
				$params['amount_deposit'] = (double)$params['amount_deposit'] *(-1);
				$myFile = new FileTmp();
				$myFile->setUri($uriTmp);
				$myFile->setOriginalName($namTmp);
				$myFile->setIdTransaction($params['id_transaction']);
				$myFile->setTypeDeposit($params['type_deposit']);
				$myFile->setAmountDeposit($params['amount_deposit']);
				$myFile->setDateDeposit($params['date_deposit']);
				$myFile->setIdSession($this->getUser()->getBean()->getIdUser());
				$this->getFileTmpCatalog()->create($myFile);
			}else{
				$params['amount_deposit'] = str_replace(",","",$params['amount_deposit']);
				$params['amount_deposit'] = (double)$params['amount_deposit'] *(-1);
				
				$fileTmp->setUri($uriTmp);
				$fileTmp->setOriginalName($namTmp);
				$fileTmp->setIdTransaction($params['id_transaction']);
				$fileTmp->setTypeDeposit($params['type_deposit']);
				$fileTmp->setAmountDeposit($params['amount_deposit']);
				$fileTmp->setDateDeposit($params['date_deposit']);
				$fileTmp->setIdSession($this->getUser()->getBean()->getIdUser());
				$this->getFileTmpCatalog()->update($fileTmp);				
			}
			$this->getFileTmpCatalog()->commit();
			$array['exito']   = 1;
			$array['mensaje'] = $this->i18n->_('Partition saved');
		}catch(Exception $e){
			$this->getFileTmpCatalog()->rollBack();
			$array['exito']   = 0;
			$array['mensaje'] = $e->getMessage();
			die($e->getMessage());
		}
		return $array;
	}	
	/**
	 *
	 * @param string $filepath
	 * @return boolean
	 */
	private function deleteFile($filepath){
		$return = false;
		if (file_exists($filepath)){
			unlink($filepath);
			$return = true;
		}
		return $return;
	}
	/**
     * @module Ticket Client
     * @action New
	 */
	public function getFieldRulesAction(){
		$columns = array(Field::ID_FIELD);
		$results = FieldQuery::create()->addColumns($columns)->actives()->fetchAll();
		die(json_encode($results));
	}
	
	
	public function getPartitialInformationAction(){
		$fileTmp = null;
		$params = $this->getRequest()->getParams();
		if($this->getRequest()->isPost()){
			$tmp = FileTmpQuery::create()->whereAdd(FileTmp::ID_TRANSACTION,$params['idTransaction'])->findOne();
			$fileTmp = $tmp->toArray();
		}
		die(json_encode($fileTmp));
	}
	
	/**
	 * 
	 * @param date $startDate
	 * @param date $endDate
	 */
	private function getReport($startDate, $endDate){
		$WSClient = new WSClient();
		$ticketClients = TicketClientQuery::create()
		->whereAdd(TicketClient::CREATED, $startDate, TicketClientQuery::GREATER_OR_EQUAL)
		->whereAdd(TicketClient::CREATED, $endDate, TicketClientQuery::LESS_OR_EQUAL)
		->orderBy(TicketClient::ID_TICKET_CLIENT,TicketClientQuery::DESC)
		->find();
		if (!$ticketClients->count()){
			$this->setFlash('error', $this->i18n->_('No records found'));
			$this->_redirect('ticket-client/report');
		}
		$report = new SimpleListReport();
		$filename = 'reporte-R27';
		$tableTitle = 'Reporte R27';
		$tableHeaders = array(
				'PERIODO QUE SE REPORTA',
				'CLAVE DE LA ENTIDAD',
				'CLAVE DEL FORMULARIO',
				'NÚMERO DE SECUENCIA',
				'FOLIO RECLAMACIÓN',
				'FECHA DE RECLAMACIÓN',
				'FECHA DE SUCESO',
				'NÚMERO DE CUENTA/NÚMERO DE TDC/NÚMERO DE TDD/NÚMERO DE TPB',
				'PRODUCTO',
				'CANAL EN EL CUAL SE REALIZO LA TRANSACCIÓN NO RECONOCIDA',
				'MOTIVO DE LA RECLAMACIÓN',
				'IMPORTE RECLAMADO',
				'ESTADO DE LA RECLAMACIÓN',
				'RESOLUCIÓN',
				'FECHA DE RESOLUCIÓN',
				'CAUSA DE RESOLUCIÓN',
				'IMPORTE ABONADO AL CLIENTE',
				'FECHA ABONO AL CLIENTE',
				'IMPORTE RECUPERADO',
				'QUEBRANTO PARA LA INSTITUCIÓN',
		);
		$i = 1;
		$tableContent = array();
		try {
			while ($ticketClient = $ticketClients->read()){
				$statuses = array_flip(TicketClient::$Statuses);
				$claimStatuses = TicketClient::$R27ClaimStatus;
				$R27Resolutions = ClientResolution::$R27Resolution;
				$claimStatus = ($ticketClient->getStatus() == $statuses['Closed'] ||
						$ticketClient->getStatus() == $statuses['Canceled'] ||
						$ticketClient->getStatus() == $statuses['Resolved']) ?
						$claimStatuses['Closed'] :
						$claimStatuses['Pending'];
				if ($claimStatus == $claimStatuses['Closed'] && $ticketClient->getIdAssignment() >= 0){
					if ($ticketClient->getIdAssignment()){
						$assignment = AssignmentQuery::create()->findByPK($ticketClient->getIdAssignment());
						if ($assignment->getIdResolution())
							$clientResolution = ClientResolutionQuery::create ()->findByPK ($assignment->getIdResolution());
						else
							$clientResolution = new ClientResolution();
						
					}
					else {
						$assignment = new Assignment();
						$clientResolution = new ClientResolution();
					}
					$resolution = $clientResolution->getType() == ClientResolution::$Type['Favorable'] ?
					$R27Resolutions['Favorable'] :
					$R27Resolutions['Unfavorable'];
			
					$resolutionDate = $assignment->getResolutionDateAsZendDate()->toString('yyyyMMdd');
				}
				else {
					$resolutionDate = 'N/A';
					$resolution = $R27Resolutions['Pending'];
				}
				$clientInformation = $this->getClientInformation($ticketClient->getAccountNumber());
				if (!$clientInformation->count()){
					$nullProduct = new ClientData();
					$clientInformation->append($nullProduct);
				}
				$clientNumber = $clientInformation->getOne()->getClientNumber();
				$accountInformation = $this->getAccountInformation($clientNumber);
				$product = $accountInformation->getByAccountNumber($ticketClient->getAccountNumber());
				if (!($product instanceof ClientAccount)){
					$product = new ClientAccount();
					$product->setType('N/A');
				}
				$tableContent[$i] = array(
						'N/A',//'PERIODO QUE SE REPORTA'
						'N/A',//'CLAVE DE LA ENTIDAD'
						'2701',//'CLAVE DEL FORMULARIO'
						$i,//'NÚMERO DE SECUENCIA'
						$ticketClient->getFolio(),//'FOLIO RECLAMACION'
						$ticketClient->getCreatedAsZendDate()->toString('yyyyMMdd'),//'FECHA DE RECLAMACIÓN'
						'N/A',//'FECHA DE SUCESO'
						$ticketClient->getAccountNumber(),//'NÚMERO DE CUENTA/NÚMERO DE TDC/NÚMERO DE TDD/NÚMERO DE TPB'
						$product->getType(),//'PRODUCTO'
						'N/A',//'CANAL EN EL CUAL SE REALIZO LA TRANSACCION NO RECONOCIDA'
						$ticketClient->getCategoryName(),
						'N/A',//'IMPORTE RECLAMADO'
						$claimStatus,//'ESTADO DE LA RECLAMACIÓN'
						$resolution,//'RESOLUCIÓN'
						$resolutionDate,//'FECHA DE RESOLUCIÓN'
						'N/A',//'CAUSA DE RESOLUCIÓN'
						'N/A',//'IMPORTE ABONADO AL CLIENTE'
						'N/A',//'FECHA ABONO AL CLIENTE'
						'N/A',//'IMPORTE RECUPERADO'
						'N/A',//'QUEBRANTO PARA LA INSTITUCION'
				);
				$i++;
			}
		}catch (Exception $e){
// 			echo $e->getMessage();
		}
		
		$report->setTableTitle($tableTitle);
		$report->setTableContent($tableContent);
		$report->setTableHeaders($tableHeaders);
		$report->setTableHeadersHeight(3);
		$report->setFilename($filename);
		$report->createSpreadsheet();
		die;
	}
	/**
     * @module Ticket Client
     * @action Get Report
	 */
	public function reportAction(){
		if ($this->getRequest()->isPost()){
			$endDate = $this->getRequest()->getParam('end_date');
			$startDate = $this->getRequest()->getParam('start_date');
			if (!empty($endDate) && !empty($startDate))
				$this->getReport($startDate, $endDate);
		}
	}

	/**
	 * Modulo para guardar el folio en reopen
	 */
	
	public function setFolioCondusefAction(){
		$array ['exito'] = 0;
		$params = $this->getRequest()->getParams();
		$id = $params['idTicketClient'];
		if( (int) $id > 0  && (int) $params['channel']>0 ){
				$ticketClient = TicketClientQuery::create()->findByPK($id);
				$this->getTicketService()->updateCondusef($ticketClient,$params['folioCondusef'],$params['channel']);
				$array['exito'] = 1;
		}
		
		die(json_encode($array));	
	}
	
	private function sumTransactions($transactionBd){
		$amount = 0;
		if(count($transactionBd) > 0){
			foreach($transactionBd as $tmpArray){
				if(trim($tmpArray['ammount_p']) != ''){
					$amount = $amount + (double) $tmpArray['ammount_p'] + 0;
				}else{
					$amount = $amount + (double) $tmpArray['amount'] + 0;
				}
			}
		}
		return $amount;
	}
	private function buildString($array){            		
        $total=count($array);                
		$buffer2 = "{";
		if($total > 0){
                    $i=1;
			foreach($array as $key => $value){
                                $add=($i<$total)?",":"";
				$buffer2.= '"'.$key.'":"'.$value.'"'.$add;
                                $i++;        
			}
                        $i++;
		}
                $buffer2.="}";
		return $buffer2;
	}
	private function buildStringTransaction($array){                
        $totalGeneral=count($array);
		if( $totalGeneral > 0){
                    $n=1;
                    $buffer2 = '{"transactions":{';
                        foreach($array as $id => $tmp){
                            $buffer2 .='"'.$id.'":{';
                            $total=count($tmp);
                            $i=1;
                                foreach($tmp as $key => $value){
                                    $add=($i<$total)?",":"";
                                    $buffer2.= '"'.$key.'":"'.$value.'"'.$add;
                                    $i++;        
                                }
                            $coma=($n<$totalGeneral)?",":"";    
                            $buffer2 .= '}'.$coma;    
                            $n++;
                        }
                    $buffer2.= "}}";    
		}
                
		return $buffer2;
	}
        
	private function buildStringResolution($array){
		$buffer = "";
		$totalGeneral=count($array);
		if( $totalGeneral > 0){
			foreach($array as $key => $value){
				$buffer .= $key.":".$value."|";
			}
		}
		return $buffer;
	}
	
	private function buildStringDocuments($array){
		$buffer = "";
		$totalGeneral=count($array);
		if( $totalGeneral > 0){
			foreach($array as $key => $value){
				$buffer .= $value['name']."|";
			}				
		}
		return $buffer;
	}

	/**
	 * Metodo
	 */
	public function reportPdfAction(){
		$params = $this->getRequest()->getParams();
		$params['templateEmail'] = (int) TemplateEmailQuery::create()->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_FORMAT_ACL)->fetchOne();		
		$params['ajaxJason'] = 1;
		$information = json_decode($params['clientInformation'],true);
		$transaction = json_decode($params['clientTransaction'],true);
		$documents   = explode('|',$params['clientDocuments']);
		$this->getTicketService()->updateEmail($params);
		$this->report($params, $information, $transaction,$documents,0);		
	}
	
	private function getTransactions($id){
			$transaction_q="SELECT a.*,convert(varchar,a.transaction_date, 103) as transaction_date_v,b.amount as ammount_p   FROM ".TicketsClientsTransactions::TABLENAME." a "
				. "LEFT JOIN ".TransactionsPartialities::TABLENAME." b ON a.id_ticket_client_transaction=b.id_ticket_client_transaction WHERE ".TicketsClientsTransactions::ID_TICKET_CLIENT."=".$id;
			return $this->getTicketClientFieldCatalog()->getDb()->fetchAll($transaction_q);
	}
	
	private function buildPdf($params){
		$params['format']    = 2;
		$params['type']      = 3;
		$params['ajaxJason'] = 0;
		$idTemplate          = (int) TemplateEmailQuery::create()->addColumn(TemplateEmail::ID_TEMPLATE_EMAIL)->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_LETTER)->fetchOne();
		$params['templateEmail'] = $idTemplate;		
		$information = TicketClientQuery::create()->findByPK($params['id'])->toArray();
        $reason      =  ClientCategoryQuery::create()->addColumn(ClientCategory::NAME)->findByPK($information['id_client_category']);
		$information['reason_name']=$reason->getName();
		$assigmentId = AssignmentQuery::create()->findByPK($information['id_assignment']);
        $assigment   = AssignmentQuery::create()->addColumns(array("Assignment.note","Resolution.name"))
                        ->innerJoinResolution2()->whereAdd(Assignment::ID_ASSIGNMENT,$information['id_assignment'])->fetchAll();
        $information['dictamen']=(count($assigment)>0)?$assigment[0]['name']:'';
        $information['desc_dictamen']=(count($assigment)>0)?$assigment[0]['note']:'';
        $information['fecha_asignacion'] = $assigmentId->getAssignmentDate();
        $transaction_q="SELECT a.*,convert(varchar,a.transaction_date, 103) as transaction_date_v,b.amount as ammount_p   FROM ".TicketsClientsTransactions::TABLENAME." a "
                        . "LEFT JOIN ".TransactionsPartialities::TABLENAME." b ON a.id_ticket_client_transaction=b.id_ticket_client_transaction WHERE ".TicketsClientsTransactions::ID_TICKET_CLIENT."=".$params['id'];
		$transaction=$this->getTicketClientFieldCatalog()->getDb()->fetchAll($transaction_q);                
        
        $ticket      = TicketClientQuery::create()->findByPK($params['id']);
        $userRegTick = UserQuery::create()->findByPK($ticket->getIdUser());
        $documents   = $this->getRequiredDocuments($information['id_client_category'],false);
		$documents   = self::buildStringDocuments($documents);
		$documents   = explode('|',$documents);
		$emailResponsableAcl = $this->getTicketService()->getEmailUser();
		$emailResponsable = $this->getTicketService()->getEmailUserLogueado($userRegTick);
		if(trim($information['email']) != ""){
			$params['emailClient'] = $params['emailClient'] = $information['email']; 
		}else{
			$params['emailClient'] = $emailResponsable;
		}
		$this->report($params, $information, $transaction,$documents,$params['id_base_ticket']);
		
		$idTemplate = 0 ;
		$resolution = ClientResolutionQuery::create()->findByPK($params['id_client_resolution']);			
		$params['emailClient'] = $emailResponsableAcl;
		if((int) $resolution->getType() == 1 && !$this->getPGoodFaith($transaction)){			
			$idTemplate = (int) TemplateEmailQuery::create()->addColumn(TemplateEmail::ID_TEMPLATE_EMAIL)->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_REQUEST)->fetchOne();
		}
		if((int) $resolution->getType() != 1 && $this->getPGoodFaith($transaction)){
			$idTemplate = (int)TemplateEmailQuery::create()->addColumn(TemplateEmail::ID_TEMPLATE_EMAIL)->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_DISCOUNT)->fetchOne();
		}		
		if( (int) $information['id_base_ticket'] > 0 && (int) $idTemplate > 0){
			$this->notification($information['id_base_ticket'],$idTemplate,$params['emailClient']);
		}
	}
	
	private function getPGoodFaith($transaction){
		$exito = 0;
		if(count($transaction) > 0){
			foreach($transaction as $tmpArray){
				if(trim($tmpArray['good_faith_payment']) != ''){
					$exito = 1;
				}
			}
		}
		return $exito;
	}
	private function notification($idTicketBase, $idTemplateEmail,$email){
		$this->getFileCatalog()->beginTransaction();
		try{
			$notification = new Notification();
			$fields2      = array("id_base_ticket" => $idTicketBase,"to" => $email, "dispatched" => 0, "id_template_email" => $idTemplateEmail, "created" => date('Y-m-d H:m:s'));
			NotificationFactory::populate($notification, $fields2);
			$this->getNotificationCatalog()->create($notification);
			$this->getFileCatalog()->commit();
				
		}catch(Exception $e){
			$this->getFileCatalog()->rollBack();
		}
	}
	
	private function report($params, $information, $transaction,$documents,$idBaseTicket = 0){
		$fixManager     = new FixManager();
		$anexa=array("Carta Reclamaci�n"=>"Entregado",
					 "Copia Frontal de Tarjeta"=>"Entregado",
					 "Identificaci�n Oficial"=>"Entregado",
					 "Estado de Cuenta"=>"Pendiente");
		$attachment=array();
		$filesNames=array();
		foreach($anexa as $key=>$valor){
			$identifier=$fixManager->cleanCaracteres($key);
			$attachment[$identifier] = $valor;
			$filesNames[$identifier] = utf8_encode($key);
		}
		$data=array("explain"=>array("reception_date"=>"2016/11/14",
					"folio"=>"000006531",
					"branch_number"=>"0",
					"branch_name"=>"Call Center",
					"product"=>"Tarjeta de D�bito",
					"canal"=>"Terminal Punto de Venta",
					"reason"=>"Transacci�n no reconocida"				
				),
				"client"=>array("name"=>"Fernando Polaco Tamer",
					"payroll"=>"Si",
					"client_number"=>"54648",
					"account_number"=>"534568",
					"card_number"=>"XXXX XXXX XXXX 4456",
					"additional_holder"=>"Titular",
					"phone"=>"5527246508",
					"email"=>"ferpol192@hotmail.com"
				),
				"transaction"=>array(0=>array("date"=>"01/07/2016",
					"concept"=>"Compra en establecimiento Mc Donalds",
					"reference"=>"FT536984566218562455",
					"import"=>"589,69"
				),
				1=>array("date"=>"01/07/2016",
					"concept"=>"Compra en establecimiento Starbucks",
					"reference"=>"FT536984566218562456",
					"import"=>"253,2"
				),
				2=>array("date"=>"01/07/2016",
					"concept"=>"Compra en establecimiento OXXO",
					"reference"=>"FT536984566218562457",
					"import"=>"863,71"
					)
				),
				"transaction_total"=>array("partial"=>"","reclaimed"=>"1,706,60"),
				////                    "attached"=>array("claim"=>"Entregada",
				////                                      "tarjet"=>"Entregada",
				////                                      "official_identification"=>"Entregada",
				////                                      "billing_statement"=>"Pendiente"),
				//"attached"=>van ,
				"description"=>array("Cliente indica que cuenta con la tarjeta en su poder y  no reconoce haber realizado las transacciones.")		
		);

		//        $data = array_map("self::utf8_encode_array", $data);
		$fileType = $params['type'];
		if($fileType ==1 || $fileType ==2|| $fileType ==3)
		{
			//$data = array_map(array($fixManager, 'utf8_encode_array'), $data);
			if($fileType ==1 || $fileType ==2){
				$data=array();
				$alias = "NO";
				$financiera = false;
				if(count($information) > 0)
					$data+=$information;
				if(count($transaction) > 0){
					$data+=$transaction;
					$alias = " ";
					$financiera = true;
				}
                                $fecha_creado=explode("-",$data['created']);
//                                $data['created']=($fecha_creado)?$fecha_creado[2]."/".$fecha_creado[1]."/".$fecha_creado[0]:"";
				$tittle="Formato Aclaracion ".$alias." Financiera";
				$this->view->financiera=$financiera;
				$this->view->files=$documents;	
                                $this->view->transactions=$transaction['transactions'];
				$this->view->data=$data;				
				$protocol = (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) == "ON") ? "https://" : "http://";
				$url = $protocol . $this->getRequest()->getServer('HTTP_HOST') . $this->getRequest()->getBaseUrl();
				$this->view->url=$url;
				$this->view->fecha=date('d/m/Y');
				$this->view->setTpl('List')->setLayoutFile(false);
				$html = $this->view->getEngine()->fetch('ticket-client/Acl-financiera.tpl', true);
			}
			if($fileType==3){
				$data=array();
				if(count($information) > 0)
					$data+=$information;
				if(count($transaction) > 0)
					$data+=$transaction;
				$tittle="Formato_Carta_Resolutoria";
				$this->view->data=$data;
                $this->view->information=$information;
                $this->view->fechaAssignacion =$xx= $information['fecha_asignacion'];
				$this->view->transaction=$transaction;
				$this->view->files=$documents;
				$protocol = (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) == "ON") ? "https://" : "http://";
				$url = $protocol . $this->getRequest()->getServer('HTTP_HOST') . $this->getRequest()->getBaseUrl();
				$this->view->url=$url;
				$this->view->fecha=date('d/m/Y');
				$this->view->setTpl('List')->setLayoutFile(false);
				$html = $this->view->getEngine()->fetch('ticket-client/Carta.tpl', true);
			}
			$pdf = new DOMPDF();
			$pdf->load_html($html);
			$pdf->render();
                        $canvas = $pdf->get_canvas();
                        $font = Font_Metrics::get_font("arial", "normal","12px");
                        $canvas->page_text(540, 773, utf8_encode("P�gina")." {PAGE_NUM} de {PAGE_COUNT}",$font, 6, array(0,0,0));
			$name=$tittle ."_". date('Y-m-d') . '_' . time() . '.pdf';
			$urlfile="public/carta/".$name;
			$mipdf=$pdf->Output();
			@file_put_contents($urlfile, $mipdf);
			if( (int) $params['format'] == 2){
				//          	$this->getFileCatalog()->beginTransaction();
				$fields = array("uri"=>$urlfile,"original_name"=>$name);
				$file   = new File();
				FileFactory::populate($file, $fields);
				$this->getFileCatalog()->create($file);
				$idFile = $file->getIndex();
				$now = new \Zend_Date();
				$notification= new Notification();
				$fields2=array("id_template_email" => $params['templateEmail'],"to"=> $params['emailClient'],"id_base_ticket"=>$information['id_base_ticket'],"created"=>$now->get('yyyy-MM-dd HH:mm:ss'),"id_file" => $file->getIndex());
				NotificationFactory::populate($notification, $fields2);
				$this->getNotificationCatalog()->create($notification);
				if((int) $idBaseTicket > 0 && $idFile > 0){
					$this->getTicketService()->updateIdResolucionFile($idFile,$idBaseTicket);
				}
			}
			if($params['ajaxJason'])
				die(json_encode($name));
		}
	}
	        
	private function getBranch($idBranch){
		$branch = BranchQuery::create()->findByPK($idBranch); 
		if($branch != null){
			return $branch->getName();
		}
		return "";
	}
	
	
	public function getResponseTicketTime($tickets){	 
		$arrayReturn = array();
		if(count($tickets) > 0){
			foreach($tickets as $ticketClient){
				$xx = $this->getServiceLevelService()->getExpirationDate($ticketClient);
				$arrayReturn[$ticketClient->getIdTicketClient()] = $xx->get('yyyy-MM-dd HH:mm:ss');
			}
		}
		return $arrayReturn;
	}
	
	public function getHours($tickets){
		$arrayColors = array();
		$color = "";
		if(count($tickets) > 0){
			foreach($tickets as $ticketClient){
				$color = "";
				$date = new DateTime($ticketClient->getExpirationDate());
				$expirationDate = $date->format('Y-m-d H:i:s');
				$numHoras = self::calculaHoras($expirationDate,date('Y-m-d H:i:s'));
				if($numHoras > 0){
					if($numHoras > 0  && $numHoras <=2){
						$color= "";
					}
					elseif($numHoras > 2  && $numHoras <10){
						$color= "#F3F781";
					}else{
						$color= "#F5A9A9";						
					}
					$arrayColors[$ticketClient->getIdTicketClient()] = $color;
				}
			}
		}
		return $arrayColors;
	}
	
	public function calculaHoras($expirationDate,$currentDate){
		$total_seconds = strtotime($currentDate) - strtotime($expirationDate);
		$horas         = floor ( $total_seconds / 3600 );
		return $horas;
	}
	
	public function permissions($idRol,$permiso){
		$sql= "select a.id_action FROM pcs_common_security_actions as a join pcs_common_security_actions_access_roles as b on a.id_action = b.id_security_action
		where a.name = '".$permiso."' and id_access_role = '".$idRol."';";
		return (int) $this->getSecurityActionCatalog()->getDb()->fetchOne($sql);
	}
	
	public function countParams($params){
		$contador = 0;
		if((int)$params['findBD'] > 0){
			$contador = 1;
		}
		return $contador;
	}

	public function countParamsAclaracion($params){
		$contador = 0;
		if(count($params) > 0){
			foreach($params as $key => $value){
				if($key != 'controller' && $key != 'action' && $key != 'module'){
					if(trim($value) != ''){
						$contador++;
					}
				}
			}
		}
		return $contador;
	}

	public function getField($head, $orden){
		$field = "";
		switch($head){
			case 'Tconsec':
				$field = TicketClient::ID_TICKET_CLIENT;
				break;
			case 'Tfolio':
				$field = TicketClient::FOLIO;
				break;
			case 'Tdassign':
				$field = TicketClient::CREATED;
				break;
			case 'Texpiration':
				$field = TicketClient::EXPIRATION_DATE;
				break;
			case 'Tnumber':
				$field = TicketClient::CLIENT_NUMBER;
				break;
			case 'Taccount':
				$field = TicketClient::ACCOUNT_NUMBER;
				break;
			case 'Tproduct':
				$field = TicketClient::ID_PRODUCT;
				break;
			case 'Ttype':
				$field = TicketClient::ID_TICKET_TYPE;
				break;
			case 'Tchannel':
				$field = TicketClient::ID_CHANNEL;
				break;
			case 'Tcategory':
				$field = TicketClient::ID_CLIENT_CATEGORY;
				break;
			case 'Tobranch':
				$field = TicketClient::ID_ORIGIN_BRANCH;
				break;
			case 'Trbranch':
				$field = TicketClient::ID_REPORTED_BRANCH;
				break;
			case 'Tregister':
				$field = TicketClient::ID_USER;
				break;
			case 'TassTo':
				$field = TicketClient::ID_ASSIGNMENT;
				break;
			case 'Tcost':
				$field = TicketClient::FOLIO;
				break;				
			case 'Tstatus':
				$field = TicketClient::STATUS;				
				break;
		}
		$ordenamiento = " DESC ";
		if((int) $orden == 0){
			$orden = 1;
		}
		if($orden == 1 ){
			$ordenamiento = " ASC ";
		}		
		return array($field,$ordenamiento);
	}
    /**
     * @return Application\Service\TicketService
     */
    private function getTicketService(){
    	return $this->getContainer()->get('TicketService');
    }
    /**
     * @return Application\Model\Catalog\TicketClientFieldCatalog
     */
    private function getTicketClientFieldCatalog(){
    	return $this->getCatalog('TicketClientFieldCatalog');
    }
    /**
     * @return Application\Model\Catalog\FileCatalog
     */
    private function getFileCatalog(){
    	return $this->getCatalog('FileCatalog');
    }
    
    /**
     * @return Application\Model\Catalog\FileTmpCatalog
     */
    private function getFileTmpCatalog(){
    	return $this->getCatalog('FileTmpCatalog');
    }
    
    /**
     * @return Application\Model\Catalog\TicketClientDocumentCatalog
     */
    private function getTicketClientDocumentCatalog(){
    	return $this->getCatalog('TicketClientDocumentCatalog');
    }
    
    /**
     * @return Application\Model\Catalog\TicketsClientsTransactionsCatalog
     */
    private function getTicketsClientsTransactionsCatalog(){
    	return $this->getContainer()->get('TicketsClientsTransactionsCatalog');
    }

    /**
     * @return Application\Model\Catalog\TicketsClientsReopenCatalog
     */
    private function getTicketsClientsReopenCatalog(){
    	return $this->getContainer()->get('TicketsClientsReopenCatalog');
    }
    
    /**
     * @return Application\Model\Catalog\SecurityActionCatalog
     */    
    private function getSecurityActionCatalog(){
    	return $this->getContainer()->get('SecurityActionCatalog');
    }
    protected function getTicketClientCatalog(){
    	return $this->getContainer()->get('TicketClientCatalog');
	}
	
    protected function getNotificationCatalog(){
        return $this->getContainer()->get('NotificationCatalog');
    }
    private function getCommentsCatalog(){
		return $this->getContainer()->get('CommentsCatalog');
	}

    /**
     * @return \Application\Model\Catalog\TicketLogCatalog
     */
    public function getTicketLogCatalog(){
        return $this->getContainer()->get('TicketLogCatalog');
    }

    /**
     * @return \Application\Model\Catalog\EmployeeCatalog
     */
    public function getEmployeeCatalog(){
    	return $this->getContainer()->get('EmployeeCatalog');
    }
	 protected $ticketLogCatalog;    
}
