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
 * RequiredDocumentLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class RequiredDocumentLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_required_document_logs';

    /**
     * Constants Fields
     */
    const ID_REQUIRED_DOCUMENT_LOG = 'id_required_document_log';
    const ID_USER = 'id_user';
    const ID_REQUIRED_DOCUMENT = 'id_required_document';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idRequiredDocumentLog;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idRequiredDocument;


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
        return $this->getIdRequiredDocumentLog();
    }


    /**
     * @return int
     */
    public function getIdRequiredDocumentLog(){
        return $this->idRequiredDocumentLog;
    }

    /**
     * @param int $idRequiredDocumentLog
     * @return RequiredDocumentLog
     */
    public function setIdRequiredDocumentLog($idRequiredDocumentLog){
        $this->idRequiredDocumentLog = $idRequiredDocumentLog;
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
     * @return RequiredDocumentLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdRequiredDocument(){
        return $this->idRequiredDocument;
    }

    /**
     * @param int $idRequiredDocument
     * @return RequiredDocumentLog
     */
    public function setIdRequiredDocument($idRequiredDocument){
        $this->idRequiredDocument = $idRequiredDocument;
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
     * @return RequiredDocumentLog
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
     * @return RequiredDocumentLog
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
     * @return RequiredDocumentLog
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
            'id_required_document_log' => $this->getIdRequiredDocumentLog(),
            'id_user' => $this->getIdUser(),
            'id_required_document' => $this->getIdRequiredDocument(),
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