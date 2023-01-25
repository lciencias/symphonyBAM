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

use Application\Model\Bean\TransactionsPartialities;

/**
 *
 * TransactionsPartialitiesFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class TransactionsPartialitiesFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TransactionsPartialities
     */
    public static function createFromArray($fields)
    {
        $transactionsPartialities = new TransactionsPartialities();
        self::populate($transactionsPartialities, $fields);

        return $transactionsPartialities;
    }

    /**
     *
     * @static
     * @param TransactionsPartialities transactionsPartialities
     * @param array $fields
     */
    public static function populate($transactionsPartialities, $fields)
    {
        if( !($transactionsPartialities instanceof TransactionsPartialities) ){
            static::throwException("El objecto no es un TransactionsPartialities");
        }

        if( isset($fields['id_ticket_client_transaction_partiality']) ){
            $transactionsPartialities->setIdTicketClientTransactionPartiality($fields['id_ticket_client_transaction_partiality']);
        }

        if( isset($fields['id_ticket_client_transaction']) ){
            if($fields['id_ticket_client_transaction'] == 0){
				$transactionsPartialities->setIdTicketClientTransaction(new \Zend_Db_Expr("NULL"));
            } else {
				$transactionsPartialities->setIdTicketClientTransaction($fields['id_ticket_client_transaction']);
			}
        }

        if( isset($fields['voucher']) ){
            $transactionsPartialities->setVoucher($fields['voucher']);
        }

        if( isset($fields['amount']) ){
            $transactionsPartialities->setAmount($fields['amount']);
        }

        if( isset($fields['deposit_date']) ){
            $transactionsPartialities->setDepositDate($fields['deposit_date']);
        }

        if( isset($fields['type']) ){
            $transactionsPartialities->setType($fields['type']);
        }
    }

    /**
     * @throws TransactionsPartialitiesException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TransactionsPartialitiesException($message);
    }

}