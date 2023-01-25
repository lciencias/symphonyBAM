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

use Application\Model\Bean\TicketClientDocument;

/**
 *
 * TicketClientDocumentCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\TicketClientDocument current()
 * @method \Application\Model\Bean\TicketClientDocument read()
 * @method \Application\Model\Bean\TicketClientDocument getOne()
 * @method \Application\Model\Bean\TicketClientDocument getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketClientDocumentCollection intersect() intersect(\Application\Model\Collection\TicketClientDocumentCollection $collection)
 * @method \Application\Model\Collection\TicketClientDocumentCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketClientDocumentCollection merge() merge(\Application\Model\Collection\TicketClientDocumentCollection $collection)
 * @method \Application\Model\Collection\TicketClientDocumentCollection diff() diff(\Application\Model\Collection\TicketClientDocumentCollection $collection)
 * @method \Application\Model\Collection\TicketClientDocumentCollection copy()
 */
class TicketClientDocumentCollection extends Collection{

    /**
     *
     * @param TicketClientDocument $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketClientDocument) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketClientDocument");
        }
    }


}