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

use Application\Model\Bean\Workday;

/**
 *
 * WorkdayCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Workday current()
 * @method \Application\Model\Bean\Workday read()
 * @method \Application\Model\Bean\Workday getOne()
 * @method \Application\Model\Bean\Workday getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\WorkdayCollection intersect() intersect(\Application\Model\Collection\WorkdayCollection $collection)
 * @method \Application\Model\Collection\WorkdayCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\WorkdayCollection merge() merge(\Application\Model\Collection\WorkdayCollection $collection)
 * @method \Application\Model\Collection\WorkdayCollection diff() diff(\Application\Model\Collection\WorkdayCollection $collection)
 * @method \Application\Model\Collection\WorkdayCollection copy()
 */
class WorkdayCollection extends Collection{

    /**
     *
     * @param Workday $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Workday) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Workday");
        }
    }

    /**
     *
     * @param int $dayOfWeek
     * @return \Application\Model\Collection\WorkdayCollection
     */
    public function filterByDayOfWeek($dayOfWeek){
        return $this->filter(function(Workday $workday) use($dayOfWeek){
            return $workday->getDayOfWeek() == $dayOfWeek;
        });
    }

    /**
     * (non-PHPdoc)
     * @see Application\Model\Collection.Collection::toArray()
     */
    public function toEditArray(){
        return $this->map(function(Workday $workday){
            return array($workday->getDayOfWeek() => array_map(function ($value){
                if( preg_match('/^[0-9]{2}:[0-9]{2}:[0-9]{2}$/', $value)){
                    return substr($value, 0, 5);
                }
                return $value;
            }, $workday->toArray()));
        });
    }

    /**
     * 
     * @return array
     */
    public function getWorkdaysNumbers(){
    	return $this->map(function(Workday $workday){
    		return array($workday->getDayOfWeek() => $workday->getDayOfWeek());
    	});
    }
}