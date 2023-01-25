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
 * ServiceLevelLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class ServiceLevelLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_service_level_logs';

    /**
     * Constants Fields
     */
    const ID_SERVICE_LEVEL_LOG = 'id_service_level_log';
    const ID_SERVICE_LEVEL = 'id_service_level';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idServiceLevelLog;


    /**
     * @var int
     */
    private $idServiceLevel;


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
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdServiceLevelLog();
    }


    /**
     * @return int
     */
    public function getIdServiceLevelLog(){
        return $this->idServiceLevelLog;
    }

    /**
     * @param int $idServiceLevelLog
     * @return ServiceLevelLog
     */
    public function setIdServiceLevelLog($idServiceLevelLog){
        $this->idServiceLevelLog = $idServiceLevelLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdServiceLevel(){
        return $this->idServiceLevel;
    }

    /**
     * @param int $idServiceLevel
     * @return ServiceLevelLog
     */
    public function setIdServiceLevel($idServiceLevel){
        $this->idServiceLevel = $idServiceLevel;
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
     * @return ServiceLevelLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
        //return $this->dateLog;
        return self::format($this->dateLog);
    }

    /**
     * @param string $dateLog
     * @return ServiceLevelLog
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
     * @return ServiceLevelLog
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
     * @return ServiceLevelLog
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
            'id_service_level_log' => $this->getIdServiceLevelLog(),
            'id_service_level' => $this->getIdServiceLevel(),
            'id_user' => $this->getIdUser(),
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