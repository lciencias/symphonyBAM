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

use Application\Model\Bean\TicketClient;

/**
 *
 * TicketClientCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\TicketClient current()
 * @method \Application\Model\Bean\TicketClient read()
 * @method \Application\Model\Bean\TicketClient getOne()
 * @method \Application\Model\Bean\TicketClient getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketClientCollection intersect() intersect(\Application\Model\Collection\TicketClientCollection $collection)
 * @method \Application\Model\Collection\TicketClientCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketClientCollection merge() merge(\Application\Model\Collection\TicketClientCollection $collection)
 * @method \Application\Model\Collection\TicketClientCollection diff() diff(\Application\Model\Collection\TicketClientCollection $collection)
 * @method \Application\Model\Collection\TicketClientCollection copy()
 */
class TicketClientCollection extends BaseTicketCollection{

    /**
     *
     * @param TicketClient $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketClient) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketClient");
        }
    }
    /**
     * convert to array
     * @return array
     */
    public function toArrayForList(){
    	return $this->map(function(TicketClient $ticketClient){
    		return array($ticketClient->getIndex() => $ticketClient->toArrayForList());
    	});
    }

}