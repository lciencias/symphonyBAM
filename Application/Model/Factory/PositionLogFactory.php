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

use Application\Model\Bean\PositionLog;

/**
 *
 * PositionLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PositionLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\PositionLog
     */
    public static function createFromArray($fields)
    {
        $positionLog = new PositionLog();
        self::populate($positionLog, $fields);

        return $positionLog;
    }

    /**
     *
     * @static
     * @param PositionLog positionLog
     * @param array $fields
     */
    public static function populate($positionLog, $fields)
    {
        if( !($positionLog instanceof PositionLog) ){
            static::throwException("El objecto no es un PositionLog");
        }

        if( isset($fields['id_position_log']) ){
            $positionLog->setIdPositionLog($fields['id_position_log']);
        }

        if( isset($fields['id_user']) ){
            $positionLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_position']) ){
            $positionLog->setIdPosition($fields['id_position']);
        }

        if( isset($fields['date_log']) ){
            $positionLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $positionLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $positionLog->setNote($fields['note']);
        }
    }

    /**
     * @throws PositionLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PositionLogException($message);
    }

}