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

use Application\Model\Bean\SecurityController;

/**
 *
 * SecurityControllerFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class SecurityControllerFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\SecurityController
     */
    public static function createFromArray($fields)
    {
        $securityController = new SecurityController();
        self::populate($securityController, $fields);

        return $securityController;
    }

    /**
     *
     * @static
     * @param SecurityController securityController
     * @param array $fields
     */
    public static function populate($securityController, $fields)
    {
        if( !($securityController instanceof SecurityController) ){
            static::throwException("El objecto no es un SecurityController");
        }

        if( isset($fields['id_controller']) ){
            $securityController->setIdController($fields['id_controller']);
        }

        if( isset($fields['name']) ){
            $securityController->setName($fields['name']);
        }
    }

    /**
     * @throws SecurityControllerException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\SecurityControllerException($message);
    }

}