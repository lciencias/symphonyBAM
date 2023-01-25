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

namespace Application\Model\Collection;

use Application\Model\Bean\Element;

/**
 *
 * ElementCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Element current()
 * @method \Application\Model\Bean\Element read()
 * @method \Application\Model\Bean\Element getOne()
 * @method \Application\Model\Bean\Element getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ElementCollection intersect() intersect(\Application\Model\Collection\ElementCollection $collection)
 * @method \Application\Model\Collection\ElementCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ElementCollection merge() merge(\Application\Model\Collection\ElementCollection $collection)
 * @method \Application\Model\Collection\ElementCollection diff() diff(\Application\Model\Collection\ElementCollection $collection)
 * @method \Application\Model\Collection\ElementCollection copy()
 */
class ElementCollection extends Collection{

    /**
     *
     * @param Element $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Element) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Element");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Element $element){
            return array( $element->getIdElement() => $element->getName() );
        });
    }

}