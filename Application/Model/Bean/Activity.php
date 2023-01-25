<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

use PHPeriod\Period;

/**
 *
 * Activity
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Activity extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_activities';

    /**
     * Constants Fields
     */
    const ID_ACTIVITY = 'id_activity';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_USER = 'id_user';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idActivity;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var string
     */
    private $startDate;

    /**
     * @var \Zend_Date
     */
    private $startDateAsZendDate;


    /**
     * @var string
     */
    private $endDate;

    /**
     * @var \Zend_Date
     */
    private $endDateAsZendDate;


    /**
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdActivity();
    }


    /**
     * @return int
     */
    public function getIdActivity(){
        return $this->idActivity;
    }

    /**
     * @param int $idActivity
     * @return Activity
     */
    public function setIdActivity($idActivity){
        $this->idActivity = $idActivity;
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
     * @return Activity
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
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
     * @return Activity
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
        return $this;
    }


    /**
     * @return string
     */
    public function getStartDate(){
        //return $this->startDate;
        return self::format($this->startDate);
    }

    /**
     * @param string $startDate
     * @return Activity
     */
    public function setStartDate($startDate){
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getStartDateAsZendDate(){
        if( null == $this->startDateAsZendDate ){
            $this->startDateAsZendDate = new \Zend_Date($this->startDate, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->startDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getEndDate(){
	    //return $this->endDate;
        return self::format($this->endDate);
    }

    /**
     * @param string $endDate
     * @return Activity
     */
    public function setEndDate($endDate){
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getEndDateAsZendDate(){
        if( null == $this->endDateAsZendDate ){
            $this->endDateAsZendDate = new \Zend_Date($this->endDate, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->endDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return Activity
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
            'id_activity' => $this->getIdActivity(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_user' => $this->getIdUser(),
            'start_date' => $this->getStartDate(),
            'end_date' => $this->getEndDate(),
            'note' => $this->getNote(),
        );
        return $array;
    }

    /**
     *
     * @return \PHPeriod\Duration
     */
    public function getDuration(){
        $period  = new Period($this->getStartDate(), $this->getEndDate());
        return $period->getDuration();
    }

}