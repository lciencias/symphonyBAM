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

use Application\Model\Bean\ImpactLog;

/**
 *
 * ImpactLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ImpactLog current()
 * @method \Application\Model\Bean\ImpactLog read()
 * @method \Application\Model\Bean\ImpactLog getOne()
 * @method \Application\Model\Bean\ImpactLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ImpactLogCollection intersect() intersect(\Application\Model\Collection\ImpactLogCollection $collection)
 * @method \Application\Model\Collection\ImpactLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ImpactLogCollection merge() merge(\Application\Model\Collection\ImpactLogCollection $collection)
 * @method \Application\Model\Collection\ImpactLogCollection diff() diff(\Application\Model\Collection\ImpactLogCollection $collection)
 * @method \Application\Model\Collection\ImpactLogCollection copy()
 */
class ImpactLogCollection extends Collection{

    /**
     *
     * @param ImpactLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ImpactLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ImpactLog");
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