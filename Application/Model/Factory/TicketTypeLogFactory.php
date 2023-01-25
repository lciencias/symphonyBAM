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

use Application\Model\Bean\TicketTypeLog;

/**
 *
 * TicketTypeLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TicketTypeLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketTypeLog
     */
    public static function createFromArray($fields)
    {
        $ticketTypeLog = new TicketTypeLog();
        self::populate($ticketTypeLog, $fields);

        return $ticketTypeLog;
    }

    /**
     *
     * @static
     * @param TicketTypeLog ticketTypeLog
     * @param array $fields
     */
    public static function populate($ticketTypeLog, $fields)
    {
        if( !($ticketTypeLog instanceof TicketTypeLog) ){
            static::throwException("El objecto no es un TicketTypeLog");
        }

        if( isset($fields['id_ticket_type_log']) ){
            $ticketTypeLog->setIdTicketTypeLog($fields['id_ticket_type_log']);
        }

        if( isset($fields['id_ticket_type']) ){
            $ticketTypeLog->setIdTicketType($fields['id_ticket_type']);
        }

        if( isset($fields['id_user']) ){
            $ticketTypeLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $ticketTypeLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_log']) ){
            $ticketTypeLog->setEventLog($fields['event_log']);
        }

        if( isset($fields['note']) ){
            $ticketTypeLog->setNote($fields['note']);
        }
    }

    /**
     * @throws TicketTypeLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketTypeLogException($message);
    }

}