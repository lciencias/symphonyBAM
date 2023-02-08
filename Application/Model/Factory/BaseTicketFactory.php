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

use Application\Model\Bean\BaseTicket;

/**
 *
 * BaseTicketFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class BaseTicketFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\BaseTicket
     */
    public static function createFromArray($fields)
    {
        $baseTicket = new BaseTicket();
        self::populate($baseTicket, $fields);

        return $baseTicket;
    }

    /**
     *
     * @static
     * @param BaseTicket baseTicket
     * @param array $fields
     */
    public static function populate($baseTicket, $fields)
    {
        if( !($baseTicket instanceof BaseTicket) ){
            static::throwException("El objecto no es un BaseTicket");
        }

        if( isset($fields['id_base_ticket']) ){
            $baseTicket->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_channel']) ){
            $baseTicket->setIdChannel($fields['id_channel']);
        }

        if( isset($fields['id_ticket_type']) ){
            $baseTicket->setIdTicketType($fields['id_ticket_type']);
        }

        if( isset($fields['id_user']) ){
            $baseTicket->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_assignment']) ){
            $baseTicket->setIdAssignment($fields['id_assignment']);
        }

        if( isset($fields['status']) ){
            $baseTicket->setStatus($fields['status']);
        }

        if( isset($fields['description']) ){
            $baseTicket->setDescription($fields['description']);
        }

        if( isset($fields['created']) ){
            $baseTicket->setCreated($fields['created']);
        }

        if( isset($fields['scheduled_date']) ){
            $baseTicket->setScheduledDate($fields['scheduled_date']);
        }

        if( isset($fields['is_stopped']) ){
            $baseTicket->setIsStopped($fields['is_stopped']);
        }

        if( isset($fields['type']) ){
            $baseTicket->setType($fields['type']);
        }

        if( isset($fields['registry']) ){
        	$baseTicket->setRegistry($fields['registry']);
        }

        if( isset($fields['email']) ){
            $baseTicket->setEmail($fields['email']);
        }

    }

    /**
     * @throws BaseTicketException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\BaseTicketException($message);
    }

}