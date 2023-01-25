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

use Application\Model\Bean\Workweek;

/**
 *
 * WorkweekCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Workweek current()
 * @method \Application\Model\Bean\Workweek read()
 * @method \Application\Model\Bean\Workweek getOne()
 * @method \Application\Model\Bean\Workweek getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\WorkweekCollection intersect() intersect(\Application\Model\Collection\WorkweekCollection $collection)
 * @method \Application\Model\Collection\WorkweekCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\WorkweekCollection merge() merge(\Application\Model\Collection\WorkweekCollection $collection)
 * @method \Application\Model\Collection\WorkweekCollection diff() diff(\Application\Model\Collection\WorkweekCollection $collection)
 * @method \Application\Model\Collection\WorkweekCollection copy()
 */
class WorkweekCollection extends Collection{

    /**
     *
     * @param Workweek $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Workweek) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Workweek");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Workweek $workweek){
            return array( $workweek->getIdWorkweek() => $workweek->getName() );
        });
    }

}