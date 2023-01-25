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

use Application\Model\Bean\MenuItem;

/**
 *
 * MenuItemFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class MenuItemFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\MenuItem
     */
    public static function createFromArray($fields)
    {
        $menuItem = new MenuItem();
        self::populate($menuItem, $fields);

        return $menuItem;
    }

    /**
     *
     * @static
     * @param MenuItem menuItem
     * @param array $fields
     */
    public static function populate($menuItem, $fields)
    {
        if( !($menuItem instanceof MenuItem) ){
            static::throwException("El objecto no es un MenuItem");
        }

        if( isset($fields['id_menu_item']) ){
            $menuItem->setIdMenuItem($fields['id_menu_item']);
        }

        if( isset($fields['id_parent']) ){
            $menuItem->setIdParent($fields['id_parent']);
        }

        if( isset($fields['id_action']) ){
            $menuItem->setIdAction($fields['id_action']);
        }

        if( isset($fields['name']) ){
            $menuItem->setName($fields['name']);
        }

        if( isset($fields['order']) ){
            $menuItem->setOrder($fields['order']);
        }

        if( isset($fields['icon']) ){
            $menuItem->setIcon($fields['icon']);
        }

        if( isset($fields['icon_size']) ){
            $menuItem->setIconSize($fields['icon_size']);
        }
    }

    /**
     * @throws MenuItemException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\MenuItemException($message);
    }

}