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

use Application\Model\Bean\Priority;

/**
 *
 * PriorityCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Priority current()
 * @method \Application\Model\Bean\Priority read()
 * @method \Application\Model\Bean\Priority getOne()
 * @method \Application\Model\Bean\Priority getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PriorityCollection intersect() intersect(\Application\Model\Collection\PriorityCollection $collection)
 * @method \Application\Model\Collection\PriorityCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PriorityCollection merge() merge(\Application\Model\Collection\PriorityCollection $collection)
 * @method \Application\Model\Collection\PriorityCollection diff() diff(\Application\Model\Collection\PriorityCollection $collection)
 * @method \Application\Model\Collection\PriorityCollection copy()
 */
class PriorityCollection extends Collection{

    /**
     *
     * @param Priority $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Priority) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Priority");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Priority $priority){
            return array( $priority->getIdPriority() => $priority->getName() );
        });
    }

    /**
     *
     * @return \Application\Model\Collection\PriorityCollection
     */
    public function actives(){
        return $this->filter(function(Priority $priority){
            return $priority->isActive();
        });
    }

}