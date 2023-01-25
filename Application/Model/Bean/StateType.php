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
 * StateType
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class StateType extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_automata_state_types';

    /**
     * Constants Fields
     */
    const ID_STATE_TYPE = 'id_state_type';
    const NAME = 'name';

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
        return $this->getIdStateType();
    }


    /**
     * @return int
     */
    public function getIdStateType(){
        return $this->idStateType;
    }

    /**
     * @param int $idStateType
     * @return StateType
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
     * @return StateType
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
            'id_state_type' => $this->getIdStateType(),
            'name' => $this->getName(),
        );
        return $array;
    }

}