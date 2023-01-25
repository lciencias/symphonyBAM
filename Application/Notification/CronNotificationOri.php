<?php
/**
 * PCS Mexico
 *
 * Sistema de Distribucion
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 * @author     Vicente Mendoza Moreno
 * @version    1.0
 */

namespace Application\Notification;

use EasyCSV\Exception;

use Application\Query\TicketClientQuery;

use Application\Model\Bean\TicketClient;

use Application\Query\BaseTicketQuery;

use Application\Model\Bean\BaseTicket;

use Application\I18n\MasterTranslator;
use Application\Query\PersonQuery;
use Application\Model\Bean\Person;
use Application\Service\TicketInfo;
use Application\Query\TicketTypeQuery;
use Application\Model\Bean\TicketType;
use Application\Query\ChannelQuery;
use Application\Query\AssignmentQuery;
use Application\Model\Bean\Email;
use Application\Model\Bean\User;
use Application\Query\GroupQuery;
use Application\Model\Bean\Group;
use Application\Model\Collection\EmailCollection;
use Application\Query\EmailQuery;
use Application\Query\PhoneNumberQuery;
use Application\Model\Bean\Employee;
use Application\Model\Bean\Ticket;
use Application\Query\UserQuery;
use Application\Query\ImpactQuery;
use Application\Query\PriorityQuery;
use Application\Query\CategoryQuery;
use Application\Query\CompanyQuery;
use Application\Query\EmployeeQuery;
use Application\Cron\Cronable;
use Application\Notification\Mailer;
use Application\Query\TemplateEmailQuery;
use Application\Model\Bean\TemplateEmail;
use Application\Query\TicketQuery;
use Application\Model\Bean\Notification;
use Application\Query\NotificationQuery;
use Application\Query\FileQuery;
use Application\Model\Bean\File;

/**
 * Clase CronNotification que representa el controller para la ruta default
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 */
class CronNotification implements Cronable
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
     * @var mail validations
     */
    const EMAIL_REGEXP = "/^[a-z0-9_.-]+@[a-z0-9-]+.[a-z0-9-.]+$/i";

    /**
     *
     * @var unknown_type
     */
    protected $view;

    /**
     *
     * @var Application\Service\Mailer
     */
    protected $mailer;

    /**
     *
     * @var \Application\I18n\MasterTranslator
     */
    protected $masterTranslator;

    /**
     *
     * @var \Application\Service\ServiceLevelService
     */
    protected $serviceLevelService;

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
    	$tickets = BaseTicketQuery::create()->whereAdd(BaseTicket::TYPE, BaseTicket::$Type['TicketClient'])->fetchIds();
        $notifications = NotificationQuery::create()
//         	->whereAdd(Notification::ID_BASE_TICKET, $tickets, NotificationQuery::IN)
            ->whereAdd(Notification::DISPATCHED, 0)
            ->find();            
        $notificationCatalog = $this->getCatalog('NotificationCatalog');

        while( $notifications->valid() ) {
            $notification = $notifications->read();
           	$this->process($notification);
            $notification->setDispatched(true);
            $notificationCatalog->update($notification);
        }
    }

    
    
    
    /**
     *
     * @param Notification $notification
     */
    private function process(Notification $notification)
    {
    	if (TicketQuery::create()->whereAdd('BaseTicket.'.Ticket::ID_BASE_TICKET, $notification->getIdBaseTicket())->count())
    		$ticket = TicketQuery::create()->whereAdd('BaseTicket.'.Ticket::ID_BASE_TICKET, $notification->getIdBaseTicket())->findOneOrElse(new Ticket());
		else if (TicketClientQuery::create()->whereAdd('BaseTicket.'.Ticket::ID_BASE_TICKET, $notification->getIdBaseTicket())->count())
			$ticket = TicketClientQuery::create()->whereAdd('BaseTicket.'.Ticket::ID_BASE_TICKET, $notification->getIdBaseTicket())->findOneOrElse(new TicketClient());
    	if ($ticket instanceof BaseTicket){
    		$templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($notification->getIdTemplateEmail(), "The template not exists");    		
    		$ticketInfo = TicketInfo::factory($ticket);    		
    		$variables = $this->getVariables($ticket, $templateEmail, $ticketInfo);
    		$body = str_replace(array_keys($variables), array_values($variables), $templateEmail->getBody());
    		//die($body);
			if ($ticket->getType() == BaseTicket::$Type['TicketClient'])
				$emails = $this->getEmails($ticket, $templateEmail, $ticketInfo->get('employee'), $ticketInfo->get('group'), $ticketInfo->get('assignedUser'), $notification);
			else
				$emails = $this->getEmails($ticket, $templateEmail, $ticketInfo->get('employee'), $ticketInfo->get('group'), $ticketInfo->get('user'), $notification);

			//$adminMails = array('fpolaco@bam.com.mx' =>'fpolaco@bam.com.mx');
			//$adminMails = array('lahernandez@pcsmexico.com' =>'lahernandez@pcsmexico.com');
			$adminMails = array();
			if(trim($notification->getTo()) != ""){
				$emails = array();
				$emails[trim($notification->getTo())] = trim($notification->getTo());				
			}	
    		if( count($emails) ){    			
    			if(trim($notification->getTo()) != ""){
    				$adminMails[trim($notification->getTo())] = trim($notification->getTo());
    			}    		
    			if((int)$notification->getIdFile() == 0){
    				$this->getMailer()
    				->composeAndSend($emails + $adminMails, $templateEmail->getSubject(), $body);    				
    			}else{
    				$file = FileQuery::create()->whereAdd(File::ID_FILE,$notification->getIdFile())->find();
    				if($file != null && $file->getOne()->getUri() != ""){
    					$this->getMailer()
    					->composeAndSendAttachement($adminMails, $templateEmail->getSubject(), $body,$file->getOne()->getUri());    						
    				}
    			}    	
    			$this->createLog(array(
    					'id notification: '. $notification->getIdNotification(),
    					'subject: ' . $templateEmail->getSubject(),
    					"sent to: " . implode(', ', $emails + $adminMails),

    					)
    			);
    		}else{
    			$this->createLog(array(
    					'id notification: '. $notification->getIdNotification(),
    					'This notification has no configured emails ',
    					'subject: ' . $templateEmail->getSubject(),
    					)
    			);
    		}
    	}
    	
    }
    /**
     * 
     * @param array $parameters
     */
    private function createLog($parameters)
    {
    	$log = fopen("public/logs/cron_notification_log.txt", "a+");
    	$date = new \Zend_Date();
    	$parameters["time"] = $date->toString("dd-MM-yyyy hh:mm:ss");
    	fwrite($log, implode("\n",$parameters)."\n\n");
    	fclose($log);
    }
    /**
     *
     * @param Ticket $ticket
     * @param TemplateEmail $templateEmail
     * @return array
     */
    private function getVariables(BaseTicket $ticket, TemplateEmail $templateEmail, TicketInfo $ticketInfo)
    {
        $info = array();
        try{
        	
        $info['expirationDate'] = $this->serviceLevelService->getExpirationDate($ticket)->get('yyyy-MM-dd HH:mm:ss');
        $info['expiredTime'] = $this->serviceLevelService->getExpiredTime($ticket)->toHuman();
        $info['percentageService'] = $this->serviceLevelService->getPercentageService($ticket) . '%';
        }catch(Exception $e){
        	$info['expirationDate'] = '-';
        	$info['expiredTime'] = '-';
        	$info['percentageService'] = '-';
        }

        $variables = $ticketInfo->toArray();
        $variables = array_merge($variables, $this->toVars('info.', $info));
        
        $translatedVariables = array();
        foreach ($variables as $key => $value){
            $translatedVariables[$key] = $this->getMasterTranslator()->translate($value, $templateEmail->getLanguage());
        }
        return $translatedVariables;
    }

    /**
     *
     * @param Ticket $ticket
     * @param TemplateEmail $templateEmail
     * @return array
     */
    private function getEmails(BaseTicket $ticket, TemplateEmail $templateEmail,
    Employee $employee, Group $group, User $user, Notification $notification)
    {
        $emails = new EmailCollection();
        if( $templateEmail->getToEmployee() ){
            $employeeEmails = 
               EmailQuery::create()
                   ->innerJoinPerson()
                   ->whereAdd('Person.id_person', $employee->getIdPerson())
                   ->whereAdd('Person.language', $templateEmail->getLanguage())
                   ->find();
            while ($employeeEmail = $employeeEmails->read())
            	$emails->append($employeeEmail);
        }

        if( $templateEmail->getToGroup() ){
            $personIds = UserQuery::create()
                ->innerJoinGroup()
                ->addColumn('Person.'.User::ID_PERSON)
                ->whereAdd('User.'.User::STATUS, User::$Status['Active'])
                ->whereAdd('Group.id_group', $group->getIdGroup())
                ->fetchCol();
            $groupEmails = EmailQuery::create()
                    ->innerJoinPerson()
                    ->whereAdd('Person.id_person', $personIds)
                    ->whereAdd('Person.language', $templateEmail->getLanguage())
                    ->find();
            while ($groupEmail = $groupEmails->read()){
            	$emails->append($groupEmail);
            }
        }

        if( $templateEmail->getToUser() ){
        	if ($user->isActive()){
        		$userEmails = EmailQuery::create()
        				->innerJoinPerson()
        				->whereAdd('Person.id_person', $user->getIdPerson())
        				->whereAdd('Person.language', $templateEmail->getLanguage())        				
        				->find();
        		while ($userEmail = $userEmails->read())
        			$emails->append($userEmail);
        	}
        }
        $regexp = self::EMAIL_REGEXP;
        $emailsArray = array_values($emails->filter(function (Email $email) use($regexp){
            return preg_match($regexp, $email->getEmail());
        })->toCombo());
        $to = array_filter(explode(',', $notification->getTo()));
        if( count($to) ){
            $addEmails = array();
            // TODO mejorar algoritmo, poder consultar id de empleado
            foreach( $to as $email ){            	
            	if(trim($email) != ''){
	                $persons = PersonQuery::create()->innerJoinEmail()->whereAdd('Email.email', $email)->find();
	                if( !$persons->isEmpty() ){
	                    $persons = $persons->filter(function (Person $person) use($templateEmail){
	                       return $person->getLanguage() == $templateEmail->getLanguage();
	                    });
	                    if( !$persons->isEmpty() ){
	                        $addEmails[] = $email;
	                    }
	                }else{
	                    $addEmails[] = $email;
	                }
            	}
            }
            $emailsArray = array_merge($addEmails, $emailsArray);
        }
        return array_unique($emailsArray);
    }

    /**
     *
     * @param unknown_type $prefix
     * @param unknown_type $array
     * @return array
     */
    private function toVars($prefix, $array, $escaper = '%'){
        $newArray = array();
        foreach( $array as $key => $value ){
            $newKey = $escaper . $prefix . $key . $escaper;
            $newArray[$newKey] = $value;
        }
        return $newArray;
    }

    /**
     * @return the $view
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @return \Application\Notification\Mailer
     */
    public function getMailer() {
        return $this->mailer;
    }

    /**
     * @param unknown_type $view
     */
    public function setView($view) {
        $this->view = $view;
    }

    /**
     * @param Application\Service\Mailer $mailer
     */
    public function setMailer(Mailer $mailer) {
        $this->mailer = $mailer;
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
     * @param unknown_type $serviceLevelService
     */
    public function setServiceLevelService($serviceLevelService){
        $this->serviceLevelService = $serviceLevelService;
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
     *
     * @param MasterTranslator $masterTranslator
     */
    public function setMasterTranslator(MasterTranslator $masterTranslator){
        $this->masterTranslator = $masterTranslator;
    }

    /**
     * @return MasterTranslator
     */
    private function getMasterTranslator(){
        return $this->masterTranslator;
    }

}
