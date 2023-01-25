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

use Application\Model\Bean\Impact;

/**
 *
 * ImpactCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Impact current()
 * @method \Application\Model\Bean\Impact read()
 * @method \Application\Model\Bean\Impact getOne()
 * @method \Application\Model\Bean\Impact getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ImpactCollection intersect() intersect(\Application\Model\Collection\ImpactCollection $collection)
 * @method \Application\Model\Collection\ImpactCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ImpactCollection merge() merge(\Application\Model\Collection\ImpactCollection $collection)
 * @method \Application\Model\Collection\ImpactCollection diff() diff(\Application\Model\Collection\ImpactCollection $collection)
 * @method \Application\Model\Collection\ImpactCollection copy()
 */
class ImpactCollection extends Collection{

    /**
     *
     * @param Impact $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Impact) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Impact");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Impact $impact){
            return array( $impact->getIdImpact() => $impact->getName() );
        });
    }

    /**
     *
     * @return \Application\Model\Collection\ImpactCollection
     */
    public function actives(){
        return $this->filter(function(Impact $impact){
            return $impact->isActive();
        });
    }

}