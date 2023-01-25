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

namespace Application\Model\Bean;

/**
 *
 * Machine
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Machine extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_automata_machines';

    /**
     * Constants Fields
     */
    const ID_MACHINE_TRANSITION = 'id_machine_transition';
    const ID_ELEMENT = 'id_element';
    const ID_AUTOMATA_CONDITION = 'id_automata_condition';
    const ID_AUTOMATA_STATE = 'id_automata_state';
    const NEXT_STATE = 'next_state';

    /**
     * @var int
     */
    private $idMachineTransition;


    /**
     * @var int
     */
    private $idElement;


    /**
     * @var int
     */
    private $idAutomataCondition;


    /**
     * @var int
     */
    private $idAutomataState;


    /**
     * @var int
     */
    private $nextState;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdMachineTransition();
    }


    /**
     * @return int
     */
    public function getIdMachineTransition(){
        return $this->idMachineTransition;
    }

    /**
     * @param int $idMachineTransition
     * @return Machine
     */
    public function setIdMachineTransition($idMachineTransition){
        $this->idMachineTransition = $idMachineTransition;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdElement(){
        return $this->idElement;
    }

    /**
     * @param int $idElement
     * @return Machine
     */
    public function setIdElement($idElement){
        $this->idElement = $idElement;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdAutomataCondition(){
        return $this->idAutomataCondition;
    }

    /**
     * @param int $idAutomataCondition
     * @return Machine
     */
    public function setIdAutomataCondition($idAutomataCondition){
        $this->idAutomataCondition = $idAutomataCondition;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdAutomataState(){
        return $this->idAutomataState;
    }

    /**
     * @param int $idAutomataState
     * @return Machine
     */
    public function setIdAutomataState($idAutomataState){
        $this->idAutomataState = $idAutomataState;
        return $this;
    }


    /**
     * @return int
     */
    public function getNextState(){
        return $this->nextState;
    }

    /**
     * @param int $nextState
     * @return Machine
     */
    public function setNextState($nextState){
        $this->nextState = $nextState;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_machine_transition' => $this->getIdMachineTransition(),
            'id_element' => $this->getIdElement(),
            'id_automata_condition' => $this->getIdAutomataCondition(),
            'id_automata_state' => $this->getIdAutomataState(),
            'next_state' => $this->getNextState(),
        );
        return $array;
    }

}