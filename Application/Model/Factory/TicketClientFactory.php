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

use Application\Model\Bean\TicketClient;

/**
 *
 * TicketClientFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class TicketClientFactory extends BaseTicketFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketClient
     */
    public static function createFromArray($fields)
    {
        $ticketClient = new TicketClient();
        self::populate($ticketClient, $fields);

        return $ticketClient;
    }

    /**
     *
     * @static
     * @param TicketClient ticketClient
     * @param array $fields
     */
    public static function populate($ticketClient, $fields)
    {
        parent::populate($ticketClient, $fields);
        if( !($ticketClient instanceof TicketClient) ){
            static::throwException("El objecto no es un TicketClient");
        }

        if( isset($fields['id_ticket_client']) ){
            $ticketClient->setIdTicketClient($fields['id_ticket_client']);
        }

        if( isset($fields['id_base_ticket']) ){
            $ticketClient->setIdBaseTicket($fields['id_base_ticket']);
        }
 		if( isset($fields['id_client_category']) ){
            $ticketClient->setIdClientCategory($fields['id_client_category']);
        }
        if( isset($fields['folio']) ){
            $ticketClient->setFolio($fields['folio']);
        }

        if( isset($fields['account_number']) ){
            $ticketClient->setAccountNumber($fields['account_number']);
        }

        if( isset($fields['id_origin_branch']) ){
            $ticketClient->setIdOriginBranch($fields['id_origin_branch']);
        }

        if( isset($fields['id_reported_branch']) ){
            $ticketClient->setIdReportedBranch($fields['id_reported_branch']);
        }
        
        if( isset($fields['id_product']) ){
        	$ticketClient->setIdProduct($fields['id_product']);
        }
        
        if( isset($fields['email']) ){
        	$ticketClient->setEmail($fields['email']);
        }        
        
        if( isset($fields['folio_prev']) ){
        	$ticketClient->setFolioPrev($fields['folio_prev']);
        }
        
        if( isset($fields['client_number']) ){
        	$ticketClient->setClientNumber($fields['client_number']);
        }
        if( isset($fields['id_user_last_assign']) ){
        	$ticketClient->setIdUserLastAssign($fields['id_user_last_assign']);
        }
        if( isset($fields['state_client']) ){
        	$ticketClient->setStateClient($fields['state_client']);
        }
        if( isset($fields['name_client']) ){
        	$ticketClient->setNameClient($fields['name_client']);
        }
        if( isset($fields['no_card']) ){
        	$ticketClient->setNoCard($fields['no_card']);
        }
        if( isset($fields['employee']) ){
        	$ticketClient->setEmployee($fields['employee']);
        }
        if( isset($fields['card_type']) ){
        	$ticketClient->setCardType($fields['card_type']);
        }
        if( isset($fields['expiration_date']) ){
        	$ticketClient->setExpirationDate($fields['expiration_date']);
        }
        if( isset($fields['chanel']) ){
        	$ticketClient->setChanel($fields['chanel']);
        }
        if( isset($fields['folio_condusef']) ){
        	$ticketClient->setFolioCondusef($fields['folio_condusef']);        	
        }
        if( isset($fields['id_resolver']) ){
        	$ticketClient->setIdResolver($fields['id_resolver']);
        }
        if( isset($fields['account_type']) ){
        	$ticketClient->setAccountType($fields['account_type']);
        }
        if( isset($fields['telefono']) ){
        	$ticketClient->setTelefono($fields['telefono']);
        }
        if( isset($fields['id_entidad']) ){
        	$ticketClient->setIdEntidad($fields['id_entidad']);
        }
        if( isset($fields['complaint']) ){
        	$ticketClient->setComplaint($fields['complaint']);
        }        
    }

    /**
     * @throws TicketClientException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketClientException($message);
    }

}