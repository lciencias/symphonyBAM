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

use Automatic\Condition as ConditionInterface;

/**
 *
 * Condition
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Condition extends AbstractBean implements ConditionInterface{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_automata_automata_conditions';

    /**
     * Constants Fields
     */
    const ID_AUTOMATA_CONDITION = 'id_automata_condition';
    const ID_ELEMENT = 'id_element';
    const NAME = 'name';

    // constants conditions
    //const PENDING = 0;
    const READ = 1;
    const CANCEL = 2;
    const ASSIGN = 3;
    const WORK = 4;
    const RESOLVE = 5;
    const CLOSE = 6;
    const OPEN = 7;

    /**
     * @var int
     */
    private $idAutomataCondition;


    /**
     * @var int
     */
    private $idElement;


    /**
     * @var string
     */
    private $name;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAutomataCondition();
    }

    /**
     *
     * @return number
     */
    public function getKey(){
        return $this->getIdAutomataCondition();
    }

    /**
     * @return int
     */
    public function getIdAutomataCondition(){
        return $this->idAutomataCondition;
    }

    /**
     * @param int $idAutomataCondition
     * @return Condition
     */
    public function setIdAutomataCondition($idAutomataCondition){
        $this->idAutomataCondition = $idAutomataCondition;
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
     * @return Condition
     */
    public function setIdElement($idElement){
        $this->idElement = $idElement;
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
     * @return Condition
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
            'id_automata_condition' => $this->getIdAutomataCondition(),
            'id_element' => $this->getIdElement(),
            'name' => $this->getName(),
        );
        return $array;
    }

}