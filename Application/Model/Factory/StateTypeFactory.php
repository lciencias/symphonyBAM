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

use Application\Model\Bean\StateType;

/**
 *
 * StateTypeFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class StateTypeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\StateType
     */
    public static function createFromArray($fields)
    {
        $stateType = new StateType();
        self::populate($stateType, $fields);

        return $stateType;
    }

    /**
     *
     * @static
     * @param StateType stateType
     * @param array $fields
     */
    public static function populate($stateType, $fields)
    {
        if( !($stateType instanceof StateType) ){
            static::throwException("El objecto no es un StateType");
        }

        if( isset($fields['id_state_type']) ){
            $stateType->setIdStateType($fields['id_state_type']);
        }

        if( isset($fields['name']) ){
            $stateType->setName($fields['name']);
        }
    }

    /**
     * @throws StateTypeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\StateTypeException($message);
    }

}