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

use Application\Model\Bean\User;

/**
 *
 * UserCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\User current()
 * @method \Application\Model\Bean\User read()
 * @method \Application\Model\Bean\User getOne()
 * @method \Application\Model\Bean\User getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\UserCollection intersect() intersect(\Application\Model\Collection\UserCollection $collection)
 * @method \Application\Model\Collection\UserCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\UserCollection merge() merge(\Application\Model\Collection\UserCollection $collection)
 * @method \Application\Model\Collection\UserCollection diff() diff(\Application\Model\Collection\UserCollection $collection)
 * @method \Application\Model\Collection\UserCollection copy()
 */
class UserCollection extends EmployeeCollection{

    /**
     *
     * @param User $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof User) ){
            throw new \InvalidArgumentException("Debe de ser un objecto User");
        }
    }

    /**
     * @return array
     * @param string $header
     */
    public function toCombo($header = null){
    	$array = $header ? array('' => $header) : array();
        $array += $this->map(function(User $user){
            return array( $user->getIdUser() => $user->getFullName() );
        });
        return $array;
    }
    
    /**
     * 
     * @param array $userIds
     * @return \Application\Model\Collection\UserCollection
     */
	public function filterByUserIds($userIds){
		$userIds = (array)$userIds;
		return $this->filter(function(User $user) use ($userIds){
			if (in_array($user->getIdUser(), $userIds))
				return $user;
		});
	}
    /**
     * @return array
     */
    public function fullName(){
        return $this->toCombo();
    }

}