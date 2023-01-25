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
 * TicketTypeLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class TicketTypeLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_ticket_type_logs';

    /**
     * Constants Fields
     */
    const ID_TICKET_TYPE_LOG = 'id_ticket_type_log';
    const ID_TICKET_TYPE = 'id_ticket_type';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_LOG = 'event_log';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idTicketTypeLog;


    /**
     * @var int
     */
    private $idTicketType;


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
    private $eventLog;


    /**
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicketTypeLog();
    }


    /**
     * @return int
     */
    public function getIdTicketTypeLog(){
        return $this->idTicketTypeLog;
    }

    /**
     * @param int $idTicketTypeLog
     * @return TicketTypeLog
     */
    public function setIdTicketTypeLog($idTicketTypeLog){
        $this->idTicketTypeLog = $idTicketTypeLog;
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
     * @return TicketTypeLog
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
     * @return TicketTypeLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
        return $this->dateLog;
    }

    /**
     * @param string $dateLog
     * @return TicketTypeLog
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
            $this->dateLogAsZendDate = new \Zend_Date($this->dateLog, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->dateLogAsZendDate;
    }


    /**
     * @return int
     */
    public function getEventLog(){
        return $this->eventLog;
    }

    /**
     * @param int $eventLog
     * @return TicketTypeLog
     */
    public function setEventLog($eventLog){
        $this->eventLog = $eventLog;
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
     * @return TicketTypeLog
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
            'id_ticket_type_log' => $this->getIdTicketTypeLog(),
            'id_ticket_type' => $this->getIdTicketType(),
            'id_user' => $this->getIdUser(),
            'date_log' => $this->getDateLog(),
            'event_log' => $this->getEventLog(),
            'note' => $this->getNote(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getEventTypeName(){
        return array_search($this->getEventLog(), self::$EventTypes);
    }

    /**
     * @staticvar array
     */
    public static $EventTypes = array(
        'Create' => 1,
        'Update' => 2,
        'Delete' => 3,
        'Reactivate' => 4,
    );

}