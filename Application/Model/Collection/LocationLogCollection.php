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

use Application\Model\Bean\LocationLog;

/**
 *
 * LocationLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\LocationLog current()
 * @method \Application\Model\Bean\LocationLog read()
 * @method \Application\Model\Bean\LocationLog getOne()
 * @method \Application\Model\Bean\LocationLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\LocationLogCollection intersect() intersect(\Application\Model\Collection\LocationLogCollection $collection)
 * @method \Application\Model\Collection\LocationLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\LocationLogCollection merge() merge(\Application\Model\Collection\LocationLogCollection $collection)
 * @method \Application\Model\Collection\LocationLogCollection diff() diff(\Application\Model\Collection\LocationLogCollection $collection)
 * @method \Application\Model\Collection\LocationLogCollection copy()
 */
class LocationLogCollection extends Collection{

    /**
     *
     * @param LocationLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof LocationLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto LocationLog");
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