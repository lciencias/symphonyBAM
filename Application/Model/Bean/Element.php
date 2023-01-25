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
 * Element
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Element extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_automata_elements';

    /**
     * Constants Fields
     */
    const ID_ELEMENT = 'id_element';
    const NAME = 'name';

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
        return $this->getIdElement();
    }


    /**
     * @return int
     */
    public function getIdElement(){
        return $this->idElement;
    }

    /**
     * @param int $idElement
     * @return Element
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
     * @return Element
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
            'id_element' => $this->getIdElement(),
            'name' => $this->getName(),
        );
        return $array;
    }

}