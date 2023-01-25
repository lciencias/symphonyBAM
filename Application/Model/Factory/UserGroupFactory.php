<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Factory;

use Application\Model\Bean\UserGroup;

/**
 *
 * UserGroupFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class UserGroupFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\UserGroup
     */
    public static function createFromArray($fields)
    {
        $userGroup = new UserGroup();
        self::populate($userGroup, $fields);

        return $userGroup;
    }

    /**
     *
     * @static
     * @param UserGroup userGroup
     * @param array $fields
     */
    public static function populate($userGroup, $fields)
    {
        if( !($userGroup instanceof UserGroup) ){
            static::throwException("El objecto no es un UserGroup");
        }

        if( isset($fields['id_user']) ){
            $userGroup->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_group']) ){
            $userGroup->setIdGroup($fields['id_group']);
        }
    }

    /**
     * @throws UserGroupException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\UserGroupException($message);
    }

}