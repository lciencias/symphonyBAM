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

use Application\Model\Bean\WorkweekLog;

/**
 *
 * WorkweekLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\WorkweekLog current()
 * @method \Application\Model\Bean\WorkweekLog read()
 * @method \Application\Model\Bean\WorkweekLog getOne()
 * @method \Application\Model\Bean\WorkweekLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\WorkweekLogCollection intersect() intersect(\Application\Model\Collection\WorkweekLogCollection $collection)
 * @method \Application\Model\Collection\WorkweekLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\WorkweekLogCollection merge() merge(\Application\Model\Collection\WorkweekLogCollection $collection)
 * @method \Application\Model\Collection\WorkweekLogCollection diff() diff(\Application\Model\Collection\WorkweekLogCollection $collection)
 * @method \Application\Model\Collection\WorkweekLogCollection copy()
 */
class WorkweekLogCollection extends Collection{

    /**
     *
     * @param WorkweekLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof WorkweekLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto WorkweekLog");
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