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

use Application\Model\Bean\UserLog;

/**
 *
 * UserLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class UserLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\UserLog
     */
    public static function createFromArray($fields)
    {
        $userLog = new UserLog();
        self::populate($userLog, $fields);

        return $userLog;
    }

    /**
     *
     * @static
     * @param UserLog userLog
     * @param array $fields
     */
    public static function populate($userLog, $fields)
    {
        if( !($userLog instanceof UserLog) ){
            static::throwException("El objecto no es un UserLog");
        }

        if( isset($fields['id_user_log']) ){
            $userLog->setIdUserLog($fields['id_user_log']);
        }

        if( isset($fields['id_user']) ){
            $userLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['event_type']) ){
            $userLog->setEventType($fields['event_type']);
        }

        if( isset($fields['ip']) ){
            $userLog->setIp($fields['ip']);
        }

        if( isset($fields['id_responsible']) ){
            $userLog->setIdResponsible($fields['id_responsible']);
        }

        if( isset($fields['timestamp']) ){
            $userLog->setTimestamp($fields['timestamp']);
        }

        if( isset($fields['note']) ){
            $userLog->setNote($fields['note']);
        }
    }

    /**
     * @throws UserLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\UserLogException($message);
    }

}