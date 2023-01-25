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

namespace Application\Model\Factory;

use Application\Model\Bean\TicketType;

/**
 *
 * TicketTypeFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TicketTypeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketType
     */
    public static function createFromArray($fields)
    {
        $ticketType = new TicketType();
        self::populate($ticketType, $fields);

        return $ticketType;
    }

    /**
     *
     * @static
     * @param TicketType ticketType
     * @param array $fields
     */
    public static function populate($ticketType, $fields)
    {
        if( !($ticketType instanceof TicketType) ){
            static::throwException("El objecto no es un TicketType");
        }

        if( isset($fields['id_ticket_type']) ){
            $ticketType->setIdTicketType($fields['id_ticket_type']);
        }

        if( isset($fields['name']) ){
            $ticketType->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $ticketType->setStatus($fields['status']);
        }
    }

    /**
     * @throws TicketTypeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketTypeException($message);
    }

}