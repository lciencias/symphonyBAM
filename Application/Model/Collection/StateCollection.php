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

use Application\Model\Bean\State;

/**
 *
 * StateCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\State current()
 * @method \Application\Model\Bean\State read()
 * @method \Application\Model\Bean\State getOne()
 * @method \Application\Model\Bean\State getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\StateCollection intersect() intersect(\Application\Model\Collection\StateCollection $collection)
 * @method \Application\Model\Collection\StateCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\StateCollection merge() merge(\Application\Model\Collection\StateCollection $collection)
 * @method \Application\Model\Collection\StateCollection diff() diff(\Application\Model\Collection\StateCollection $collection)
 * @method \Application\Model\Collection\StateCollection copy()
 */
class StateCollection extends Collection{

    /**
     *
     * @param State $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof State) ){
            throw new \InvalidArgumentException("Debe de ser un objecto State");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(State $state){
            return array( $state->getIdAutomataState() => $state->getName() );
        });
    }

}