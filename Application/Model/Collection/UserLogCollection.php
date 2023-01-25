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

use Application\Model\Bean\UserLog;

/**
 *
 * UserLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\UserLog current()
 * @method \Application\Model\Bean\UserLog read()
 * @method \Application\Model\Bean\UserLog getOne()
 * @method \Application\Model\Bean\UserLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\UserLogCollection intersect() intersect(\Application\Model\Collection\UserLogCollection $collection)
 * @method \Application\Model\Collection\UserLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\UserLogCollection merge() merge(\Application\Model\Collection\UserLogCollection $collection)
 * @method \Application\Model\Collection\UserLogCollection diff() diff(\Application\Model\Collection\UserLogCollection $collection)
 * @method \Application\Model\Collection\UserLogCollection copy()
 */
class UserLogCollection extends Collection{

    /**
     *
     * @param UserLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof UserLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto UserLog");
        }
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function(UserLog $log){
            return array($log->getIdUser() => $log->getIdUser());
        });
    }

    /**
     * @return array
     */
    public function getUserResponsibleIds(){
        return $this->map(function(UserLog $log){
            return array($log->getIdResponsible() => $log->getIdResponsible());
        });
    }

}