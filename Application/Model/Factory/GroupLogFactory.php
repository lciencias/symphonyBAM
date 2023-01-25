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

use Application\Model\Bean\GroupLog;

/**
 *
 * GroupLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class GroupLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\GroupLog
     */
    public static function createFromArray($fields)
    {
        $groupLog = new GroupLog();
        self::populate($groupLog, $fields);

        return $groupLog;
    }

    /**
     *
     * @static
     * @param GroupLog groupLog
     * @param array $fields
     */
    public static function populate($groupLog, $fields)
    {
        if( !($groupLog instanceof GroupLog) ){
            static::throwException("El objecto no es un GroupLog");
        }

        if( isset($fields['id_group_log']) ){
            $groupLog->setIdGroupLog($fields['id_group_log']);
        }

        if( isset($fields['id_group']) ){
            $groupLog->setIdGroup($fields['id_group']);
        }

        if( isset($fields['id_user']) ){
            $groupLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $groupLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $groupLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $groupLog->setNote($fields['note']);
        }
    }

    /**
     * @throws GroupLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\GroupLogException($message);
    }

}