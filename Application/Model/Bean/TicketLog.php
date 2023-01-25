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
 * TicketLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class TicketLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_ticket_logs';

    /**
     * Constants Fields
     */
    const ID_TICKET_LOG = 'id_ticket_log';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const CHANGED_FROM = 'changed_from';
    const CHANGED_TO = 'changed_to';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idTicketLog;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var string
     */
    private $dateLog;

    /**
     * @var \Zend_Date
     */
    private $dateLogAsZendDate;


    /**
     * @var int
     */
    private $eventType;


    /**
     * @var int
     */
    private $changedFrom;


    /**
     * @var int
     */
    private $changedTo;


    /**
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicketLog();
    }


    /**
     * @return int
     */
    public function getIdTicketLog(){
        return $this->idTicketLog;
    }

    /**
     * @param int $idTicketLog
     * @return TicketLog
     */
    public function setIdTicketLog($idTicketLog){
        $this->idTicketLog = $idTicketLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdBaseTicket(){
        return $this->idBaseTicket;
    }

    /**
     * @param int $idBaseTicket
     * @return TicketLog
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
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
     * @return TicketLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
    	return self::format($this->dateLog);
    }

    /**
     * @param string $dateLog
     * @return TicketLog
     */
    public function setDateLog($dateLog){
        $this->dateLog = $dateLog;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getDateLogAsZendDate(){
        if( null == $this->dateLogAsZendDate ){     
        	$this->dateLogAsZendDate = new \Zend_Date(self::format($this->dateLog), 'yyyy-MM-dd HH:mm:ss');
        	//$this->dateLogAsZendDate = new \Zend_Date($this->format($this->dateLog), 'YYYY-MM-dd HH:mm:ss');
            //$this->dateLogAsZendDate = new \Zend_Date($this->dateLog, 'yyyy-MM-dd HH:mm:ss');
        }
        //print_r($this->dateLogAsZendDate);
        return $this->dateLogAsZendDate;
    }


    /**
     * @return int
     */
    public function getEventType(){
        return $this->eventType;
    }

    /**
     * @param int $eventType
     * @return TicketLog
     */
    public function setEventType($eventType){
        $this->eventType = $eventType;
        return $this;
    }


    /**
     * @return int
     */
    public function getChangedFrom(){
        return $this->changedFrom;
    }

    /**
     * @param int $changedFrom
     * @return TicketLog
     */
    public function setChangedFrom($changedFrom){
        $this->changedFrom = $changedFrom;
        return $this;
    }


    /**
     * @return int
     */
    public function getChangedTo(){
        return $this->changedTo;
    }

    /**
     * @param int $changedTo
     * @return TicketLog
     */
    public function setChangedTo($changedTo){
        $this->changedTo = $changedTo;
        return $this;
    }


    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return TicketLog
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
            'id_ticket_log' => $this->getIdTicketLog(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_user' => $this->getIdUser(),
            'date_log' => $this->getDateLog(),
            'event_type' => $this->getEventType(),
            'changed_from' => $this->getChangedFrom(),
            'changed_to' => $this->getChangedTo(),
            'note' => $this->getNote(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getEventTypeName(){
        return array_search($this->getEventType(), self::$EventTypes);
    }

    /**
     * @staticvar array
     */
    public static $EventTypes = array(
        'Create' => 1,
        'Update' => 2,
        'Delete' => 3,
        'Status' => 4,
        'Assign' => 5,
        'Pause'  => 6,
        'Resume' => 7,
        'Resolution_Start_Time' => 8,
        'Resolution_End_Time'   => 9,
        'Response_Start_Time'   => 10,
        'Response_End_Time'     => 11,
        'Last_escalation_percentage' => 12,
    );

    /**
     *
     * @staticvar array
     */
    public static $TrackeableEvents = array(
        'Create' => 1,
        'Update' => 2,
        'Delete' => 3,
        'Status' => 4,
        'Assign' => 5,
        'Pause'  => 6,
        'Resume' => 7,
    );

    /**
     * @return boolean
     */
    public function isStatusChange(){
        return $this->getEventType() == self::$EventTypes['Status'];
    }

    /**
     *
     * @return string
     */
    public function getChangedToName(){
        return Ticket::$Statuses[$this->getChangedTo()];
    }

}