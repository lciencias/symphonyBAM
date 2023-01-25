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
 * PositionLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class PositionLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_position_logs';

    /**
     * Constants Fields
     */
    const ID_POSITION_LOG = 'id_position_log';
    const ID_USER = 'id_user';
    const ID_POSITION = 'id_position';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idPositionLog;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idPosition;


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
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdPositionLog();
    }


    /**
     * @return int
     */
    public function getIdPositionLog(){
        return $this->idPositionLog;
    }

    /**
     * @param int $idPositionLog
     * @return PositionLog
     */
    public function setIdPositionLog($idPositionLog){
        $this->idPositionLog = $idPositionLog;
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
     * @return PositionLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdPosition(){
        return $this->idPosition;
    }

    /**
     * @param int $idPosition
     * @return PositionLog
     */
    public function setIdPosition($idPosition){
        $this->idPosition = $idPosition;
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
     * @return PositionLog
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
    public function getEventType(){
        return $this->eventType;
    }

    /**
     * @param int $eventType
     * @return PositionLog
     */
    public function setEventType($eventType){
        $this->eventType = $eventType;
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
     * @return PositionLog
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
            'id_position_log' => $this->getIdPositionLog(),
            'id_user' => $this->getIdUser(),
            'id_position' => $this->getIdPosition(),
            'date_log' => $this->getDateLog(),
            'event_type' => $this->getEventType(),
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
        'Reactivate' => 4,
    );

}