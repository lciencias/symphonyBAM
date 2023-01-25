<?php

namespace Application\Event;

use Application\Model\Catalog\TicketClientNotificationCatalog;

use Application\Model\Factory\TicketClientNotificationFactory;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\BaseTicket;

use Application\Model\Bean\Ticket;
use Application\Model\Bean\User;
use Application\Model\Catalog\NotificationCatalog;
use Application\Model\Factory\NotificationFactory;
use Application\Model\Collection\TemplateEmailCollection;
use Application\Model\Bean\TemplateEmail;
use Application\Query\TemplateEmailQuery;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 * @author chente
 *
 */
class EmailListener implements EventSubscriberInterface
{

	/**
	 *
	 * @return array
	 */
	public static function getSubscribedEvents(){
		return array(
				EmailEvent::TICKET_CREATE => 'ticketCreate',
				EmailEvent::TICKET_CHANGE_STATUS => 'ticketChangeStatus',
				EmailEvent::TICKET_ESCALATION => 'ticketEscalation',
				EmailEvent::TICKET_UPDATE => 'ticketUpdate',
				EmailEvent::TICKET_CANCEL => 'ticketCancel',
				EmailEvent::TICKET_CLOSE => 'ticketClose',
				EmailEvent::TICKET_RESOLVE => 'ticketResolve',
				EmailEvent::TICKET_ASSIGN => 'ticketAssign',
				EmailEvent::TICKET_REASSIGN => 'ticketReassign',
				EmailEvent::TICKET_PAUSE => 'ticketPause',
				EmailEvent::TICKET_RESUME => 'ticketResume',
				EmailEvent::TICKET_ACTIVITY => 'ticketActivity',
				
				EmailEvent::TICKET_CLIENT_CREATE => 'ticketClientCreate',
				EmailEvent::TICKET_CLIENT_CHANGE_STATUS => 'ticketClientChangeStatus',
				EmailEvent::TICKET_CLIENT_ESCALATION => 'ticketClientEscalation',
				EmailEvent::TICKET_CLIENT_UPDATE => 'ticketClientUpdate',
				EmailEvent::TICKET_CLIENT_CANCEL => 'ticketClientCancel',
				EmailEvent::TICKET_CLIENT_CLOSE => 'ticketClientClose',
				EmailEvent::TICKET_CLIENT_RESOLVE => 'ticketClientResolve',
				EmailEvent::TICKET_CLIENT_ASSIGN => 'ticketClientAssign',
				EmailEvent::TICKET_CLIENT_REASSIGN => 'ticketClientReassign',
				EmailEvent::TICKET_CLIENT_PAUSE => 'ticketClientPause',
				EmailEvent::TICKET_CLIENT_RESUME => 'ticketClientResume',
				EmailEvent::TICKET_CLIENT_ACTIVITY => 'ticketClientActivity',
		);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketUpdate(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_UPDATE);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketCancel(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CANCEL);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketResolve(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_RESOLVE);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketAssign(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_ASSIGN);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketReassign(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_REASSIGN);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketPause(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_PAUSE);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketResume(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_RESUME);
	}

	/**
	 * @param EmailEvent $event
	 */
	public function ticketClose(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLOSE);
	}

	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketEscalation(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_ESCALATION, $event->get('emails', array()));
	}

	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketCreate(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CREATE);
	}

	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketActivity(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_ACTIVITY);
	}

	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketChangeStatus(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CHANGE_STATUS);
	}

	
	
	
	
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientUpdate(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_UPDATE);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientCancel(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_CANCEL);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientResolve(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_RESOLVE);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientAssign(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_ASSIGN);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientReassign(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_REASSIGN);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientPause(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_PAUSE);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientResume(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_RESUME);
	}
	
	/**
	 * @param EmailEvent $event
	 */
	public function ticketClientClose(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_CLOSE);
	}
	
	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketClientEscalation(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_ESCALATION, $event->get('emails', array()));
	}
	
	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketClientCreate(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_CREATE);
	}
	
	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketClientActivity(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_ACTIVITY);
	}
	
	/**
	 *
	 * @param EmailEvent $event
	 */
	public function ticketClientChangeStatus(EmailEvent $event){
		$this->createNotifications($event->getTicket(), $event->getUser(), EmailEvent::TICKET_CLIENT_CHANGE_STATUS);
	}
	
	
	
	
	
	
	/**
	 *
	 * @param Ticket $ticket
	 * @param User $user
	 * @param string $eventName
	 */
	private function createNotifications(BaseTicket $ticket, User $user, $eventName, $emails = array())
	{
		$now = new \Zend_Date();
		$templates = $this->getTemplates($eventName);

		while( $templates->valid() ) {
			$template = $templates->read();
			$notification = NotificationFactory::createFromArray(array(
					'id_template_email' => $template->getIdTemplateEmail(),
					'id_base_ticket' => $ticket->getIdBaseTicket(),
					'created' => $now->get('yyyy-MM-dd HH:mm:ss'),
					'dispatched' => 0,
					'to' => implode(',', $emails),
					'cc' => '',
					'bcc' => '',
			));
			$this->getNotificationCatalog()->create($notification);
		}
	}

	/**
	 *
	 * @param unknown_type $eventName
	 * @return TemplateEmailCollection
	 */
	private function getTemplates($eventName){
		return TemplateEmailQuery::create()
		->whereAdd(TemplateEmail::EVENT, $eventName)
		->whereAdd(TemplateEmail::STATUS, TemplateEmail::$Status['Active'])
		->find();
	}

	/**
	 * Obtiene el registry
	 * @return \Zend_Registry
	 */
	public function getRegistry(){
		return \Zend_Registry::getInstance();
	}
	
	/**
	 * @return \Symfony\Component\DependencyInjection\Container
	 */
	public function getContainer(){
		return $this->getRegistry()->get('container');
	}
	
	/**
	 * @return NotificationCatalog
	 */
	private function getNotificationCatalog(){
		return $this->getContainer()->get('NotificationCatalog');
	}
	/**
	 * @return TicketClientNotificationCatalog
	 */
	private function getTicketClientNotificationCatalog(){
		return \Zend_Registry::get('container')->get('TicketClientNotificationCatalog');
	}
}