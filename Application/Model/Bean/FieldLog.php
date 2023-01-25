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
 * FieldLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class FieldLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_field_logs';

    /**
     * Constants Fields
     */
    const ID_FIELD_LOG = 'id_field_log';
    const ID_FIELD = 'id_field';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idFieldLog;


    /**
     * @var int
     */
    private $idField;


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
     * @var string
     */
    private $notes;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdFieldLog();
    }


    /**
     * @return int
     */
    public function getIdFieldLog(){
        return $this->idFieldLog;
    }

    /**
     * @param int $idFieldLog
     * @return FieldLog
     */
    public function setIdFieldLog($idFieldLog){
        $this->idFieldLog = $idFieldLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdField(){
        return $this->idField;
    }

    /**
     * @param int $idField
     * @return FieldLog
     */
    public function setIdField($idField){
        $this->idField = $idField;
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
     * @return FieldLog
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
        //return $this->dateLog;
    }

    /**
     * @param string $dateLog
     * @return FieldLog
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
     * @return FieldLog
     */
    public function setEventType($eventType){
        $this->eventType = $eventType;
        return $this;
    }


    /**
     * @return string
     */
    public function getNotes(){
        return $this->notes;
    }

    /**
     * @param string $notes
     * @return FieldLog
     */
    public function setNotes($notes){
        $this->notes = $notes;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_field_log' => $this->getIdFieldLog(),
            'id_field' => $this->getIdField(),
            'id_user' => $this->getIdUser(),
            'date_log' => $this->getDateLog(),
            'event_type' => $this->getEventType(),
            'notes' => $this->getNotes(),
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