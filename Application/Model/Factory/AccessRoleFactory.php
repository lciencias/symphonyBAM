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

use Application\Model\Bean\AccessRole;

/**
 *
 * AccessRoleFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class AccessRoleFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\AccessRole
     */
    public static function createFromArray($fields)
    {
        $accessRole = new AccessRole();
        self::populate($accessRole, $fields);

        return $accessRole;
    }

    /**
     *
     * @static
     * @param AccessRole accessRole
     * @param array $fields
     */
    public static function populate($accessRole, $fields)
    {
        if( !($accessRole instanceof AccessRole) ){
            static::throwException("El objecto no es un AccessRole");
        }

        if( isset($fields['id_access_role']) ){
            $accessRole->setIdAccessRole($fields['id_access_role']);
        }

        if( isset($fields['name']) ){
            $accessRole->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $accessRole->setStatus($fields['status']);
        }
    }

    /**
     * @throws AccessRoleException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AccessRoleException($message);
    }

}