<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Collection;

use Application\Model\Bean\Ticket;

/**
 *
 * TicketCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Ticket current()
 * @method \Application\Model\Bean\Ticket read()
 * @method \Application\Model\Bean\Ticket getOne()
 * @method \Application\Model\Bean\Ticket getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketCollection intersect() intersect(\Application\Model\Collection\TicketCollection $collection)
 * @method \Application\Model\Collection\TicketCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketCollection merge() merge(\Application\Model\Collection\TicketCollection $collection)
 * @method \Application\Model\Collection\TicketCollection diff() diff(\Application\Model\Collection\TicketCollection $collection)
 * @method \Application\Model\Collection\TicketCollection copy()
 */
class TicketCollection extends BaseTicketCollection{

    /**
     *
     * @param Ticket $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Ticket) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Ticket");
        }
    }

    /**
     * @return array
     */
    public function getEmployeeIds(){
        return $this->map(function (Ticket $ticket){
            return array($ticket->getIdEmployee() => $ticket->getIdEmployee());
        });
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function (Ticket $ticket){
            return array($ticket->getIdUser() => $ticket->getIdUser());
        });
    }

    /**
     * @return array
     */
    public function getCategoryIds(){
        return $this->map(function (Ticket $ticket){
            return array($ticket->getIdCategory() => $ticket->getIdCategory());
        });
    }

}