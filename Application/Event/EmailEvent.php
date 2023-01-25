<?php

namespace Application\Event;

/**
 *
 * @author chente
 *
 */
class EmailEvent extends CoreEvent
{

	/**
	 * @var unknown_type
	 */
	const TICKET_CREATE = 'ticket.create';
	const TICKET_CHANGE_STATUS = 'ticket.change_status';
	const TICKET_ESCALATION = 'ticket.escalation';
	const TICKET_UPDATE = 'ticket.update';
	const TICKET_CANCEL = 'ticket.cancel';
	const TICKET_CLOSE = 'ticket.close';
	const TICKET_RESOLVE = 'ticket.resolve';
	const TICKET_ASSIGN = 'ticket.assign';
	const TICKET_REASSIGN = 'ticket.reassign';
	const TICKET_PAUSE = 'ticket.pause';
	const TICKET_RESUME = 'ticket.resume';
	const TICKET_ACTIVITY = 'ticket.activity';
	const TICKET_LETTER = 'ticket.letter';
	const TICKET_REQUEST = 'ticket.request';
	const TICKET_RECOVERED = 'ticket.recovered';
	const TICKET_BROKEN = 'ticket.broken';
	const TICKET_DISCOUNT = 'ticket.discount';
	const TICKET_INCOMPLETE = 'ticket.incomplete';
	const TICKET_EXPIRED = 'ticket.expired';
	const TICKET_FORMAT_ACL = 'ticket.format_acl';
	
	const TICKET_CLIENT_CREATE = 'ticket_client.create';
	const TICKET_CLIENT_CHANGE_STATUS = 'ticket_client.change_status';
	const TICKET_CLIENT_ESCALATION = 'ticket_client.escalation';
	const TICKET_CLIENT_UPDATE = 'ticket_client.update';
	const TICKET_CLIENT_CANCEL = 'ticket_client.cancel';
	const TICKET_CLIENT_CLOSE = 'ticket_client.close';
	const TICKET_CLIENT_RESOLVE = 'ticket_client.resolve';
	const TICKET_CLIENT_ASSIGN = 'ticket_client.assign';
	const TICKET_CLIENT_REASSIGN = 'ticket_client.reassign';
	const TICKET_CLIENT_PAUSE = 'ticket_client.pause';
	const TICKET_CLIENT_RESUME = 'ticket_client.resume';
	const TICKET_CLIENT_ACTIVITY = 'ticket_client.activity';
	const TICKET_CLIENT_LETTER = 'ticket_client.letter';
	const TICKET_CLIENT_REQUEST = 'ticket_client.request';
	const TICKET_CLIENT_RECOVERED = 'ticket_client.recovered';
	const TICKET_CLIENT_BROKEN = 'ticket_client.broken';
	const TICKET_CLIENT_DISCOUNT = 'ticket.discount';
	const TICKET_CLIENT_INCOMPLETE = 'ticket_client.incomplete';
	const TICKET_CLIENT_EXPIRED = 'ticket_client.expired';
	const TICKET_CLIENT_FORMAT_ACL = 'ticket_client.format_acl';
	const TICKET_CLIENT_REOPEN_CONDUSET = 'ticket_client.reopen_condusef';
	

	/**
	 *
	 * @return \Application\Model\Bean\Ticket
	 */
	public function getTicket(){
		return $this->getOrThrow('ticket', "El ticket no se ha definido");
	}

	/**
	 *
	 * @return \Application\Model\Bean\User
	 */
	public function getUser(){
		return $this->getOrThrow('user', "El usuario no se ha definido");
	}

	/**
	 * @return array
	 */
	public static function getEvents(){
		return array(
				self::TICKET_CREATE => "New Ticket",
				self::TICKET_CHANGE_STATUS => "Status Changed",
				self::TICKET_ESCALATION => "Escalation",
				self::TICKET_UPDATE => "Ticket Updated",
				self::TICKET_CANCEL => "Ticket Cancelled",
				self::TICKET_CLOSE => "Ticket Closed",
				self::TICKET_RESOLVE => "Ticket Resolved",
				self::TICKET_ASSIGN => "Ticket Assigned",
				self::TICKET_REASSIGN => "Ticket Reasigned",
				self::TICKET_PAUSE => "Ticket Paused",
				self::TICKET_RESUME => "Ticket Resumed",
				self::TICKET_ACTIVITY => "Ticket Activity",
				self::TICKET_LETTER => "Resolutory Letter",
				self::TICKET_REQUEST => "Ticket Request",
				//self::TICKET_RECOVERED => "Ticket Recovered",
				//self::TICKET_BROKEN => "Ticket Broken",
				self::TICKET_INCOMPLETE => "Ticket Incomplete",
				self::TICKET_EXPIRED => "Ticket Expired",
				self::TICKET_DISCOUNT => "Ticket Discount",
				self::TICKET_FORMAT_ACL => "Format Clarification",
		);
	}
	/**
	 *
	 * @return array
	 */
	public static function getTicketClientEvents(){
		return array(
				self::TICKET_CLIENT_CREATE => "New Ticket Client",
				self::TICKET_CLIENT_CHANGE_STATUS => "Status Changed",
				self::TICKET_CLIENT_ESCALATION => "Escalation",
				self::TICKET_CLIENT_UPDATE => "Ticket Client Updated",
				self::TICKET_CLIENT_CANCEL => "Ticket Client Cancelled",
				self::TICKET_CLIENT_CLOSE => "Ticket Client Closed",
				self::TICKET_CLIENT_RESOLVE => "Ticket Client Resolved",
				self::TICKET_CLIENT_ASSIGN => "Ticket Client Assigned",
				self::TICKET_CLIENT_REASSIGN => "Ticket Client Reasigned",
				self::TICKET_CLIENT_PAUSE => "Ticket Client Paused",
				self::TICKET_CLIENT_RESUME => "Ticket Client Resumed",
				self::TICKET_CLIENT_ACTIVITY => "Ticket Client Activity",
				self::TICKET_CLIENT_LETTER => "Customer Client Resolutions Letter",
				self::TICKET_CLIENT_REQUEST => "Ticket Client Request",
				//self::TICKET_CLIENT_RECOVERED => "Ticket Client Recovered",
				//self::TICKET_CLIENT_BROKEN => "Ticket Client Broken",
				self::TICKET_CLIENT_INCOMPLETE => "Ticket Client Incomplete",
				self::TICKET_CLIENT_EXPIRED => "Ticket Client Expired",
				self::TICKET_CLIENT_DISCOUNT => "Ticket Client Discount",
				self::TICKET_CLIENT_FORMAT_ACL => "Format Clarification",
				self::TICKET_CLIENT_REOPEN_CONDUSET => "Ticket Client Reopen",
				);
	}
}
