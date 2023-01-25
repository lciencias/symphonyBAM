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
 * RequiredFieldLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class RequiredFieldLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_required_field_logs';

    /**
     * Constants Fields
     */
    const ID_REQUIRED_FIELD_LOG = 'id_required_field_log';
    const ID_USER = 'id_user';
    const ID_REQUIRED_FIELD = 'id_required_field';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idRequiredFieldLog;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idRequiredField;


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
        return $this->getIdRequiredFieldLog();
    }


    /**
     * @return int
     */
    public function getIdRequiredFieldLog(){
        return $this->idRequiredFieldLog;
    }

    /**
     * @param int $idRequiredFieldLog
     * @return RequiredFieldLog
     */
    public function setIdRequiredFieldLog($idRequiredFieldLog){
        $this->idRequiredFieldLog = $idRequiredFieldLog;
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
     * @return RequiredFieldLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdRequiredField(){
        return $this->idRequiredField;
    }

    /**
     * @param int $idRequiredField
     * @return RequiredFieldLog
     */
    public function setIdRequiredField($idRequiredField){
        $this->idRequiredField = $idRequiredField;
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
     * @return RequiredFieldLog
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
     * @return RequiredFieldLog
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
     * @return RequiredFieldLog
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
            'id_required_field_log' => $this->getIdRequiredFieldLog(),
            'id_user' => $this->getIdUser(),
            'id_required_field' => $this->getIdRequiredField(),
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