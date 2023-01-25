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

use Application\Model\Bean\Area;

/**
 *
 * AreaCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Area current()
 * @method \Application\Model\Bean\Area read()
 * @method \Application\Model\Bean\Area getOne()
 * @method \Application\Model\Bean\Area getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AreaCollection intersect() intersect(\Application\Model\Collection\AreaCollection $collection)
 * @method \Application\Model\Collection\AreaCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AreaCollection merge() merge(\Application\Model\Collection\AreaCollection $collection)
 * @method \Application\Model\Collection\AreaCollection diff() diff(\Application\Model\Collection\AreaCollection $collection)
 * @method \Application\Model\Collection\AreaCollection copy()
 */
class AreaCollection extends Collection{

    /**
     *
     * @param Area $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Area) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Area");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Area $area){
            return array( $area->getIdArea() => $area->getName() );
        });
    }

}