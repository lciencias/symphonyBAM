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
 * DocumentLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class DocumentLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_document_logs';

    /**
     * Constants Fields
     */
    const ID_DOCUMENT_LOG = 'id_document_log';
    const ID_DOCUMENT = 'id_document';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idDocumentLog;


    /**
     * @var int
     */
    private $idDocument;


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
        return $this->getIdDocumentLog();
    }


    /**
     * @return int
     */
    public function getIdDocumentLog(){
        return $this->idDocumentLog;
    }

    /**
     * @param int $idDocumentLog
     * @return DocumentLog
     */
    public function setIdDocumentLog($idDocumentLog){
        $this->idDocumentLog = $idDocumentLog;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdDocument(){
        return $this->idDocument;
    }

    /**
     * @param int $idDocument
     * @return DocumentLog
     */
    public function setIdDocument($idDocument){
        $this->idDocument = $idDocument;
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
     * @return DocumentLog
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
     * @return DocumentLog
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
     * @return DocumentLog
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
     * @return DocumentLog
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
            'id_document_log' => $this->getIdDocumentLog(),
            'id_document' => $this->getIdDocument(),
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