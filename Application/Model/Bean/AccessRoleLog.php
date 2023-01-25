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
 * AccessRoleLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class AccessRoleLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_access_role_logs';

    /**
     * Constants Fields
     */
    const ID_ACCESS_ROLE_LOG = 'id_access_role_log';
    const ID_ACCESS_ROLE = 'id_access_role';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idAccessRoleLog;


    /**
     * @var int
     */
    private $idAccessRole;


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
        return $this->getIdAccessRoleLog();
    }


    /**
     * @return int
     */
    public function getIdAccessRoleLog(){
        return $this->idAccessRoleLog;
    }

    /**
     * @param int $idAccessRoleLog
     * @return AccessRoleLog
     */
    public function setIdAccessRoleLog($idAccessRoleLog){
        $this->idAccessRoleLog = $idAccessRoleLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdAccessRole(){
        return $this->idAccessRole;
    }

    /**
     * @param int $idAccessRole
     * @return AccessRoleLog
     */
    public function setIdAccessRole($idAccessRole){
        $this->idAccessRole = $idAccessRole;
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
     * @return AccessRoleLog
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
     * @return AccessRoleLog
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
     * @return AccessRoleLog
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
     * @return AccessRoleLog
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
            'id_access_role_log' => $this->getIdAccessRoleLog(),
            'id_access_role' => $this->getIdAccessRole(),
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