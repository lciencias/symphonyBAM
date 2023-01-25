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

use Application\Model\Bean\ServiceLevel;

/**
 *
 * ServiceLevelCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ServiceLevel current()
 * @method \Application\Model\Bean\ServiceLevel read()
 * @method \Application\Model\Bean\ServiceLevel getOne()
 * @method \Application\Model\Bean\ServiceLevel getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ServiceLevelCollection intersect() intersect(\Application\Model\Collection\ServiceLevelCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ServiceLevelCollection merge() merge(\Application\Model\Collection\ServiceLevelCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelCollection diff() diff(\Application\Model\Collection\ServiceLevelCollection $collection)
 * @method \Application\Model\Collection\ServiceLevelCollection copy()
 */
class ServiceLevelCollection extends Collection{

    /**
     *
     * @param ServiceLevel $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ServiceLevel) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ServiceLevel");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(ServiceLevel $serviceLevel){
            return array( $serviceLevel->getIdServiceLevel() => $serviceLevel->getName() );
        });
    }

}