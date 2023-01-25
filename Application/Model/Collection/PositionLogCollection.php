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

use Application\Model\Bean\PositionLog;

/**
 *
 * PositionLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PositionLog current()
 * @method \Application\Model\Bean\PositionLog read()
 * @method \Application\Model\Bean\PositionLog getOne()
 * @method \Application\Model\Bean\PositionLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PositionLogCollection intersect() intersect(\Application\Model\Collection\PositionLogCollection $collection)
 * @method \Application\Model\Collection\PositionLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PositionLogCollection merge() merge(\Application\Model\Collection\PositionLogCollection $collection)
 * @method \Application\Model\Collection\PositionLogCollection diff() diff(\Application\Model\Collection\PositionLogCollection $collection)
 * @method \Application\Model\Collection\PositionLogCollection copy()
 */
class PositionLogCollection extends Collection{

    /**
     *
     * @param PositionLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof PositionLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto PositionLog");
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