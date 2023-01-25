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

use Application\Model\Bean\PriorityLog;

/**
 *
 * PriorityLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PriorityLog current()
 * @method \Application\Model\Bean\PriorityLog read()
 * @method \Application\Model\Bean\PriorityLog getOne()
 * @method \Application\Model\Bean\PriorityLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PriorityLogCollection intersect() intersect(\Application\Model\Collection\PriorityLogCollection $collection)
 * @method \Application\Model\Collection\PriorityLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PriorityLogCollection merge() merge(\Application\Model\Collection\PriorityLogCollection $collection)
 * @method \Application\Model\Collection\PriorityLogCollection diff() diff(\Application\Model\Collection\PriorityLogCollection $collection)
 * @method \Application\Model\Collection\PriorityLogCollection copy()
 */
class PriorityLogCollection extends Collection{

    /**
     *
     * @param PriorityLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof PriorityLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto PriorityLog");
        }
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function($log){
            return array($log->getIdUser() => $log->getIdUser());
        });
    }

}