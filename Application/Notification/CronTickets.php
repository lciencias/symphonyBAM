<?php
/**
 * PCS Mexico
 *
 * Sistema de Distribucion
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 * @author     
 * @version    1.0
 */
namespace Application\Notification;

use Application\Cron\Cronable;
use Application\Event\EmailEvent;
use Application\Model\Bean\ClientResolution;
use Application\Model\Bean\Notification;
use Application\Model\Bean\Option;
use Application\Model\Bean\TemplateEmail;
use Application\Model\Bean\TicketClient;
use Application\Model\Bean\User;
use Application\Model\Bean\UserGroup;
use Application\Model\Catalog\TicketClientCatalog;
use Application\Query\ClientCategoryQuery;
use Application\Query\ClientResolutionQuery;
use Application\Query\EmailQuery;
use Application\Query\EmployeeQuery;
use Application\Query\GroupQuery;
use Application\Query\OptionQuery;
use Application\Query\TemplateEmailQuery;
use Application\Query\TicketClientQuery;
use Application\Query\UserGroupQuery;
use Application\Query\UserQuery;
use Application\Notification\Mailer;
/**
 * Clase CronNotification
 */
set_time_limit (-1);
class CronTickets implements Cronable
{

    /**
     *
     * @var Zend_Date
     */
    protected $now;

    /**
     *
     * @var Zend_Date
     */
    protected $nowPlus5;

    /**
     *
     * @var unknown_type
     */
    protected $view;


    /**
     *
     * @var filename
     */
    private $filename;

    /**
     *
     * @var user
     */
    private $user;
    
    /**
     *
     * @var incompletResolution
     */
    private $incompletResolution;
    
    /**
     *
     * @var expiredResolution
     */
    private $expiredResolution;

    /**
     *
     * @var incompletTemplate
     */
    private $incompletTemplate;
    
    /**
     *
     * @var expiredTemplate
     */
    private $expiredTemplate;
    
    /**
     *
     * @var option
     */
    private $option;
    
    /* (non-PHPdoc)
     * @see Cronable::isActive()
     */
    public function isActive() {
        return true;
    }

    /* (non-PHPdoc)
     * @see Cronable::conditionToExecute()
     */
    public function conditionToExecute() {
        return true;
    }


    /**
     * (non-PHPdoc)
     * @see Application\Cron.Cronable::run()
     */
    public function run()
    {
    	$this->filename = "public/logs/cron_tickets_log.txt";
    	$this->user                = UserQuery::create()->findByPK(1);
    	$this->incompletResolution = ClientResolutionQuery::create()->whereAdd(ClientResolution::ID_CLIENT_RESOLUTION,3)->findOne();
    	$this->expiredResolution   = ClientResolutionQuery::create()->whereAdd(ClientResolution::ID_CLIENT_RESOLUTION,12)->findOne();    	 
    	$this->option              = OptionQuery::create()->whereAdd(Option::ID_OPTION,10)->findOne();    	 
    	$idEmail1 = (int) TemplateEmailQuery::create()->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_INCOMPLETE)->fetchOne();
    	$idEmail2 = (int) TemplateEmailQuery::create()->whereAdd(TemplateEmail::EVENT, EmailEvent::TICKET_CLIENT_EXPIRED)->fetchOne();    	
    	$this->incompletTemplate   = $xx = TemplateEmailQuery::create()->whereAdd(TemplateEmail::ID_TEMPLATE_EMAIL,$idEmail1)->findOne();    	 
		$this->expiredTemplate     = $yy = TemplateEmailQuery::create()->whereAdd(TemplateEmail::ID_TEMPLATE_EMAIL,$idEmail2)->findOne();		
    	self::ticketIncomplete();    	
    	self::ticketExpired();
    }
    
    /*
     * Metodo que busca ticket sin documentos
     */
    private function ticketIncomplete(){
    	$arrayFolios = array();
    	$note   = "";
    	$emails = array();
    	$expirationDate = "";
    	self::log("Iniciando Ejecucion de Cron de Tickets sin Documentos\n\n");
    	self::log("Fecha y Hora Inicio ".date('Y-m-d H:i:s')."\n");
    	try {
        	$tickets = TicketClientQuery::create()->whereAdd(TicketClient::STATUS,2)->find();
        	if(count($tickets) > 0){
        		foreach($tickets as $ticket){        		
        			$expirationDate = self::addDays($ticket->getScheduledDate());
        			if(self::compareDate($expirationDate)){
        				if(!in_array($ticket->getIdTicketClient(), $arrayFolios)){
        					$arrayFolios[] = $ticket->getIdTicketClient();
        				}        				
        				$note = "El ticket ".$ticket->getIdTicketClient()." no tiene documentos, se resuelve el ticket por que la fecha de vencimiento fue del dia ".$expirationDate."\n";
        				
        				self::resolveTicket($ticket, 1,$note);
        				self::updateFolio($ticket->getIdTicketClient(),$ticket->getFolio());
        				self::insertaNotificacion($ticket->getIdBaseTicket(),1);
        				self::log($note);
        				$emails[$ticket->getIdUser()]['id_ticket'] = $ticket->getIdBaseTicket();
        				$emails[$ticket->getIdUser()]['msg'] = $emails[$ticket->getIdUser()]['msg']."<br>".$note;
        				
        			}
        		}
        		//self::notifications($emails,1,$arrayFolios);
        	}else{
        		self::log("No se encontraron tickets incompletos para cerrar de forma automatica\n\n");
        	}        	        	
        }        
        catch (Exception $e) {
            self::log("Exception:  ".$e->getMessage());
        }
        self::log("Fecha y Hora termina ".date('Y-m-d H:i:s'));
    }
        
    /*
     * Metodo que busca ticket expirados
     */    
    private function ticketExpired(){
    	$arrayFolios = array();
    	$note   = "";
    	$emails = array();
    	$expirationDate = "";
    	self::log("Iniciando Ejecucion de Cron de Tickets que han expirado\n\n");
    	self::log("Fecha y Hora Inicio ".date('Y-m-d H:i:s')."\n");
    	try {
    		$tickets = TicketClientQuery::create()->whereAdd(TicketClient::STATUS,array(3,4),' IN ')
    		->whereAdd(TicketClient::IS_STOPPED,0)
    		->orderBy(TicketClient::ID_TICKET_CLIENT,' DESC' )->find();    		
    		if(count($tickets) > 0){
    			foreach($tickets as $ticket){
    				$expirationDate = $this->getServiceLevelService()->getExpirationDateNvo($ticket);
    				if(self::compareDate($expirationDate)){
    					if(!in_array($ticket->getIdTicketClient(), $arrayFolios)){
    						$arrayFolios[] = $ticket->getIdTicketClient();
    					}
    					$note = "El ticket ".$ticket->getIdTicketClient()." ha expirado,  se resuelve el ticket por que la fecha de resoluci�n fue del dia ".$expirationDate."\n";    					
    					self::resolveTicket($ticket, 2,$note);
    					self::updateFolio($ticket->getIdTicketClient(),$ticket->getFolio());
    					self::insertaNotificacion($ticket->getIdBaseTicket(),2);
    					self::log($note);
    					$emails[$ticket->getIdUser()]['id_ticket'] = $ticket->getIdBaseTicket();
    					$emails[$ticket->getIdUser()]['msg'] = $emails[$ticket->getIdUser()]['msg']."<br>".$note;
    				}    				
    			}    			
    			//self::notifications($emails,2,$arrayFolios);    			
    		}else{
    			self::log("No se encontraron tickets expirados para cerrar de forma automatica\n\n");
    		}
    	}
    	catch (Exception $e) {
    		self::log("Exception:  ".$e->getMessage());
    	}
    	self::log("Fecha y Hora termina ".date('Y-m-d H:i:s'));
    }

    
    private function insertaNotificacion($idBaseTicket,$opcion){    	
    	if($opcion == 1){
    		$idTemplate = $this->incompletTemplate->getIdTemplateEmail();
    	}else{
    		$idTemplate = $this->expiredTemplate->getIdTemplateEmail();
		}
    	if((int) $idTemplate  > 0){
    		try{
	    		$this->getNotificationCatalog()->beginTransaction();   	
	    		$notification = new Notification();
	    		$notification->setIdBaseTicket($idBaseTicket);
	    		$notification->setIdTemplateEmail($idTemplate);
	    		$notification->setDispatched(0);
	    		$notification->setTo('');
	    		$notification->setCC('');
	    		$notification->setBcc('');
	    		$notification->setCreated(date('Y-m-d H:i:s'));
	    		$this->getNotificationCatalog()->create($notification);
	    		$this->getNotificationCatalog()->commit();	    		
    		}
    		catch(Exception $e){    			
    			$this->getNotificationCatalog()->rollBack();
    		}
    	}
    }
    
    /**
     * Metodo para registrar la notificacion
     * @param array $emails
     * @param int $tipo
     */
    private function notifications($emails,$tipo,$arrayFolios){
    	$bodyMsg = $body= "";
    	if(count($emails) > 0){
    		try{
	    		foreach($emails as $idUser => $data){    			
	    			$bodyMsg      = $data['msg'];
	    			$user 		  = UserQuery::create()->findByPK($idUser);
	    			if($tipo == 1){
	    				$templateMail = $this->incompletTemplate;
	    			}else{
	    				$templateMail = $this->expiredTemplate;
	    			}
	    			$arrayEmails  = self::findEmails($templateMail,$user);
	    			if((int) $templateMail->getIdTemplateEmail() > 0 && count($arrayEmails) > 0){	    				
	    				$body    = str_replace("%body%",$bodyMsg,$templateMail->getBody());
	    				if(count($arrayFolios) > 0){
	    					$body.= "<br><p>Los tickets finalizados son : ".implode(', ',$arrayFolios);
	    				}
						$subject = $templateMail->getSubject();						
						if(count($arrayEmails)>0){
							$this->getMailer()->composeAndSend($arrayEmails, $subject, $body);
							self::log("Correo ticket sin documentos, enviado a ".implode(", ",$arrayEmails));
						}else{
							self::log("No existen cuenta de email registradas al usuario ".$idUser." para enviar los correos\n");
						}
	    			}else{
	    				if( (int) $templateMail->getIdTemplateEmail() == 0)
	    					self::log("No se tiene registrado el id del template en la base de datos\n");
	    				if(count($arrayEmails) == 0)
	    					self::log("No existen cuenta de email registradas al usuario ".$idUser." para enviar los correos\n");
	    			}
	    		}
    		}
    		catch(Exception $e){
    			self::log("Error: ".$e->getMessage());
    		}    		
    	}
    }
    
    
    private function findEmails(TemplateEmail $templateMail,User $user){
    	$correos = array();
    	$employee = EmployeeQuery::create()->findByPK($user->getIdEmployee());
    	if($employee != null && (int) $employee->getIdPerson() > 0){
	    	if($templateMail->getToEmployee() == 1){
	    		$emails  = self::getEmails($employee->getIdPerson());
	    		$correos = self::extractEmails($correos,$emails);
	    	}
    	 
    		if( $templateMail->getToUser() == 1){
    			$emails = self::getEmails($user->getIdPerson());
    			$correos = self::extractEmails($correos,$emails);
    		}
    		
	    	
    		$templateMail->setToGroup(1);
    		if ($templateMail->getToGroup() == 1){  // && $this->getUser()->getBean()->getIdAccessRole() > 1){
    			$group = UserGroupQuery::create()->addColumn(UserGroup::ID_GROUP)->whereAdd(UserGroup::ID_USER, $user->getIdUser())->fetchOne();
    			if($group != null && (int) $group > 0){
    				$usersGroup = UserGroupQuery::create()->addColumn(UserGroup::ID_USER)->whereAdd(UserGroup::ID_GROUP, $group)->fetchIds();
    				if($usersGroup != null && count($usersGroup) > 0){
    					$users = UserQuery::create()->whereAdd(User::STATUS,1)->whereAdd(User::ID_USER,$usersGroup,' IN ')->fetchAll();
    					if( count($users) > 0){
    						foreach($users as $tmp){
    							$emails = self::getEmails($tmp['id_person']);
    							$correos = self::extractEmails($correos,$emails);
    						}
    					}    						
	   				}				    				
    			}
    		}
    	}
    	return $correos;
    }

    /** 
     * Metodo qyue se encarga de sacar el mail de person
     * @param Int $id Person
     */
    private function getEmails($id){
    	return EmailQuery::create ()->innerJoinPerson ()->whereAdd ('Email2Person.id_person', $id)->fetchPairs();
    }
    
    
    /**
     * Metodo para poner los correos en un solo array
     * @param array $correos
     * @param array $emails
     * @return array
     */
    private function extractEmails($correos,$emails){
    	if(count($emails)>0){
    		foreach($emails as $cuenta){
    			if(!in_array($cuenta,$correos)){
    				$correos[]=$cuenta;
    			}
    		}
    	}
    	return $correos;
    }
    
	/*
	 * Metodo que resuelve el ticket de forma automatica
	 * @params Objeto Ticket, Int Tipo (1 incompleto,2 expirado), String nota de descripcion
	 */
    private function resolveTicket(TicketClient $ticket, $tipo, $note){
    	if($tipo == 1){
    		//$this->getTicketService()->read($ticket, $this->user);
    		//self::log("Id Ticket ".$ticket->getIdTicketClient()." se ha leido\n");
    		$this->assign($ticket);
    		self::log("Id Ticket ".$ticket->getIdTicketClient()." se ha asignado\n");    		
    		$this->getTicketService()->resolveTicketClient($ticket,$this->incompletResolution, $this->user, $note, null, null,null,null);
    		self::log("Id Ticket ".$ticket->getIdTicketClient()." se ha resuelto\n");
    	}else{
			$this->getTicketService()->resolveTicketClient($ticket,$this->expiredResolution, $this->user, $note, null, null,null,null);
			self::log("Id Ticket ".$ticket->getIdTicketClient()." se ha resuelto\n");
    	}
    }
    
    /**
     * Metodo que asigna el ticket
     * @param TicketClient $ticket
     * @return boolean de exito
     */
    private function assign(TicketClient $ticket){
    	$assigmentFlag = true;
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
    					$this->getTicketService ()->assign ( $ticket, $userAssigned, $this->user);    					
    					return true;
    				} catch ( Exception $e ) {
    					self::log($e->getMessage()."\n");    					
    				}
    			}
    		}
    	}
    	return false;
    }
    
    private function updateFolio($idTicket,$folio){
    	$query= $this->getCatalog('ProductsCatalog');
    	$folio = str_replace('P','',$folio);
    	$upd = "UPDATE pcs_symphony_tickets_clients set folio='".$folio."' WHERE id_ticket_client = '".$idTicket."'";
    	$this->getTicketClientCatalog()->getDb()->query($upd);    	
    }
    
    
    /*
     * Metodo que suma 5 dias a la fecha pasada como parametro
     * @params date fecha a la que se tiene que sumar los dias
     * @return String fecha que incluye la suma de los dias
     */
    private function addDays($fecha){
    	$days 		= $this->option->getValue();
    	$nuevafecha = strtotime ( '+'.$days.' day' , strtotime($fecha)) ;
    	$nuevafecha = date ('Y-m-d:H:i:s' , $nuevafecha);
    	return $nuevafecha;
    }

    /*
     * Metodo que compara su la fecha pasada es mayor a la actual
     * @params Date, fecha
     * @return Boolean 
     */
    private function compareDate($fecha){
    	$exito = true;
    	if($fecha >= date("Y-m-d H:i:s")){
    		$exito = false;
    	}
    	return $exito;
    }

    /*
     * Metodo que escribe en el archivo de logs, el suceso de cada ticket
     * @params String texto a escribir en el log
     */
    private function log($texto){
    	$f = fopen($this->filename,"a+") or die("Error al crear el archivo");
    	fwrite($f, $texto); 
    	fclose($f);    	
    }
    
    /*
     * Metodo que sirve para debugear un objeto //y/o array
     * @params objeto y/o array     
     */
    private function debug($objeto){
    	echo"<br>Count:  ".count($objeto)."<br>";
    	echo"<pre>";
    	print_r($objeto); 
    	die();    	 
    }
    
    /**
     * @return \Application\Model\Catalog\TicketClientCatalog
     */
    protected function getTicketClientCatalog(){
        return $this->getContainer()->get('TicketClientCatalog');
    }

    /**
     * @return \Application\Model\Catalog\NotificationCatalog
     */
    /*private function getNotificationCatalog(){
    	return $this->getContainer()->get('NotificationCatalog');
    }*/
    private function getNotificationCatalog(){
    	return $this->getCatalog('NotificationCatalog');
    }
    
    
    /**
     * @return the $view
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param unknown_type $view
     */
    public function setView($view) {
        $this->view = $view;
    }


    /**
     * @return Zend_Date
     */
    public function getNow() {
        return $this->now;
    }

    /**
     * @return Zend_Date
     */
    public function getNowPlus5() {
        return $this->nowPlus5;
    }

    /**
     * @param Zend_Date $now
     */
    public function setNow($now) {
        $this->now = $now;
    }

    /**
     * @param Zend_Date
     */
    public function setNowPlus5($nowPlus5) {
        $this->nowPlus5 = $nowPlus5;
    }

    /**
     *
     * @param unknown_type $catalog
     * @return \Application\Model\Catalog\Catalog
     */
    private function getCatalog($catalog){
        return \Zend_Registry::getInstance()->get('container')->get($catalog);
    }
    
    /**
     * @return Application\Service\TicketService
     */
    private function getTicketService(){
    	return $this->getContainer()->get('TicketService');
    }
    
    private function getMailer() {
    	return $this->getContainer()->get('Mailer');
    }
    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer(){
    	return $this->getRegistry()->get('container');
    }
    public function getRegistry(){
    	return \Zend_Registry::getInstance();
    }
    
    /**
     * @return \Application\Service\ServiceLevelService
     */
    public function getServiceLevelService(){
    	return $this->getContainer()->get('ServiceLevelService');
    }
    
}
