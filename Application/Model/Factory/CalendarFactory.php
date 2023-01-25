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

namespace Application\Model\Factory;

use Application\Model\Bean\Calendar;

/**
 *
 * CalendarFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CalendarFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Calendar
     */
    public static function createFromArray($fields)
    {
        $calendar = new Calendar();
        self::populate($calendar, $fields);

        return $calendar;
    }

    /**
     *
     * @static
     * @param Calendar calendar
     * @param array $fields
     */
    public static function populate($calendar, $fields)
    {
        if( !($calendar instanceof Calendar) ){
            static::throwException("El objecto no es un Calendar");
        }

        if( isset($fields['id_calendar']) ){
            $calendar->setIdCalendar($fields['id_calendar']);
        }

        if( isset($fields['date']) ){
            $calendar->setDate($fields['date']);
        }

        if( isset($fields['is_weekend']) ){
            $calendar->setIsWeekend($fields['is_weekend']);
        }

        if( isset($fields['is_holiday']) ){
            $calendar->setIsHoliday($fields['is_holiday']);
        }

        if( isset($fields['name_holiday']) ){
            $calendar->setNameHoliday($fields['name_holiday']);
        }
        
        if( isset($fields['day_number']) ){
        	$calendar->setDayNumber($fields['day_number']);
        }
        
    }

    /**
     * @throws CalendarException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CalendarException($message);
    }

}