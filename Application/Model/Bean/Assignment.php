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
 * Assignment
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Assignment extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_assignments';

    /**
     * Constants Fields
     */
    const ID_ASSIGNMENT = 'id_assignment';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_USER = 'id_user';
    const ID_RESOLUTION = 'id_resolution';
    const ASSIGNMENT_DATE = 'assignment_date';
    const RESOLUTION_DATE = 'resolution_date';
    const NOTE = 'note';
    const ID_FILE = 'id_file';
    const RECOVERY_AMOUNT = 'recovery_amount';
    const IS_RECOVERED_AMOUNT = 'is_recovered_amount';
    const ID_RESOLUTION_FILE = 'id_resolution_file';
    const STATUS = 'status';
    /**
     * @var int
     */
    private $idAssignment;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idResolution;


    /**
     * @var string
     */
    private $assignmentDate;

    /**
     * @var \Zend_Date
     */
    private $assignmentDateAsZendDate;


    /**
     * @var string
     */
    private $resolutionDate;

    /**
     * @var \Zend_Date
     */
    private $resolutionDateAsZendDate;

    /**
     *
     * @var string
     */
    private $note;
	
    /**
     * 
     * @var int
     */
    private $idFile;

    
    /**
     * 
     * @var float
     */
    private $recoveryAmount;
    
    /**
     *
     * @var String
     */
    private $isRecoveredAmount;

    /**
     * @var int
     */
    private $idResolutionFile;
    
    /**
     * @var int
     */
    private $status;
    
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAssignment();
    }


    /**
     * @return int
     */
    public function getIdAssignment(){
        return $this->idAssignment;
    }

    /**
     * @param int $idAssignment
     * @return Assignment
     */
    public function setIdAssignment($idAssignment){
        $this->idAssignment = $idAssignment;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdBaseTicket(){
        return $this->idBaseTicket;
    }

    /**
     * @param int $idBaseTicket
     * @return Assignment
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
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
     * @return Assignment
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdResolution(){
        return $this->idResolution;
    }

    /**
     * @param int $idResolution
     * @return Assignment
     */
    public function setIdResolution($idResolution){
        $this->idResolution = $idResolution;
        return $this;
    }


    /**
     * @return string
     */
    public function getAssignmentDate(){
        //return $this->assignmentDate;
        return self::format($this->assignmentDate);
    }

    /**
     * @param string $assignmentDate
     * @return Assignment
     */
    public function setAssignmentDate($assignmentDate){
        $this->assignmentDate = $assignmentDate;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getAssignmentDateAsZendDate(){
        if( null == $this->assignmentDateAsZendDate ){
            $this->assignmentDateAsZendDate = new \Zend_Date($this->assignmentDate, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->assignmentDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getResolutionDate(){
        //return $this->resolutionDate;
    	return self::format($this->resolutionDate);
    }

    /**
     * @param string $resolutionDate
     * @return Assignment
     */
    public function setResolutionDate($resolutionDate){
        $this->resolutionDate = $resolutionDate;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getResolutionDateAsZendDate(){
        if( null == $this->resolutionDateAsZendDate ){
            $this->resolutionDateAsZendDate = new \Zend_Date($this->resolutionDate, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->resolutionDateAsZendDate;
    }

    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return Assignment
     */
    public function setNote($note){
        $this->note = $note;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getIdFile(){
    	return $this->idFile;
    }
    
    /**
     * @param string $idFile
     * @return Assignment
     */
    public function setIdFile($idFile){
    	$this->idFile = $idFile;
    	return $this;
    }

    /**
     * @return float
     */
    public function getRecoveryAmount(){
    	return $this->recoveryAmount;
    }
    
    /**
     * @param float $recoveryAmount
     * @return Assignment
     */
    public function setRecoveryAmount($recoveryAmount){
    	$this->recoveryAmount = $recoveryAmount;
    	return $this;
    }

    /**
     * @return String
     */
    public function getIsRecoveredAmount(){
    	return $this->isRecoveredAmount;
    }
    
    /**
     * @param String $isRecoveredAmount
     * @return Assignment
     */
    public function setIsRecoveredAmount($isRecoveredAmount){
    	$this->isRecoveredAmount = $isRecoveredAmount;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getIdResolutionFile(){
    	return $this->idResolutionFile;
    }
    
    /**
     * @param int $idResolutionFile
     * @return Assignment
     */
    public function setIdResolutionFile($idResolutionFile){
    	$this->idResolutionFile = $idResolutionFile;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getStatus(){
    	return $this->status;
    }
    
    /**
     * @param int $status
     * @return Assignment
     */
    public function setStatus($status){
    	$this->status = $status;
    	return $this;
    }    
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_assignment' => $this->getIdAssignment(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_user' => $this->getIdUser(),
            'id_resolution' => $this->getIdResolution(),
            'assignment_date' => $this->getAssignmentDate(),
            'resolution_date' => $this->getResolutionDate(),
            'note' => $this->getNote(),
       		'id_file' => $this->getIdFile(),
        	'recovery_amount' => $this->getRecoveryAmount(),
        	'is_recovered_amount' => $this->getIsRecoveredAmount(),
        	'id_resolution_file' => $this->getIdResolutionFile(),
        	'status' => $this->getStatus(),
        );
        return $array;
    }

}