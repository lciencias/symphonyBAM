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

use Application\Model\Bean\TicketClientField;

/**
 *
 * TicketClientFieldCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\TicketClientField current()
 * @method \Application\Model\Bean\TicketClientField read()
 * @method \Application\Model\Bean\TicketClientField getOne()
 * @method \Application\Model\Bean\TicketClientField getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TicketClientFieldCollection intersect() intersect(\Application\Model\Collection\TicketClientFieldCollection $collection)
 * @method \Application\Model\Collection\TicketClientFieldCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketClientFieldCollection merge() merge(\Application\Model\Collection\TicketClientFieldCollection $collection)
 * @method \Application\Model\Collection\TicketClientFieldCollection diff() diff(\Application\Model\Collection\TicketClientFieldCollection $collection)
 * @method \Application\Model\Collection\TicketClientFieldCollection copy()
 */
class TicketClientFieldCollection extends Collection{

    /**
     *
     * @param TicketClientField $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketClientField) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketClientField");
        }
    }


}