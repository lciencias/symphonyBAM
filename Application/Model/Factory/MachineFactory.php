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

use Application\Model\Bean\Machine;

/**
 *
 * MachineFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class MachineFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Machine
     */
    public static function createFromArray($fields)
    {
        $machine = new Machine();
        self::populate($machine, $fields);

        return $machine;
    }

    /**
     *
     * @static
     * @param Machine machine
     * @param array $fields
     */
    public static function populate($machine, $fields)
    {
        if( !($machine instanceof Machine) ){
            static::throwException("El objecto no es un Machine");
        }

        if( isset($fields['id_machine_transition']) ){
            $machine->setIdMachineTransition($fields['id_machine_transition']);
        }

        if( isset($fields['id_element']) ){
            $machine->setIdElement($fields['id_element']);
        }

        if( isset($fields['id_automata_condition']) ){
            $machine->setIdAutomataCondition($fields['id_automata_condition']);
        }

        if( isset($fields['id_automata_state']) ){
            $machine->setIdAutomataState($fields['id_automata_state']);
        }

        if( isset($fields['next_state']) ){
            $machine->setNextState($fields['next_state']);
        }
    }

    /**
     * @throws MachineException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\MachineException($message);
    }

}