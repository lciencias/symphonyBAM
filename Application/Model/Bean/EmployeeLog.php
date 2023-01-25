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
 * EmployeeLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class EmployeeLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_employee_logs';

    /**
     * Constants Fields
     */
    const ID_EMPLOYEE_LOG = 'id_employee_log';
    const ID_EMPLOYEE = 'id_employee';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idEmployeeLog;


    /**
     * @var int
     */
    private $idEmployee;


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
        return $this->getIdEmployeeLog();
    }


    /**
     * @return int
     */
    public function getIdEmployeeLog(){
        return $this->idEmployeeLog;
    }

    /**
     * @param int $idEmployeeLog
     * @return EmployeeLog
     */
    public function setIdEmployeeLog($idEmployeeLog){
        $this->idEmployeeLog = $idEmployeeLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdEmployee(){
        return $this->idEmployee;
    }

    /**
     * @param int $idEmployee
     * @return EmployeeLog
     */
    public function setIdEmployee($idEmployee){
        $this->idEmployee = $idEmployee;
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
     * @return EmployeeLog
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
     * @return EmployeeLog
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
     * @return EmployeeLog
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
     * @return EmployeeLog
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
            'id_employee_log' => $this->getIdEmployeeLog(),
            'id_employee' => $this->getIdEmployee(),
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
        'Reactivate' =>4
    );

}