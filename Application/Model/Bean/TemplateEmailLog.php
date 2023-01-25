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
 * TemplateEmailLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class TemplateEmailLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_template_email_logs';

    /**
     * Constants Fields
     */
    const ID_TEMPLATE_EMAIL_LOG = 'id_template_email_log';
    const ID_TEMPLATE_EMAIL = 'id_template_email';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idTemplateEmailLog;


    /**
     * @var int
     */
    private $idTemplateEmail;


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
        return $this->getIdTemplateEmailLog();
    }


    /**
     * @return int
     */
    public function getIdTemplateEmailLog(){
        return $this->idTemplateEmailLog;
    }

    /**
     * @param int $idTemplateEmailLog
     * @return TemplateEmailLog
     */
    public function setIdTemplateEmailLog($idTemplateEmailLog){
        $this->idTemplateEmailLog = $idTemplateEmailLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTemplateEmail(){
        return $this->idTemplateEmail;
    }

    /**
     * @param int $idTemplateEmail
     * @return TemplateEmailLog
     */
    public function setIdTemplateEmail($idTemplateEmail){
        $this->idTemplateEmail = $idTemplateEmail;
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
     * @return TemplateEmailLog
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
     * @return TemplateEmailLog
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
     * @return TemplateEmailLog
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
     * @return TemplateEmailLog
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
            'id_template_email_log' => $this->getIdTemplateEmailLog(),
            'id_template_email' => $this->getIdTemplateEmail(),
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