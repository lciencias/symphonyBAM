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

use Application\Model\Bean\SecurityAction;

/**
 *
 * SecurityActionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class SecurityActionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\SecurityAction
     */
    public static function createFromArray($fields)
    {
        $securityAction = new SecurityAction();
        self::populate($securityAction, $fields);

        return $securityAction;
    }

    /**
     *
     * @static
     * @param SecurityAction securityAction
     * @param array $fields
     */
    public static function populate($securityAction, $fields)
    {
        if( !($securityAction instanceof SecurityAction) ){
            static::throwException("El objecto no es un SecurityAction");
        }

        if( isset($fields['id_action']) ){
            $securityAction->setIdAction($fields['id_action']);
        }

        if( isset($fields['id_controller']) ){
            $securityAction->setIdController($fields['id_controller']);
        }

        if( isset($fields['name']) ){
            $securityAction->setName($fields['name']);
        }

        if( isset($fields['tag_module']) ){
            $securityAction->setTagModule($fields['tag_module']);
        }

        if( isset($fields['tag_action']) ){
            $securityAction->setTagAction($fields['tag_action']);
        }
    }

    /**
     * @throws SecurityActionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\SecurityActionException($message);
    }

}