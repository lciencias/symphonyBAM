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

use Application\Model\Bean\Position;

/**
 *
 * PositionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Position current()
 * @method \Application\Model\Bean\Position read()
 * @method \Application\Model\Bean\Position getOne()
 * @method \Application\Model\Bean\Position getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PositionCollection intersect() intersect(\Application\Model\Collection\PositionCollection $collection)
 * @method \Application\Model\Collection\PositionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PositionCollection merge() merge(\Application\Model\Collection\PositionCollection $collection)
 * @method \Application\Model\Collection\PositionCollection diff() diff(\Application\Model\Collection\PositionCollection $collection)
 * @method \Application\Model\Collection\PositionCollection copy()
 */
class PositionCollection extends Collection{

    /**
     *
     * @param Position $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Position) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Position");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Position $position){
            return array( $position->getIdPosition() => $position->getName() );
        });
    }

}