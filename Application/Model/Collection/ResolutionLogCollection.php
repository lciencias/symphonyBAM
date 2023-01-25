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

use Application\Model\Bean\ResolutionLog;

/**
 *
 * ResolutionLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ResolutionLog current()
 * @method \Application\Model\Bean\ResolutionLog read()
 * @method \Application\Model\Bean\ResolutionLog getOne()
 * @method \Application\Model\Bean\ResolutionLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ResolutionLogCollection intersect() intersect(\Application\Model\Collection\ResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ResolutionLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ResolutionLogCollection merge() merge(\Application\Model\Collection\ResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ResolutionLogCollection diff() diff(\Application\Model\Collection\ResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ResolutionLogCollection copy()
 */
class ResolutionLogCollection extends Collection{

    /**
     *
     * @param ResolutionLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ResolutionLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ResolutionLog");
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