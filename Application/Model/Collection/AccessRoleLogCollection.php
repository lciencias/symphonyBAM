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

use Application\Model\Bean\AccessRoleLog;

/**
 *
 * AccessRoleLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AccessRoleLog current()
 * @method \Application\Model\Bean\AccessRoleLog read()
 * @method \Application\Model\Bean\AccessRoleLog getOne()
 * @method \Application\Model\Bean\AccessRoleLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AccessRoleLogCollection intersect() intersect(\Application\Model\Collection\AccessRoleLogCollection $collection)
 * @method \Application\Model\Collection\AccessRoleLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AccessRoleLogCollection merge() merge(\Application\Model\Collection\AccessRoleLogCollection $collection)
 * @method \Application\Model\Collection\AccessRoleLogCollection diff() diff(\Application\Model\Collection\AccessRoleLogCollection $collection)
 * @method \Application\Model\Collection\AccessRoleLogCollection copy()
 */
class AccessRoleLogCollection extends Collection{

    /**
     *
     * @param AccessRoleLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof AccessRoleLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto AccessRoleLog");
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