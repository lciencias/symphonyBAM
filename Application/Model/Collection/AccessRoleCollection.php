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

use Application\Model\Bean\AccessRole;

/**
 *
 * AccessRoleCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AccessRole current()
 * @method \Application\Model\Bean\AccessRole read()
 * @method \Application\Model\Bean\AccessRole getOne()
 * @method \Application\Model\Bean\AccessRole getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AccessRoleCollection intersect() intersect(\Application\Model\Collection\AccessRoleCollection $collection)
 * @method \Application\Model\Collection\AccessRoleCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AccessRoleCollection merge() merge(\Application\Model\Collection\AccessRoleCollection $collection)
 * @method \Application\Model\Collection\AccessRoleCollection diff() diff(\Application\Model\Collection\AccessRoleCollection $collection)
 * @method \Application\Model\Collection\AccessRoleCollection copy()
 */
class AccessRoleCollection extends Collection{

    /**
     *
     * @param AccessRole $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof AccessRole) ){
            throw new \InvalidArgumentException("Debe de ser un objecto AccessRole");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(AccessRole $accessRole){
            return array( $accessRole->getIdAccessRole() => $accessRole->getName() );
        });
    }

}