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

use Automatic\State as StateInterface;

/**
 *
 * State
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class State extends AbstractBean implements StateInterface{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_automata_automata_states';

    /**
     * Constants Fields
     */
    const ID_AUTOMATA_STATE = 'id_automata_state';
    const ID_ELEMENT = 'id_element';
    const ID_STATE_TYPE = 'id_state_type';
    const NAME = 'name';

    /**
     * @var int
     */
    private $idAutomataState;


    /**
     * @var int
     */
    private $idElement;


    /**
     * @var int
     */
    private $idStateType;


    /**
     * @var string
     */
    private $name;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAutomataState();
    }

    /**
     * (non-PHPdoc)
     * @see Automatic.State::getKey()
     */
    public function getKey(){
        return $this->getIdAutomataState();
    }

    /**
     * @return int
     */
    public function getIdAutomataState(){
        return $this->idAutomataState;
    }

    /**
     * @param int $idAutomataState
     * @return State
     */
    public function setIdAutomataState($idAutomataState){
        $this->idAutomataState = $idAutomataState;
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
     * @return State
     */
    public function setIdElement($idElement){
        $this->idElement = $idElement;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdStateType(){
        return $this->idStateType;
    }

    /**
     * @param int $idStateType
     * @return State
     */
    public function setIdStateType($idStateType){
        $this->idStateType = $idStateType;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return State
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_automata_state' => $this->getIdAutomataState(),
            'id_element' => $this->getIdElement(),
            'id_state_type' => $this->getIdStateType(),
            'name' => $this->getName(),
        );
        return $array;
    }

}