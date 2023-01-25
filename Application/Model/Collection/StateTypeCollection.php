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

use Application\Model\Bean\StateType;

/**
 *
 * StateTypeCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\StateType current()
 * @method \Application\Model\Bean\StateType read()
 * @method \Application\Model\Bean\StateType getOne()
 * @method \Application\Model\Bean\StateType getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\StateTypeCollection intersect() intersect(\Application\Model\Collection\StateTypeCollection $collection)
 * @method \Application\Model\Collection\StateTypeCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\StateTypeCollection merge() merge(\Application\Model\Collection\StateTypeCollection $collection)
 * @method \Application\Model\Collection\StateTypeCollection diff() diff(\Application\Model\Collection\StateTypeCollection $collection)
 * @method \Application\Model\Collection\StateTypeCollection copy()
 */
class StateTypeCollection extends Collection{

    /**
     *
     * @param StateType $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof StateType) ){
            throw new \InvalidArgumentException("Debe de ser un objecto StateType");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(StateType $stateType){
            return array( $stateType->getIdStateType() => $stateType->getName() );
        });
    }

}