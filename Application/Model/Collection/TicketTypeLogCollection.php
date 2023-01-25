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

use Application\Model\Bean\TicketTypeLog;

/**
 *
 * TicketTypeLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketTypeLog current()
 * @method \Application\Model\Bean\TicketTypeLog read()
 * @method \Application\Model\Bean\TicketTypeLog getOne()
 * @method \Application\Model\Bean\TicketTypeLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketTypeLogCollection intersect() intersect(\Application\Model\Collection\TicketTypeLogCollection $collection)
 * @method \Application\Model\Collection\TicketTypeLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketTypeLogCollection merge() merge(\Application\Model\Collection\TicketTypeLogCollection $collection)
 * @method \Application\Model\Collection\TicketTypeLogCollection diff() diff(\Application\Model\Collection\TicketTypeLogCollection $collection)
 * @method \Application\Model\Collection\TicketTypeLogCollection copy()
 */
class TicketTypeLogCollection extends Collection{

    /**
     *
     * @param TicketTypeLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketTypeLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketTypeLog");
        }
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function($log){
            return array($log->getIdUser() => $log->getIdUser());
        });
    }

}