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

namespace Application\Model\Factory;

use Application\Model\Bean\Group;

/**
 *
 * GroupFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class GroupFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Group
     */
    public static function createFromArray($fields)
    {
        $group = new Group();
        self::populate($group, $fields);

        return $group;
    }

    /**
     *
     * @static
     * @param Group group
     * @param array $fields
     */
    public static function populate($group, $fields)
    {
        if( !($group instanceof Group) ){
            static::throwException("El objecto no es un Group");
        }

        if( isset($fields['id_group']) ){
            $group->setIdGroup($fields['id_group']);
        }

        if( isset($fields['id_user']) ){
            $group->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_workweek']) ){
            $group->setIdWorkweek($fields['id_workweek']);
        }

        if( isset($fields['name']) ){
            $group->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $group->setStatus($fields['status']);
        }
        
        if( isset($fields['id_user_assigned_for_tickets']) ){
        	$group->setIdUserAssignedForTickets($fields['id_user_assigned_for_tickets']);
        }
        
        if( isset($fields['acl']) ){
        	$group->setAcl($fields['acl']);
        }
    }

    /**
     * @throws GroupException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\GroupException($message);
    }

}