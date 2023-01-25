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

use Application\Model\Bean\Transactions;

/**
 *
 * TransactionsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class TransactionsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Transactions
     */
    public static function createFromArray($fields)
    {
        $transactions = new Transactions();
        self::populate($transactions, $fields);

        return $transactions;
    }

    /**
     *
     * @static
     * @param Transactions transactions
     * @param array $fields
     */
    public static function populate($transactions, $fields)
    {
        if( !($transactions instanceof Transactions) ){
            static::throwException("El objecto no es un Transactions");
        }

        if( isset($fields['id_transaction']) ){
            $transactions->setIdTransaction($fields['id_transaction']);
        }

        if( isset($fields['transaction_date']) ){
            $transactions->setTransactionDate($fields['transaction_date']);
        }

        if( isset($fields['post_date']) ){
            $transactions->setPostDate($fields['post_date']);
        }

        if( isset($fields['descriptions']) ){
            $transactions->setDescriptions($fields['descriptions']);
        }

        if( isset($fields['reference_number']) ){
            $transactions->setReferenceNumber($fields['reference_number']);
        }

        if( isset($fields['amount']) ){
            $transactions->setAmount($fields['amount']);
        }

        if( isset($fields['id_type_transaction']) ){
            $transactions->setIdTypeTransaction($fields['id_type_transaction']);
        }

        if( isset($fields['giro']) ){
            $transactions->setGiro($fields['giro']);
        }

        if( isset($fields['comerce']) ){
            $transactions->setComerce($fields['comerce']);
        }

        if( isset($fields['pem']) ){
            $transactions->setPem($fields['pem']);
        }

        if( isset($fields['reference']) ){
            $transactions->setReference($fields['reference']);
        }

        if( isset($fields['time_tx']) ){
            $transactions->setTimeTx($fields['time_tx']);
        }

        if( isset($fields['answer']) ){
            $transactions->setAnswer($fields['answer']);
        }

        if( isset($fields['id_reason']) ){
            $transactions->setIdReason($fields['id_reason']);
        }

        if( isset($fields['authorization_number']) ){
            $transactions->setAuthorizationNumber($fields['authorization_number']);
        }

        if( isset($fields['afilition']) ){
            $transactions->setAfilition($fields['afilition']);
        }

        if( isset($fields['sequence']) ){
            $transactions->setSequence($fields['sequence']);
        }

        if( isset($fields['response']) ){
            $transactions->setResponse($fields['response']);
        }
    }

    /**
     * @throws TransactionsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TransactionsException($message);
    }

}