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

use Application\Model\Bean\Group;

/**
 *
 * GroupCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Group current()
 * @method \Application\Model\Bean\Group read()
 * @method \Application\Model\Bean\Group getOne()
 * @method \Application\Model\Bean\Group getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\GroupCollection intersect() intersect(\Application\Model\Collection\GroupCollection $collection)
 * @method \Application\Model\Collection\GroupCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\GroupCollection merge() merge(\Application\Model\Collection\GroupCollection $collection)
 * @method \Application\Model\Collection\GroupCollection diff() diff(\Application\Model\Collection\GroupCollection $collection)
 * @method \Application\Model\Collection\GroupCollection copy()
 */
class GroupCollection extends Collection{

    /**
     *
     * @param Group $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Group) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Group");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if($header)
    		$array[''] = $header; 
        $array += $this->map(function(Group $group){
            return array( $group->getIdGroup() => $group->getName() );
        });
        return $array;
    }

}