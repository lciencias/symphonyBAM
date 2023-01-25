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

use Application\Model\Bean\Location;

/**
 *
 * LocationCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Location current()
 * @method \Application\Model\Bean\Location read()
 * @method \Application\Model\Bean\Location getOne()
 * @method \Application\Model\Bean\Location getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\LocationCollection intersect() intersect(\Application\Model\Collection\LocationCollection $collection)
 * @method \Application\Model\Collection\LocationCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\LocationCollection merge() merge(\Application\Model\Collection\LocationCollection $collection)
 * @method \Application\Model\Collection\LocationCollection diff() diff(\Application\Model\Collection\LocationCollection $collection)
 * @method \Application\Model\Collection\LocationCollection copy()
 */
class LocationCollection extends Collection{

    /**
     *
     * @param Location $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Location) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Location");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Location $location){
            return array( $location->getIdLocation() => $location->getName() );
        });
    }

}