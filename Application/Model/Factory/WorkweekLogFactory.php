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

use Application\Model\Bean\WorkweekLog;

/**
 *
 * WorkweekLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class WorkweekLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\WorkweekLog
     */
    public static function createFromArray($fields)
    {
        $workweekLog = new WorkweekLog();
        self::populate($workweekLog, $fields);

        return $workweekLog;
    }

    /**
     *
     * @static
     * @param WorkweekLog workweekLog
     * @param array $fields
     */
    public static function populate($workweekLog, $fields)
    {
        if( !($workweekLog instanceof WorkweekLog) ){
            static::throwException("El objecto no es un WorkweekLog");
        }

        if( isset($fields['id_workweek_log']) ){
            $workweekLog->setIdWorkweekLog($fields['id_workweek_log']);
        }

        if( isset($fields['id_workweek']) ){
            $workweekLog->setIdWorkweek($fields['id_workweek']);
        }

        if( isset($fields['id_user']) ){
            $workweekLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $workweekLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $workweekLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $workweekLog->setNote($fields['note']);
        }
    }

    /**
     * @throws WorkweekLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\WorkweekLogException($message);
    }

}