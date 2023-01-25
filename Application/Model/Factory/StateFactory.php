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

use Application\Model\Bean\State;

/**
 *
 * StateFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class StateFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\State
     */
    public static function createFromArray($fields)
    {
        $state = new State();
        self::populate($state, $fields);

        return $state;
    }

    /**
     *
     * @static
     * @param State state
     * @param array $fields
     */
    public static function populate($state, $fields)
    {
        if( !($state instanceof State) ){
            static::throwException("El objecto no es un State");
        }

        if( isset($fields['id_automata_state']) ){
            $state->setIdAutomataState($fields['id_automata_state']);
        }

        if( isset($fields['id_element']) ){
            $state->setIdElement($fields['id_element']);
        }

        if( isset($fields['id_state_type']) ){
            $state->setIdStateType($fields['id_state_type']);
        }

        if( isset($fields['name']) ){
            $state->setName($fields['name']);
        }
    }

    /**
     * @throws StateException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\StateException($message);
    }

}