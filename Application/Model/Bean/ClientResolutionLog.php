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
 * ClientResolutionLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientResolutionLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_resolution_logs';

    /**
     * Constants Fields
     */
    const ID_CLIENT_RESOLUTION_LOG = 'id_client_resolution_log';
    const ID_CLIENT_RESOLUTION = 'id_client_resolution';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idClientResolutionLog;


    /**
     * @var int
     */
    private $idClientResolution;


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
        return $this->getIdClientResolutionLog();
    }


    /**
     * @return int
     */
    public function getIdClientResolutionLog(){
        return $this->idClientResolutionLog;
    }

    /**
     * @param int $idClientResolutionLog
     * @return ClientResolutionLog
     */
    public function setIdClientResolutionLog($idClientResolutionLog){
        $this->idClientResolutionLog = $idClientResolutionLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdClientResolution(){
        return $this->idClientResolution;
    }

    /**
     * @param int $idClientResolution
     * @return ClientResolutionLog
     */
    public function setIdClientResolution($idClientResolution){
        $this->idClientResolution = $idClientResolution;
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
     * @return ClientResolutionLog
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
     * @return ClientResolutionLog
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
     * @return ClientResolutionLog
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
     * @return ClientResolutionLog
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
            'id_client_resolution_log' => $this->getIdClientResolutionLog(),
            'id_client_resolution' => $this->getIdClientResolution(),
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