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
 * BranchLog
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class BranchLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_branch_logs';

    /**
     * Constants Fields
     */
    const ID_BRANCH_LOG = 'id_branch_log';
    const ID_USER = 'id_user';
    const ID_BRANCH = 'id_branch';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTES = 'notes';

    /**
     * @var int
     */
    private $idBranchLog;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idBranch;


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
        return $this->getIdBranchLog();
    }


    /**
     * @return int
     */
    public function getIdBranchLog(){
        return $this->idBranchLog;
    }

    /**
     * @param int $idBranchLog
     * @return BranchLog
     */
    public function setIdBranchLog($idBranchLog){
        $this->idBranchLog = $idBranchLog;
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
     * @return BranchLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdBranch(){
        return $this->idBranch;
    }

    /**
     * @param int $idBranch
     * @return BranchLog
     */
    public function setIdBranch($idBranch){
        $this->idBranch = $idBranch;
        return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
        return self::format($this->dateLog);
    }

    /**
     * @param string $dateLog
     * @return BranchLog
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
     * @return BranchLog
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
     * @return BranchLog
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
            'id_branch_log' => $this->getIdBranchLog(),
            'id_user' => $this->getIdUser(),
            'id_branch' => $this->getIdBranch(),
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