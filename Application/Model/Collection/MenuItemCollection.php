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

use Application\Model\Bean\MenuItem;

/**
 *
 * MenuItemCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\MenuItem current()
 * @method \Application\Model\Bean\MenuItem read()
 * @method \Application\Model\Bean\MenuItem getOne()
 * @method \Application\Model\Bean\MenuItem getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\MenuItemCollection intersect() intersect(\Application\Model\Collection\MenuItemCollection $collection)
 * @method \Application\Model\Collection\MenuItemCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\MenuItemCollection merge() merge(\Application\Model\Collection\MenuItemCollection $collection)
 * @method \Application\Model\Collection\MenuItemCollection diff() diff(\Application\Model\Collection\MenuItemCollection $collection)
 * @method \Application\Model\Collection\MenuItemCollection copy()
 */
class MenuItemCollection extends Collection{

    /**
     *
     * @param MenuItem $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof MenuItem) ){
            throw new \InvalidArgumentException("Debe de ser un objecto MenuItem");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(MenuItem $menuItem){
            return array( $menuItem->getIdMenuItem() => $menuItem->getName() );
        });
    }

}