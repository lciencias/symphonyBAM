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

use Application\Model\Bean\Resolution;

/**
 *
 * ResolutionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Resolution current()
 * @method \Application\Model\Bean\Resolution read()
 * @method \Application\Model\Bean\Resolution getOne()
 * @method \Application\Model\Bean\Resolution getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ResolutionCollection intersect() intersect(\Application\Model\Collection\ResolutionCollection $collection)
 * @method \Application\Model\Collection\ResolutionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ResolutionCollection merge() merge(\Application\Model\Collection\ResolutionCollection $collection)
 * @method \Application\Model\Collection\ResolutionCollection diff() diff(\Application\Model\Collection\ResolutionCollection $collection)
 * @method \Application\Model\Collection\ResolutionCollection copy()
 */
class ResolutionCollection extends Collection{

    /**
     *
     * @param Resolution $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Resolution) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Resolution");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Resolution $resolution){
            return array( $resolution->getIdResolution() => $resolution->getName() );
        });
    }

    /**
     *
     * @return \Application\Model\Collection\ResolutionCollection
     */
    public function actives(){
        return $this->filter(function(Resolution $resolution){
            return $resolution->isActive();
        });
    }

}