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

use Application\Model\Bean\Calendar;

/**
 *
 * CalendarCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Calendar current()
 * @method \Application\Model\Bean\Calendar read()
 * @method \Application\Model\Bean\Calendar getOne()
 * @method \Application\Model\Bean\Calendar getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CalendarCollection intersect() intersect(\Application\Model\Collection\CalendarCollection $collection)
 * @method \Application\Model\Collection\CalendarCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CalendarCollection merge() merge(\Application\Model\Collection\CalendarCollection $collection)
 * @method \Application\Model\Collection\CalendarCollection diff() diff(\Application\Model\Collection\CalendarCollection $collection)
 * @method \Application\Model\Collection\CalendarCollection copy()
 */
class CalendarCollection extends Collection{

    /**
     *
     * @param Calendar $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Calendar) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Calendar");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Calendar $calendar){
            return array( $calendar->getIdCalendar() => $calendar->getNameHoliday() );
        });
    }

}