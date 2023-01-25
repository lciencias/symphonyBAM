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

use Application\Model\Bean\PriorityLog;

/**
 *
 * PriorityLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PriorityLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\PriorityLog
     */
    public static function createFromArray($fields)
    {
        $priorityLog = new PriorityLog();
        self::populate($priorityLog, $fields);

        return $priorityLog;
    }

    /**
     *
     * @static
     * @param PriorityLog priorityLog
     * @param array $fields
     */
    public static function populate($priorityLog, $fields)
    {
        if( !($priorityLog instanceof PriorityLog) ){
            static::throwException("El objecto no es un PriorityLog");
        }

        if( isset($fields['id_priority_log']) ){
            $priorityLog->setIdPriorityLog($fields['id_priority_log']);
        }

        if( isset($fields['id_priority']) ){
            $priorityLog->setIdPriority($fields['id_priority']);
        }

        if( isset($fields['id_user']) ){
            $priorityLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $priorityLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
        	$priorityLog->setIdEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $priorityLog->setNote($fields['note']);
        }
    }

    /**
     * @throws PriorityLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PriorityLogException($message);
    }

}