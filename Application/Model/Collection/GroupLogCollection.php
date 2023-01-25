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

use Application\Model\Bean\GroupLog;

/**
 *
 * GroupLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\GroupLog current()
 * @method \Application\Model\Bean\GroupLog read()
 * @method \Application\Model\Bean\GroupLog getOne()
 * @method \Application\Model\Bean\GroupLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\GroupLogCollection intersect() intersect(\Application\Model\Collection\GroupLogCollection $collection)
 * @method \Application\Model\Collection\GroupLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\GroupLogCollection merge() merge(\Application\Model\Collection\GroupLogCollection $collection)
 * @method \Application\Model\Collection\GroupLogCollection diff() diff(\Application\Model\Collection\GroupLogCollection $collection)
 * @method \Application\Model\Collection\GroupLogCollection copy()
 */
class GroupLogCollection extends Collection{

    /**
     *
     * @param GroupLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof GroupLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto GroupLog");
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