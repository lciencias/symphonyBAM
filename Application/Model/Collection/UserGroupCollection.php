<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Collection;

use Application\Model\Bean\UserGroup;

/**
 *
 * UserGroupCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\UserGroup current()
 * @method \Application\Model\Bean\UserGroup read()
 * @method \Application\Model\Bean\UserGroup getOne()
 * @method \Application\Model\Bean\UserGroup getOneOrElse() getOneOrElse(Application\Model\Bean\UserGroup $userGroup)
 * @method \Application\Model\Bean\UserGroup getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\UserGroup getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\UserGroup $userGroup)
 * @method \Application\Model\Collection\UserGroupCollection intersect() intersect(\Application\Model\Collection\UserGroupCollection $collection)
 * @method \Application\Model\Collection\UserGroupCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\UserGroupCollection merge() merge(\Application\Model\Collection\UserGroupCollection $collection)
 * @method \Application\Model\Collection\UserGroupCollection diff() diff(\Application\Model\Collection\UserGroupCollection $collection)
 * @method \Application\Model\Collection\UserGroupCollection copy()
 */
class UserGroupCollection extends Collection{

    /**
     *
     * @param UserGroup $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof UserGroup) ){
            throw new \InvalidArgumentException("Debe de ser un objecto UserGroup");
        }
    }
}