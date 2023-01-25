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

use Application\Model\Bean\TicketClientField;

/**
 *
 * TicketClientFieldFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class TicketClientFieldFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketClientField
     */
    public static function createFromArray($fields)
    {
        $ticketClientField = new TicketClientField();
        self::populate($ticketClientField, $fields);

        return $ticketClientField;
    }

    /**
     *
     * @static
     * @param TicketClientField ticketClientField
     * @param array $fields
     */
    public static function populate($ticketClientField, $fields)
    {
        if( !($ticketClientField instanceof TicketClientField) ){
            static::throwException("El objecto no es un TicketClientField");
        }

        if( isset($fields['id_ticket_client_field']) ){
            $ticketClientField->setIdTicketClientField($fields['id_ticket_client_field']);
        }

        if( isset($fields['id_ticket_client']) ){
            $ticketClientField->setIdTicketClient($fields['id_ticket_client']);
        }

        if( isset($fields['id_field']) ){
            $ticketClientField->setIdField($fields['id_field']);
        }

        if( isset($fields['value']) ){
            $ticketClientField->setValue($fields['value']);
        }
    }

    /**
     * @throws TicketClientFieldException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketClientFieldException($message);
    }

}