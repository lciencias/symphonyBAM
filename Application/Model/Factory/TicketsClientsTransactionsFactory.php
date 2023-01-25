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

use Application\Model\Bean\TicketsClientsTransactions;

/**
 *
 * TicketsClientsTransactionsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class TicketsClientsTransactionsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TicketsClientsTransactions
     */
    public static function createFromArray($fields)
    {
        $ticketsClientsTransactions = new TicketsClientsTransactions();
        self::populate($ticketsClientsTransactions, $fields);
        return $ticketsClientsTransactions;
    }

    /**
     *
     * @static
     * @param TicketsClientsTransactions ticketsClientsTransactions
     * @param array $fields
     */
    public static function populate($ticketsClientsTransactions, $fields)
    {
        if( !($ticketsClientsTransactions instanceof TicketsClientsTransactions) ){
            static::throwException("El objecto no es un TicketsClientsTransactions");
        }

        if( isset($fields['id_ticket_client_transaction']) ){
            $ticketsClientsTransactions->setIdTicketClientTransaction($fields['id_ticket_client_transaction']);
        }

        if( isset($fields['id_ticket_client']) ){
            if($fields['id_ticket_client'] == 0){
				$ticketsClientsTransactions->setIdTicketClient(new \Zend_Db_Expr("NULL"));
            } else {
				$ticketsClientsTransactions->setIdTicketClient($fields['id_ticket_client']);
			}
        }

        if( isset($fields['id_transaction_bam']) ){
            if($fields['id_transaction_bam'] == 0){
				$ticketsClientsTransactions->setIdTransactionBam(new \Zend_Db_Expr("NULL"));
            } else {
				$ticketsClientsTransactions->setIdTransactionBam($fields['id_transaction_bam']);
			}
        }
        if( isset($fields['transaction_date']) ){
        	if(empty($fields['transaction_date'])){
        		$ticketsClientsTransactions->setTransactionDate(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setTransactionDate($fields['transaction_date']);
        	}
        }
        if( isset($fields['amount']) ){
        	if(empty($fields['amount'])){
        		$ticketsClientsTransactions->setAmount(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setAmount($fields['amount']);
        	}
        }

        if( isset($fields['good_faith_payment']) ){
        	if(empty($fields['good_faith_payment'])){
        		$ticketsClientsTransactions->setGoodFaithPayment(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setGoodFaithPayment($fields['good_faith_payment']);
        	}
        }
        
        if( isset($fields['good_faith_date']) ){
        	if(empty($fields['good_faith_date'])){
        		$ticketsClientsTransactions->setGoodFaithDate(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setGoodFaithDate($fields['good_faith_date']);
        	}
        }
        
        if( isset($fields['good_faith_amount']) ){
        	if(empty($fields['good_faith_amount'])){
        		$ticketsClientsTransactions->setGoodFaithAmount(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setGoodFaithAmount($fields['good_faith_amount']);
        	}
        }
        
        if( isset($fields['id_controversy_chargeback']) ){
        	if(empty($fields['id_controversy_chargeback'])){
        		$ticketsClientsTransactions->setIdControversyChargeback(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setIdControversyChargeback($fields['id_controversy_chargeback']);
        	}
        }
        
        if( isset($fields['payment_request_date']) ){
        	if(empty($fields['payment_request_date'])){
        		$ticketsClientsTransactions->setPaymentRequestDate(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setPaymentRequestDate($fields['payment_request_date']);
        	}
        }
        
        if( isset($fields['payment_delivery_date']) ){
        	if(empty($fields['payment_delivery_date'])){
        		$ticketsClientsTransactions->setPaymentDeliveryDate(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setPaymentDeliveryDate($fields['payment_delivery_date']);
        	}
        }

        if( isset($fields['accepted_payment']) ){
        	if(empty($fields['accepted_payment'])){
        		$ticketsClientsTransactions->setAcceptedPayment(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setAcceptedPayment($fields['accepted_payment']);
        	}
        }
        
        if( isset($fields['delivered_payment']) ){
        	if(empty($fields['delivered_payment'])){
        		$ticketsClientsTransactions->setDeliveryPayment(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setDeliveryPayment($fields['delivered_payment']);
        	}
        }

        if( isset($fields['type']) ){
        	if(empty($fields['type'])){
        		$ticketsClientsTransactions->setType(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setType($fields['type']);
        	}
        }

        if( isset($fields['file_payment']) ){
        	if(empty($fields['file_payment'])){
        		$ticketsClientsTransactions->setFilePayment(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setFilePayment($fields['file_payment']);
        	}
        }

        if( isset($fields['file_delivery']) ){
        	if(empty($fields['file_delivery'])){
        		$ticketsClientsTransactions->setFileDelivery(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setFileDelivery($fields['file_delivery']);
        	}
        }
        
       
        if( isset($fields['good_faith_request']) ){
        	if(empty($fields['good_faith_request'])){
        		$ticketsClientsTransactions->setGoodFaithRequest(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setGoodFaithRequest($fields['good_faith_request']);
        	}
        }
        
        if( isset($fields['reference']) ){
        	if(empty($fields['reference'])){
        		$ticketsClientsTransactions->setReference(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setReference($fields['reference']);
        	}
        }
        
        if( isset($fields['afiliation']) ){
        	if(empty($fields['afiliation'])){
        		$ticketsClientsTransactions->setAfiliation(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setAfiliation($fields['afiliation']);
        	}
        }
        
        if( isset($fields['commerce']) ){
        	if(empty($fields['commerce'])){
        		$ticketsClientsTransactions->setCommerce(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setCommerce($fields['commerce']);
        	}
        }

        if( isset($fields['description']) ){
        	if(empty($fields['description'])){
        		$ticketsClientsTransactions->setCommerce(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setDescription($fields['description']);
        	}
        }
        
        if( isset($fields['idT24']) ){
        	if(empty($fields['idT24'])){
        		$ticketsClientsTransactions->setCommerce(new \Zend_Db_Expr("NULL"));
        	} else {
        		$ticketsClientsTransactions->setIdT24($fields['idT24']);
        	}
        }        
    }

    /**
     * @throws TicketsClientsTransactionsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TicketsClientsTransactionsException($message);
    }

}