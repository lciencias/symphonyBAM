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

namespace Application\Model\Factory;

use Application\Model\Bean\Ticket;

/**
 *
 * TicketFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class TicketFactory extends BaseTicketFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Ticket
     */
    public static function createFromArray($fields)
    {
        $ticket = new Ticket();
        self::populate($ticket, $fields);

        return $ticket;
    }

    /**
     *
     * @static
     * @param Ticket ticket
     * @param array $fields
     */
    public static function populate($ticket, $fields)
    {
        parent::populate($ticket, $fields);
        if( !($ticket instanceof Ticket) ){
            static::throwException("El objecto no es un Ticket");
        }

        if( isset($fields['id_ticket']) ){
            $ticket->setIdTicket($fields['id_ticket']);
        }

        if( isset($fields['id_category']) ){
            $ticket->setIdCategory($fields['id_category']);
        }

        if( isset($fields['id_base_ticket']) ){
            $ticket->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_employee']) ){
            $ticket->setIdEmployee($fields['id_employee']);
        }

        if( isset($fields['id_company']) ){
            $ticket->setIdCompany($fields['id_company']);
        }

        if( isset($fields['id_priority']) ){
            $ticket->setIdPriority($fields['id_priority']);
        }

        if( isset($fields['id_impact']) ){
            $ticket->setIdImpact($fields['id_impact']);
        }
    }

    /**
     * @throws TicketException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketException($message);
    }

}