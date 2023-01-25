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

use Application\Model\Bean\ServiceLevelLog;

/**
 *
 * ServiceLevelLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ServiceLevelLog current()
 * @method \Application\Model\Bean\ServiceLevelLog read()
 * @method \Application\Model\Bean\ServiceLevelLog getOne()
 * @method \Application\Model\Bean\ServiceLevelLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ServiceLevelLogCollection intersect() intersect(\Application\Model\Collection\ServiceLevelLogCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ServiceLevelLogCollection merge() merge(\Application\Model\Collection\ServiceLevelLogCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelLogCollection diff() diff(\Application\Model\Collection\ServiceLevelLogCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelLogCollection copy()
 */
class ServiceLevelLogCollection extends Collection{

    /**
     *
     * @param ServiceLevelLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ServiceLevelLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ServiceLevelLog");
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