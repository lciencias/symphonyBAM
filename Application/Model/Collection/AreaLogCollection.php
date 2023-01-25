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

use Application\Model\Bean\AreaLog;

/**
 *
 * AreaLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AreaLog current()
 * @method \Application\Model\Bean\AreaLog read()
 * @method \Application\Model\Bean\AreaLog getOne()
 * @method \Application\Model\Bean\AreaLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AreaLogCollection intersect() intersect(\Application\Model\Collection\AreaLogCollection $collection)
 * @method \Application\Model\Collection\AreaLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AreaLogCollection merge() merge(\Application\Model\Collection\AreaLogCollection $collection)
 * @method \Application\Model\Collection\AreaLogCollection diff() diff(\Application\Model\Collection\AreaLogCollection $collection)
 * @method \Application\Model\Collection\AreaLogCollection copy()
 */
class AreaLogCollection extends Collection{

    /**
     *
     * @param AreaLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof AreaLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto AreaLog");
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