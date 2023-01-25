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

use Application\Model\Bean\User;

/**
 *
 * UserFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class UserFactory extends EmployeeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\User
     */
    public static function createFromArray($fields)
    {
        $user = new User();
        self::populate($user, $fields);

        return $user;
    }

    /**
     *
     * @static
     * @param User user
     * @param array $fields
     */
    public static function populate($user, $fields)
    {
        parent::populate($user, $fields);
        if( !($user instanceof User) ){
            static::throwException("El objecto no es un User");
        }

        if( isset($fields['id_user']) ){
            $user->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_access_role']) ){
            $user->setIdAccessRole($fields['id_access_role']);
        }

        if( isset($fields['id_employee']) ){
            $user->setIdEmployee($fields['id_employee']);
        }

        if( isset($fields['id_branch']) ){
            $user->setIdbranch($fields['id_branch']);
        }
        
        if( isset($fields['id_channel']) ){
        	$user->setIdChannel($fields['id_channel']);
        }
        
        if( isset($fields['username']) ){
            $user->setUsername($fields['username']);
        }

        if( isset($fields['password']) ){
            $user->setPassword($fields['password']);
        }

        if( isset($fields['status']) ){
            $user->setStatus($fields['status']);
        }
    }

    /**
     * @throws UserException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\UserException($message);
    }

}