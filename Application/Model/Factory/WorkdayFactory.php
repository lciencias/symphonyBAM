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

use Application\Model\Bean\Workday;

/**
 *
 * WorkdayFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class WorkdayFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Workday
     */
    public static function createFromArray($fields)
    {
        $workday = new Workday();
        self::populate($workday, $fields);

        return $workday;
    }

    /**
     *
     * @static
     * @param Workday workday
     * @param array $fields
     */
    public static function populate($workday, $fields)
    {
        if( !($workday instanceof Workday) ){
            static::throwException("El objecto no es un Workday");
        }

        if( isset($fields['id_workday']) ){
            $workday->setIdWorkday($fields['id_workday']);
        }

        if( isset($fields['id_workweek']) ){
            $workday->setIdWorkweek($fields['id_workweek']);
        }

        if( isset($fields['day_of_week']) ){
            $workday->setDayOfWeek($fields['day_of_week']);
        }

        if( isset($fields['start_time']) ){
            $workday->setStartTime($fields['start_time']);
        }

        if( isset($fields['lunch_start_time']) ){
            $workday->setLunchStartTime($fields['lunch_start_time']);
        }

        if( isset($fields['lunch_end_time']) ){
            $workday->setLunchEndTime($fields['lunch_end_time']);
        }

        if( isset($fields['end_time']) ){
            $workday->setEndTime($fields['end_time']);
        }
    }

    /**
     * @throws WorkdayException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\WorkdayException($message);
    }

}