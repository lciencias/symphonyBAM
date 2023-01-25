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
 * ClientCategoryLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientCategoryLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_category_logs';

    /**
     * Constants Fields
     */
    const ID_CATEGORY_LOG = 'id_category_log';
    const ID_USER = 'id_user';
    const ID_CLIENT_CATEGORY = 'id_client_category';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idCategoryLog;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idClientCategory;


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
        return $this->getIdCategoryLog();
    }


    /**
     * @return int
     */
    public function getIdCategoryLog(){
        return $this->idCategoryLog;
    }

    /**
     * @param int $idCategoryLog
     * @return ClientCategoryLog
     */
    public function setIdCategoryLog($idCategoryLog){
        $this->idCategoryLog = $idCategoryLog;
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
     * @return ClientCategoryLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdClientCategory(){
        return $this->idClientCategory;
    }

    /**
     * @param int $idClientCategory
     * @return ClientCategoryLog
     */
    public function setIdClientCategory($idClientCategory){
        $this->idClientCategory = $idClientCategory;
        return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
     //   return $this->dateLog;
    	return self::format($this->dateLog);
    }

    /**
     * @param string $dateLog
     * @return ClientCategoryLog
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
     * @return ClientCategoryLog
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
     * @return ClientCategoryLog
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
            'id_category_log' => $this->getIdCategoryLog(),
            'id_user' => $this->getIdUser(),
            'id_client_category' => $this->getIdClientCategory(),
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