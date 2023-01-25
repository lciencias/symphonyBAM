<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * BaseTicket
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
use Application\Query\ChannelQuery;

use Application\Query\TicketTypeQuery;

use Application\Query\AssignmentQuery;

use Application\Query\UserQuery;

use Automatic\Automatable;

class BaseTicket extends AbstractBean implements Automatable{

	/**
	 * TABLENAME
	 */
	const TABLENAME = 'pcs_symphony_base_tickets';

	/**
	 * Constants Fields
	 */
	const ID_BASE_TICKET = 'id_base_ticket';
	const ID_CHANNEL = 'id_channel';
	const ID_TICKET_TYPE = 'id_ticket_type';
	const ID_USER = 'id_user';
	const ID_ASSIGNMENT = 'id_assignment';
	const STATUS = 'status';
	const DESCRIPTION = 'description';
	const CREATED = 'created';
	const SCHEDULED_DATE = 'scheduled_date';
	const IS_STOPPED = 'is_stopped';
	const TYPE = 'type';
	const REGISTRY = 'registry';

	/**
	 * @var int
	 */
	private $idBaseTicket;


	/**
	 * @var int
	 */
	private $idChannel;


	/**
	 * @var int
	 */
	private $idTicketType;


	/**
	 * @var int
	 */
	private $idUser;


	/**
	 * @var int
	 */
	private $idAssignment;


	/**
	 * @var int
	 */
	private $status;


	/**
	 * @var string
	 */
	private $description;


	/**
	 * @var string
	 */
	private $created;

	/**
	 * @var \Zend_Date
	 */
	private $createdAsZendDate;


	/**
	 * @var string
	 */
	private $scheduledDate;

	/**
	 * @var \Zend_Date
	 */
	private $scheduledDateAsZendDate;


	/**
	 * @var boolean
	 */
	private $isStopped;


	/**
	 * @var string
	 */
	private $registry;
	
	
	/**
	 *
	 * @return int
	 */
	public function getIndex(){
		return $this->getIdBaseTicket();
	}

	/**
	 * (non-PHPdoc)
	 * @see Automatic.Automatable::getStateKey()
	 */
	public function getStateKey(){
		return $this->getStatus();
	}
	/**
	 * @return int
	 */
	public function getIdBaseTicket(){
		return $this->idBaseTicket;
	}

	/**
	 * @param int $idBaseTicket
	 * @return BaseTicket
	 */
	public function setIdBaseTicket($idBaseTicket){
		$this->idBaseTicket = $idBaseTicket;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdChannel(){
		return $this->idChannel;
	}

	/**
	 * @param int $idChannel
	 * @return BaseTicket
	 */
	public function setIdChannel($idChannel){
		$this->idChannel = $idChannel;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdTicketType(){
		return $this->idTicketType;
	}

	/**
	 * @param int $idTicketType
	 * @return BaseTicket
	 */
	public function setIdTicketType($idTicketType){
		$this->idTicketType = $idTicketType;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdUser(){
		return $this->idUser;
	}

	/**
	 * @param int $idUser
	 * @return BaseTicket
	 */
	public function setIdUser($idUser){
		$this->idUser = $idUser;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdAssignment(){
		return $this->idAssignment;
	}

	/**
	 * @param int $idAssignment
	 * @return BaseTicket
	 */
	public function setIdAssignment($idAssignment){
		$this->idAssignment = $idAssignment;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @param int $status
	 * @return BaseTicket
	 */
	public function setStatus($status){
		$this->status = $status;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return BaseTicket
	 */
	public function setDescription($description){
		$this->description = $description;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getCreated(){
		return self::format($this->created);
	}

	/**
	 * @param string $created
	 * @return BaseTicket
	 */
	public function setCreated($created){
		$this->created = $created;
		return $this;
	}

	/**
	 * @return \Zend_Date
	 */
	public function getCreatedAsZendDate(){
		if( null == $this->createdAsZendDate ){
			$this->createdAsZendDate = new \Zend_Date(self::format($this->created), 'yyyy-MM-dd HH:mm:ss');
		}
		return $this->createdAsZendDate;
	}

	/**
	 * @return string
	 */
	public function getScheduledDate(){
		return self::format($this->scheduledDate);
	}

	/**
	 * @return string
	 */
	public function hasScheduledDate(){
		return !empty($this->scheduledDate) &&
		\Zend_Date::isDate(self::format($this->scheduledDate), 'yyyy-MM-dd HH:mm:ss');
	}

	/**
	 * @param string $scheduledDate
	 * @return BaseTicket
	 */
	public function setScheduledDate($scheduledDate){
		$this->scheduledDate = $scheduledDate;
		return $this;
	}

	/**
	 * @return \Zend_Date
	 */
	public function getScheduledDateAsZendDate(){
		if( null == $this->scheduledDateAsZendDate ){
			$this->scheduledDateAsZendDate = new \Zend_Date(self::format($this->scheduledDate), 'yyyy-MM-dd HH:mm:ss');
		}
		return $this->scheduledDateAsZendDate;
	}


	/**
	 * @return boolean
	 */
	public function getIsStopped(){
		return $this->isStopped;
	}

	/**
	 * @param boolean $isStopped
	 * @return BaseTicket
	 */
	public function setIsStopped($isStopped){
		$this->isStopped = $isStopped;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * @param int $type
	 * @return BaseTicket
	 */
	public function setType($type){
		$this->type = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRegistry(){
		return self::format($this->registry);
	}
	
	/**
	 * @param string $registry
	 * @return BaseTicket
	 */
	public function setRegistry($registry){
		$this->registry = $registry;
		return $this;
	}

	/**
	 * Convert to array
	 * @return array
	 */
	public function toArray()
	{
		$array = array(
				'id_base_ticket' => $this->getIdBaseTicket(),
				'id_channel' => $this->getIdChannel(),
				'id_ticket_type' => $this->getIdTicketType(),
				'id_user' => $this->getIdUser(),
				'id_assignment' => $this->getIdAssignment(),
				'status' => $this->getStatus(),
				'description' => $this->getDescription(),
				'created' => $this->getCreated(),
				'scheduled_date' => $this->getScheduledDate(),
				'is_stopped' => $this->getIsStopped(),
				'type' => $this->getType(),
				'registry' => $this->getRegistry(),
		);
		return $array;
	}
	
	/**
	 * @return array
	 */
	public function toArrayForList(){
		$array = array(
				'id_channel' => $this->getIdChannel(),
				'id_ticket_type' => $this->getIdTicketType(),
				'id_user' => $this->getIdUser(),
				'id_assignment' => $this->getIdAssignment(),
				'description' => $this->getDescription(),
				'created' => $this->getCreated(),
				'scheduled_date' => $this->getScheduledDate(),
				'is_stopped' => $this->getIsStopped(),
				'channel' => $this->getChannelName(),
				'ticket_type' => $this->getTicketTypeName(),
				'register_by' => $this->getRegistererName(),
				'assigned_to' => $this->getAssignedName(),
				'status' => $this->getStatusName(),
				'registry' => $this->getRegistry(),
		);
		return $array;
	}
	/**
	 *
	 * @return string
	 */
	public function getStatusName(){
		return self::$Statuses[$this->getStatus()];
	}

	/**
	 *
	 * @var array
	 */
	public static $Statuses = array(
                        0 => 'Created',
			1 => 'Unread',
			2 => 'Read',
			3 => 'Assigned',
			4 => 'Working',
			5 => 'Resolved',
			6 => 'Reopen',
			7 => 'Closed',
			8 => 'Canceled',
	);

	/**
	 *
	 * @var array
	 */
	public static $Type = array(
			'Ticket' => 1,
			'TicketClient' => 2,
	);

	/**
	 * @return string
	 */
	public function getTypeName (){
		return array_search($this->getType(), self::$Type);
	}

	/**
	 *
	 * @param string $header
	 */
	public static function getStatusCombo($header = null){
		$array = array();
		if ($header)
			$array[''] = $header;
		return $array + self::$Statuses;
	}
	/**
	 * @return string
	 */
	public function getRegistererName(){
		return UserQuery::create()->findByPK($this->getIdUser())->getFullName();
	}
	/**
	 * @return string
	 */
	public function getAssignedName(){
		$value = false;
		if(AssignmentQuery::create()->whereAdd(Assignment::ID_BASE_TICKET, $this->getIdBaseTicket())->count()){
			$idUser = AssignmentQuery::create()->whereAdd(Assignment::ID_BASE_TICKET, $this->getIdBaseTicket())->orderBy(Assignment::ID_ASSIGNMENT,AssignmentQuery::DESC)->findOne()->getIdUser();
			$value = UserQuery::create()->findByPK($idUser)->getFullName();
		}
			
		return $value;
	}
	/**
	 * @return string
	 */
	public function getTicketTypeName(){
		return TicketTypeQuery::create()->findByPK($this->getIdTicketType())->getName();
	}
	/**
	 * @return string
	 */
	public function getChannelName(){
		return ChannelQuery::create()->findByPK($this->getIdChannel())->getName();
	}
}