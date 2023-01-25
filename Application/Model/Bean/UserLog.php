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

namespace Application\Model\Bean;

/**
 *
 * UserLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class UserLog extends AbstractBean{

	/**
	 * TABLENAME
	 */
	const TABLENAME = 'pcs_common_user_logs';

	/**
	 * Constants Fields
	 */
	const ID_USER_LOG = 'id_user_log';
	const ID_USER = 'id_user';
	const EVENT_TYPE = 'event_type';
	const IP = 'ip';
	const ID_RESPONSIBLE = 'id_responsible';
	const TIMESTAMP = 'timestamp';
	const NOTE = 'note';

	const LOGIN = 1;
	const LOGOUT = 2;
	const FAILED_LOGIN = 3;
	const CREATE = 4;
	const EDIT = 5;
	const DEACTIVATE = 6;
	const REACTIVATE = 7;
	const CHANGE_PASSWORD = 8;
	/**
	 * Numero de veces necesarias para poder repetir una contraseña anterior 
	 * @var int
	 */
	const PASSWORD_REPEAT_TIMES = 3;
	/**
	 * @var int
	 */
	private $idUserLog;


	/**
	 * @var int
	 */
	private $idUser;


	/**
	 * @var int
	 */
	private $eventType;


	/**
	 * @var string
	 */
	private $ip;


	/**
	 * @var int
	 */
	private $idResponsible;


	/**
	 * @var string
	 */
	private $timestamp;

	/**
	 * @var \Zend_Date
	 */
	private $timestampAsZendDate;


	/**
	 * @var string
	 */
	private $note;


	/**
	 *
	 * @return int
	 */
	public function getIndex(){
		return $this->getIdUserLog();
	}

	/**
	 * @return int
	 */
	public function getIdUserLog(){
		return $this->idUserLog;
	}

	/**
	 * @param int $idUserLog
	 * @return UserLog
	 */
	public function setIdUserLog($idUserLog){
		$this->idUserLog = $idUserLog;
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
	 * @return UserLog
	 */
	public function setIdUser($idUser){
		$this->idUser = $idUser;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getEventType(){
		return $this->eventType;
	}

	/**
	 * @param int $eventType
	 * @return UserLog
	 */
	public function setEventType($eventType){
		$this->eventType = $eventType;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getIp(){
		return $this->ip;
	}

	/**
	 * @param string $ip
	 * @return UserLog
	 */
	public function setIp($ip){
		$this->ip = $ip;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdResponsible(){
		return $this->idResponsible;
	}

	/**
	 * @param int $idResponsible
	 * @return UserLog
	 */
	public function setIdResponsible($idResponsible){
		$this->idResponsible = $idResponsible;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getTimestamp(){
		return $this->timestamp;
	}

	/**
	 * @param string $timestamp
	 * @return UserLog
	 */
	public function setTimestamp($timestamp){
		$this->timestamp = $timestamp;
		return $this;
	}

	/**
	 * @return \Zend_Date
	 */
	public function getTimestampAsZendDate(){
		if( null == $this->timestampAsZendDate ){
			$this->timestampAsZendDate = new \Zend_Date($this->timestamp, 'yyyy-MM-dd HH:mm:ss');
		}
		return $this->timestampAsZendDate;
	}


	/**
	 * @return string
	 */
	public function getNote(){
		return $this->note;
	}

	/**
	 * @param string $note
	 * @return UserLog
	 */
	public function setNote($note){
		$this->note = $note;
		return $this;
	}


	/**
	 * Convert to array
	 * @return array
	 */
	public function toArray()
	{
		$array = array(
				'id_user_log' => $this->getIdUserLog(),
				'id_user' => $this->getIdUser(),
				'event_type' => $this->getEventType(),
				'ip' => $this->getIp(),
				'id_responsible' => $this->getIdResponsible(),
				'timestamp' => $this->getTimestamp(),
				'note' => $this->getNote(),
		);
		return $array;
	}

	/**
	 * @staticvar array
	 */
	public static $EventTypeName = array(
			'Login' => 1,
			'Logout' => 2,
			'Failed login' => 3,
			'Create' => 4,
			'Edit' => 5,
			'Deactivate' => 6,
			'Reactivate' => 7,
			'Change Password' => 8,
	);

	public function getEventTypeName()
	{
		return array_search($this->getEventType(), self::$EventTypeName);
	}

}