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
 * Calendar
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Calendar extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_calendar';

    /**
     * Constants Fields
     */
    const ID_CALENDAR = 'id_calendar';
    const DATE = 'date';
    const IS_WEEKEND = 'is_weekend';
    const IS_HOLIDAY = 'is_holiday';
    const NAME_HOLIDAY = 'name_holiday';
    const DAY_NUMBER = 'day_number';

    /**
     * @var int
     */
    private $idCalendar;


    /**
     * @var string
     */
    private $date;

    /**
     * @var \Zend_Date
     */
    private $dateAsZendDate;


    /**
     * @var boolean
     */
    private $isWeekend;


    /**
     * @var boolean
     */
    private $isHoliday;


    /**
     * @var string
     */
    private $nameHoliday;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdCalendar();
    }


    /**
     * @return int
     */
    public function getIdCalendar(){
        return $this->idCalendar;
    }

    /**
     * @param int $idCalendar
     * @return Calendar
     */
    public function setIdCalendar($idCalendar){
        $this->idCalendar = $idCalendar;
        return $this;
    }


    /**
     * @return string
     */
    public function getDate(){
        //return $this->date;
        return self::format($this->date);
    }

    /**
     * @param string $date
     * @return Calendar
     */
    public function setDate($date){
        $this->date = $date;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getDateAsZendDate(){
        if( null == $this->dateAsZendDate ){
            $this->dateAsZendDate = new \Zend_Date($this->date, 'yyyy-MM-dd');
        }
        return $this->dateAsZendDate;
    }


    /**
     * @return boolean
     */
    public function getIsWeekend(){
        return $this->isWeekend;
    }

    /**
     * @param boolean $isWeekend
     * @return Calendar
     */
    public function setIsWeekend($isWeekend){
        $this->isWeekend = $isWeekend;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getIsHoliday(){
        return $this->isHoliday;
    }

    /**
     * @param boolean $isHoliday
     * @return Calendar
     */
    public function setIsHoliday($isHoliday){
        $this->isHoliday = $isHoliday;
        return $this;
    }


    /**
     * @return string
     */
    public function getNameHoliday(){
        return $this->nameHoliday;
    }

    /**
     * @param string $nameHoliday
     * @return Calendar
     */
    public function setNameHoliday($nameHoliday){
        $this->nameHoliday = $nameHoliday;
        return $this;
    }
    /**
     * @return int
     */
	public function getDayNumber(){
		return $this->dayNumber;
	}

	public function setDayNumber($dayNumber){
		$this->dayNumber = $dayNumber;
		return $this;
	}
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_calendar' => $this->getIdCalendar(),
            'date' => $this->getDate(),
            'is_weekend' => $this->getIsWeekend(),
            'is_holiday' => $this->getIsHoliday(),
            'name_holiday' => $this->getNameHoliday(),
        		'day_number' => $this->getDayNumber(),
        );
        return $array;
    }

}