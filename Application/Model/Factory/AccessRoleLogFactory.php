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

use Application\Model\Bean\AccessRoleLog;

/**
 *
 * AccessRoleLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class AccessRoleLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\AccessRoleLog
     */
    public static function createFromArray($fields)
    {
        $accessRoleLog = new AccessRoleLog();
        self::populate($accessRoleLog, $fields);

        return $accessRoleLog;
    }

    /**
     *
     * @static
     * @param AccessRoleLog accessRoleLog
     * @param array $fields
     */
    public static function populate($accessRoleLog, $fields)
    {
        if( !($accessRoleLog instanceof AccessRoleLog) ){
            static::throwException("El objecto no es un AccessRoleLog");
        }

        if( isset($fields['id_access_role_log']) ){
            $accessRoleLog->setIdAccessRoleLog($fields['id_access_role_log']);
        }

        if( isset($fields['id_access_role']) ){
            $accessRoleLog->setIdAccessRole($fields['id_access_role']);
        }

        if( isset($fields['id_user']) ){
            $accessRoleLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $accessRoleLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $accessRoleLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $accessRoleLog->setNote($fields['note']);
        }
    }

    /**
     * @throws AccessRoleLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AccessRoleLogException($message);
    }

}