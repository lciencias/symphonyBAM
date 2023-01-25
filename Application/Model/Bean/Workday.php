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
 * Workday
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Workday extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_workdays';

    /**
     * Constants Fields
     */
    const ID_WORKDAY = 'id_workday';
    const ID_WORKWEEK = 'id_workweek';
    const DAY_OF_WEEK = 'day_of_week';
    const START_TIME = 'start_time';
    const LUNCH_START_TIME = 'lunch_start_time';
    const LUNCH_END_TIME = 'lunch_end_time';
    const END_TIME = 'end_time';

    /**
     * @var int
     */
    private $idWorkday;


    /**
     * @var int
     */
    private $idWorkweek;


    /**
     * @var int
     */
    private $dayOfWeek;


    /**
     * @var string
     */
    private $startTime;


    /**
     * @var string
     */
    private $lunchStartTime;


    /**
     * @var string
     */
    private $lunchEndTime;


    /**
     * @var string
     */
    private $endTime;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdWorkday();
    }


    /**
     * @return int
     */
    public function getIdWorkday(){
        return $this->idWorkday;
    }

    /**
     * @param int $idWorkday
     * @return Workday
     */
    public function setIdWorkday($idWorkday){
        $this->idWorkday = $idWorkday;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdWorkweek(){
        return $this->idWorkweek;
    }

    /**
     * @param int $idWorkweek
     * @return Workday
     */
    public function setIdWorkweek($idWorkweek){
        $this->idWorkweek = $idWorkweek;
        return $this;
    }


    /**
     * @return int
     */
    public function getDayOfWeek(){
        return $this->dayOfWeek;
    }

    /**
     * @param int $dayOfWeek
     * @return Workday
     */
    public function setDayOfWeek($dayOfWeek){
        $this->dayOfWeek = $dayOfWeek;
        return $this;
    }


    /**
     * @return string
     */
    public function getStartTime(){
    	return self::format($this->startTime);
        //return $this->startTime;
    }

    /**
     * @param string $startTime
     * @return Workday
     */
    public function setStartTime($startTime){
        $this->startTime = $startTime;
        return $this;
    }


    /**
     * @return string
     */
    public function getLunchStartTime(){
        //return $this->lunchStartTime;
        return self::format($this->lunchStartTime);
    }

    /**
     * @param string $lunchStartTime
     * @return Workday
     */
    public function setLunchStartTime($lunchStartTime){
        $this->lunchStartTime = $lunchStartTime;
        return $this;
    }


    /**
     * @return string
     */
    public function getLunchEndTime(){
//        return $this->lunchEndTime;
        return self::format($this->lunchEndTime);
    }

    /**
     * @param string $lunchEndTime
     * @return Workday
     */
    public function setLunchEndTime($lunchEndTime){
        $this->lunchEndTime = $lunchEndTime;
        return $this;
    }


    /**
     * @return string
     */
    public function getEndTime(){
        //return $this->endTime;
        return self::format($this->endTime);
    }

    /**
     * @param string $endTime
     * @return Workday
     */
    public function setEndTime($endTime){
        $this->endTime = $endTime;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_workday' => $this->getIdWorkday(),
            'id_workweek' => $this->getIdWorkweek(),
            'day_of_week' => $this->getDayOfWeek(),
            'start_time' => $this->getStartTime(),
            'lunch_start_time' => $this->getLunchStartTime(),
            'lunch_end_time' => $this->getLunchEndTime(),
            'end_time' => $this->getEndTime(),
        );

        if( empty($array['lunch_start_time']) ){
            $array['lunch_start_time'] = null;
        }

        if( empty($array['lunch_end_time']) ){
            $array['lunch_end_time'] = null;
        }

        return $array;
    }

    /**
     * Dias
     * @staticvar array
     */
    public static $Days = array(
        'Sunday' => 1,
        'Monday' => 2,
        'Tuesday' => 3,
        'Wednesday' => 4,
        'Thursday' => 5,
        'Friday' => 6,
        'Saturday' => 7,
    );

}