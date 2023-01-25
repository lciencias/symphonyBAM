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

use Application\Model\Bean\TicketType;

/**
 *
 * TicketTypeCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketType current()
 * @method \Application\Model\Bean\TicketType read()
 * @method \Application\Model\Bean\TicketType getOne()
 * @method \Application\Model\Bean\TicketType getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketTypeCollection intersect() intersect(\Application\Model\Collection\TicketTypeCollection $collection)
 * @method \Application\Model\Collection\TicketTypeCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketTypeCollection merge() merge(\Application\Model\Collection\TicketTypeCollection $collection)
 * @method \Application\Model\Collection\TicketTypeCollection diff() diff(\Application\Model\Collection\TicketTypeCollection $collection)
 * @method \Application\Model\Collection\TicketTypeCollection copy()
 */
class TicketTypeCollection extends Collection{

    /**
     *
     * @param TicketType $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketType) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketType");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
        $array += $this->map(function(TicketType $ticketType){
            return array( $ticketType->getIdTicketType() => $ticketType->getName() );
        });
        return $array;
    }

    /**
     *
     * @return \Application\Model\Collection\TicketTypeCollection
     */
    public function actives(){
        return $this->filter(function(TicketType $ticketType){
            return $ticketType->isActive();
        });
    }

}