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

use Application\Model\Bean\TicketLog;

/**
 *
 * TicketLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketLog current()
 * @method \Application\Model\Bean\TicketLog read()
 * @method \Application\Model\Bean\TicketLog getOne()
 * @method \Application\Model\Bean\TicketLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketLogCollection intersect() intersect(\Application\Model\Collection\TicketLogCollection $collection)
 * @method \Application\Model\Collection\TicketLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketLogCollection merge() merge(\Application\Model\Collection\TicketLogCollection $collection)
 * @method \Application\Model\Collection\TicketLogCollection diff() diff(\Application\Model\Collection\TicketLogCollection $collection)
 * @method \Application\Model\Collection\TicketLogCollection copy()
 */
class TicketLogCollection extends Collection{

    /**
     *
     * @param TicketLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketLog");
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