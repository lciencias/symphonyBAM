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

use Application\Model\Bean\BaseTicket;

/**
 *
 * BaseTicketCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\BaseTicket current()
 * @method \Application\Model\Bean\BaseTicket read()
 * @method \Application\Model\Bean\BaseTicket getOne()
 * @method \Application\Model\Bean\BaseTicket getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\BaseTicketCollection intersect() intersect(\Application\Model\Collection\BaseTicketCollection $collection)
 * @method \Application\Model\Collection\BaseTicketCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\BaseTicketCollection merge() merge(\Application\Model\Collection\BaseTicketCollection $collection)
 * @method \Application\Model\Collection\BaseTicketCollection diff() diff(\Application\Model\Collection\BaseTicketCollection $collection)
 * @method \Application\Model\Collection\BaseTicketCollection copy()
 */
class BaseTicketCollection extends Collection{

    /**
     *
     * @param BaseTicket $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof BaseTicket) ){
            throw new \InvalidArgumentException("Debe de ser un objecto BaseTicket");
        }
    }


}