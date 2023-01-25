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
 * PriorityLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class PriorityLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_priority_logs';

    /**
     * Constants Fields
     */
    const ID_PRIORITY_LOG = 'id_priority_log';
    const ID_PRIORITY = 'id_priority';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idPriorityLog;


    /**
     * @var int
     */
    private $idPriority;


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
        return $this->getIdPriorityLog();
    }


    /**
     * @return int
     */
    public function getIdPriorityLog(){
        return $this->idPriorityLog;
    }

    /**
     * @param int $idPriorityLog
     * @return PriorityLog
     */
    public function setIdPriorityLog($idPriorityLog){
        $this->idPriorityLog = $idPriorityLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdPriority(){
        return $this->idPriority;
    }

    /**
     * @param int $idPriority
     * @return PriorityLog
     */
    public function setIdPriority($idPriority){
        $this->idPriority = $idPriority;
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
     * @return PriorityLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }

    /**
    * @return int
    */
    public function getIdEventType(){
    	return $this->eventType;
    }

    /**
     * @param int $idUser
     * @return PriorityLog
     */
    public function setIdEventType($eventType){
    	$this->eventType = $eventType;
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
     * @return PriorityLog
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
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return PriorityLog
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
            'id_priority_log' => $this->getIdPriorityLog(),
            'id_priority' => $this->getIdPriority(),
            'id_user' => $this->getIdUser(),
            'date_log' => $this->getDateLog(),
            'event_type' => $this->getIdEventType(),
            'note' => $this->getNote(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getEventTypeName(){
        return array_search($this->getIdEventType(), self::$EventTypes);
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