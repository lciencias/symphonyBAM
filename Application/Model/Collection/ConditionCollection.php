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

use Application\Model\Bean\Condition;

/**
 *
 * ConditionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Condition current()
 * @method \Application\Model\Bean\Condition read()
 * @method \Application\Model\Bean\Condition getOne()
 * @method \Application\Model\Bean\Condition getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ConditionCollection intersect() intersect(\Application\Model\Collection\ConditionCollection $collection)
 * @method \Application\Model\Collection\ConditionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ConditionCollection merge() merge(\Application\Model\Collection\ConditionCollection $collection)
 * @method \Application\Model\Collection\ConditionCollection diff() diff(\Application\Model\Collection\ConditionCollection $collection)
 * @method \Application\Model\Collection\ConditionCollection copy()
 */
class ConditionCollection extends Collection{

    /**
     *
     * @param Condition $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Condition) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Condition");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Condition $condition){
            return array( $condition->getIdAutomataCondition() => $condition->getName() );
        });
    }

}