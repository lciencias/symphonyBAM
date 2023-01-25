<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Factory;

use Application\Model\Bean\TicketsClientsReopen;

/**
 *
 * TicketsClientsReopenFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class TicketsClientsReopenFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketsClientsReopen
     */
    public static function createFromArray($fields)
    {
        $ticketsClientsReopen = new TicketsClientsReopen();
        self::populate($ticketsClientsReopen, $fields);
        return $ticketsClientsReopen;
    }

    /**
     *
     * @static
     * @param TicketsClientsReopen ticketsClientsReopen
     * @param array $fields
     */
    public static function populate($ticketsClientsReopen, $fields)
    {
        if( !($ticketsClientsReopen instanceof TicketsClientsReopen) ){
            static::throwException("El objecto no es un TicketsClientsReopen");
        }

        if( isset($fields['id']) ){
            $ticketsClientsReopen->setId($fields['id']);
        }

        if( isset($fields['id_ticket_client']) ){
            if($fields['id_ticket_client'] == 0){
				$ticketsClientsReopen->setIdTicketClient(new \Zend_Db_Expr("NULL"));
            } else {
				$ticketsClientsReopen->setIdTicketClient($fields['id_ticket_client']);
			}
        }
        
        if( isset($fields['id_ticket_client_transaction']) ){
        	if($fields['id_ticket_client_transaction'] == 0){
        		$ticketsClientsReopen->setIdTicketClient(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setIdTicketClientTransaction($fields['id_ticket_client_transaction']);
        	}
        }
        
        if( isset($fields['amount']) ){
        	if(empty($fields['amount'])){
        		$ticketsClientsReopen->setAmount(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setAmount($fields['amount']);
        	}
        }

        if( isset($fields['good_faith_payment']) ){
        	if(empty($fields['good_faith_payment'])){
        		$ticketsClientsReopen->setGoodFaithPayment(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setGoodFaithPayment($fields['good_faith_payment']);
        	}
        }
        
        if( isset($fields['good_faith_date']) ){
        	if(empty($fields['good_faith_date'])){
        		$ticketsClientsReopen->setGoodFaithDate(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setGoodFaithDate($fields['good_faith_date']);
        	}
        }
        
        if( isset($fields['good_faith_amount']) ){
        	if(empty($fields['good_faith_amount'])){
        		$ticketsClientsReopen->setGoodFaithAmount(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setGoodFaithAmount($fields['good_faith_amount']);
        	}
        } 

        if( isset($fields['good_faith_request']) ){
        	if(empty($fields['good_faith_request'])){
        		$ticketsClientsReopen->setGoodFaithRequest(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsReopen->setGoodFaithRequest($fields['good_faith_request']);
        	}
        }        
    }

    /**
     * @throws TicketsClientsTransactionsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketsClientsReopenException($message);
    }

}