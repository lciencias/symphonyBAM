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

use Application\Model\Bean\TicketLog;

/**
 *
 * TicketLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TicketLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketLog
     */
    public static function createFromArray($fields)
    {
        $ticketLog = new TicketLog();
        self::populate($ticketLog, $fields);

        return $ticketLog;
    }

    /**
     *
     * @static
     * @param TicketLog ticketLog
     * @param array $fields
     */
    public static function populate($ticketLog, $fields)
    {
        if( !($ticketLog instanceof TicketLog) ){
            static::throwException("El objecto no es un TicketLog");
        }

        if( isset($fields['id_ticket_log']) ){
            $ticketLog->setIdTicketLog($fields['id_ticket_log']);
        }

        if( isset($fields['id_base_ticket']) ){
            $ticketLog->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_user']) ){
            $ticketLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $ticketLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $ticketLog->setEventType($fields['event_type']);
        }

        if( isset($fields['changed_from']) ){
            $ticketLog->setChangedFrom($fields['changed_from']);
        }

        if( isset($fields['changed_to']) ){
            $ticketLog->setChangedTo($fields['changed_to']);
        }

        if( isset($fields['note']) ){
            $ticketLog->setNote($fields['note']);
        }
    }

    /**
     * @throws TicketLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketLogException($message);
    }

}