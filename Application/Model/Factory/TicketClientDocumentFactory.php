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

use Application\Model\Bean\TicketClientDocument;

/**
 *
 * TicketClientDocumentFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class TicketClientDocumentFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketClientDocument
     */
    public static function createFromArray($fields)
    {
        $ticketClientDocument = new TicketClientDocument();
        self::populate($ticketClientDocument, $fields);

        return $ticketClientDocument;
    }

    /**
     *
     * @static
     * @param TicketClientDocument ticketClientDocument
     * @param array $fields
     */
    public static function populate($ticketClientDocument, $fields)
    {
        if( !($ticketClientDocument instanceof TicketClientDocument) ){
            static::throwException("El objecto no es un TicketClientDocument");
        }

        if( isset($fields['id_ticket_client_document']) ){
            $ticketClientDocument->setIdTicketClientDocument($fields['id_ticket_client_document']);
        }

        if( isset($fields['id_document']) ){
            $ticketClientDocument->setIdDocument($fields['id_document']);
        }

        if( isset($fields['id_ticket_client']) ){
            $ticketClientDocument->setIdTicketClient($fields['id_ticket_client']);
        }

        if( isset($fields['id_file']) ){
            $ticketClientDocument->setIdFile($fields['id_file']);
        }
    }

    /**
     * @throws TicketClientDocumentException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketClientDocumentException($message);
    }

}