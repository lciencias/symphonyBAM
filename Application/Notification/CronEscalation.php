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

use Application\Model\Bean\ClientCategory;

use Application\Model\Bean\TicketClient;

use Application\Query\TicketClientQuery;

use Application\Query\ClientCategoryQuery;

use Application\Model\Bean\BaseTicket;

use Application\Query\BaseTicketQuery;

use Application\Model\Bean\Category;

use Application\Query\TicketLogQuery;

use Application\Model\Bean\TicketLog;

use Application\Model\Factory\TicketLogFactory;

use Application\Model\Bean\Person;

use Application\Event\EmailEvent;

use Application\Query\EscalationDetailQuery;

use Application\Model\Bean\EscalationDetail;

use Application\Query\EscalationQuery;

use Application\Query\ServiceLevelQuery;

use Application\Model\Bean\ServiceLevel;

use Application\Service\ServiceLevelService;

use Application\Service\AbstractService;

use Query\Criterion;

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

/**
 * Clase CronEscalation que representa el controller para la ruta default
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 */
class CronEscalation extends AbstractService implements Cronable
{

	/**
	 *
	 * @var mail validations
	 */
	const EMAIL_REGEXP = "/^[a-z0-9_.-]+@[a-z0-9-]+.[a-z0-9-.]+$/i";

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
	 * @var Application\Service\ServiceLevelService
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
		$tickets = BaseTicketQuery::create()
		->whereAdd(BaseTicket::STATUS, array_search('Closed', Ticket::$Statuses), Criterion::NOT_EQUAL)		
		->find();

		while ( $tickets->valid() )
		{
			$ticket = $tickets->read();
			if ($ticket->getType() == BaseTicket::$Type['Ticket']){
				$ticket = TicketQuery::create()
				->whereAdd('Ticket.'.Ticket::ID_BASE_TICKET, $ticket->getIdBaseTicket())
				->findOne();
				$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The categoy not exists");
				$escalation = EscalationQuery::create()->findByPKOrThrow($category->getIdEscalation(), "The Escalation not exists");
			}else{
				$ticket = TicketClientQuery::create()
				->whereAdd('TicketClient.'.TicketClient::ID_BASE_TICKET, $ticket->getIdBaseTicket())
				->findOne();
				$category = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The categoy not exists");
				$escalation = EscalationQuery::create()->findByPKOrThrow($category->getIdEscalation(), "The Escalation not exists");				
			}
			$escalationDetails = EscalationDetailQuery::create()->whereAdd(EscalationDetail::ID_ESCALATION, $escalation->getIdEscalation())->find();				
			if( $escalationDetails->isEmpty() ){
				continue;
			}
			$datosAvance = $this->serviceLevelService->getServiceTimeNew($ticket);
			$percentage  = $datosAvance[1];
			
			//$percentage = $this->serviceLevelService->getPercentageService($ticket);
			$ticketLog = TicketLogQuery::create()
			->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
			->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Last_escalation_percentage'])
			->findOne();
			$lastPercentage = $ticketLog instanceof TicketLog ? $ticketLog->getChangedTo() : 0;
			
			if( $lastPercentage != $percentage ){
				$user = UserQuery::create()->findByPKOrThrow($ticket->getIdUser(), "The user not exists");
				$escalationDetails = $escalationDetails->filter(function (EscalationDetail $detail) use($percentage, $lastPercentage){
					return $detail->getPercentage() <= $percentage && $detail->getPercentage() > $lastPercentage;
					//return $detail->getPercentage() <= $percentage;
				});
				if( $escalationDetails->isEmpty() ){
					continue;
				}

				while( $escalationDetails->valid() ) {
					$detail = $escalationDetails->read();				
					if ($ticket->getType() == BaseTicket::$Type['Ticket']){
						$this->getEventDispatcher()->dispatch(EmailEvent::TICKET_ESCALATION, new EmailEvent(array(
								'ticket' => $ticket,
								'user' => $user,
								'emails' => $this->getEmails($detail, $category),
						)));
					}else{
						$this->getEventDispatcher()->dispatch(EmailEvent::TICKET_CLIENT_ESCALATION, new EmailEvent(array(
								'ticket' => $ticket,
								'user' => $user,
								'emails' => $this->getEmails($detail, $category),
								)));								
					}
				}
				if( !($ticketLog instanceof TicketLog) )
				{
					$ticketLog = TicketLogFactory::createFromArray(array(
							'id_base_ticket' => $ticket->getIdBaseTicket(),
							'id_user' => $user->getIdUser(),
							'event_type' => TicketLog::$EventTypes['Last_escalation_percentage'],
							'note' => '',
					));
				}
				$now = new \Zend_Date();
				$ticketLog->setDateLog($now->get('yyyy-MM-dd HH:mm:ss'));
				$ticketLog->setChangedFrom((int)$lastPercentage);
				$ticketLog->setChangedTo((int)$percentage);
				$this->getCatalog('TicketLogCatalog')->save($ticketLog);

			}

		}

	}

	/**
	 *
	 * @param EscalationDetail $detail
	 * @param Category $category
	 * @return array
	 */
	private function getEmails(EscalationDetail $detail,  $category){
		$emails = array();

		if( $detail->isEmailType() ){
			$emails = array($detail->getValue());
		}elseif( $detail->isEmployeeType() ){
			$employee = EmployeeQuery::create()->findByPKOrThrow($detail->getValue(), "The employee not exists");
			$emails = EmailQuery::create()
			->innerJoinPerson()
			->whereAdd("Person.id_person", $employee->getIdPerson())->find()->toCombo();
		}elseif( $detail->isGroupLeaderType() ){
			$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exists");
			$user = UserQuery::create()->findByPKOrThrow($group->getIdUser(), "The user not exists");
			if ($user->isActive()){
				$emails = EmailQuery::create()
				->innerJoinPerson()
				->whereAdd("Person.id_person", $user->getIdPerson())
				->find()->toCombo();
			}
		}
		return $emails;
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
	 *
	 * @param ServiceLevelService $serviceLevelService
	 */
	public function setServiceLevelService(ServiceLevelService $serviceLevelService){
		$this->serviceLevelService = $serviceLevelService;
	}

}
