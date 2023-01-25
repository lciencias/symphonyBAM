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

use Application\Model\Bean\ControversyChargebacks;

/**
 *
 * ControversyChargebacksFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ControversyChargebacksFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ControversyChargebacks
     */
    public static function createFromArray($fields)
    {
        $controversyChargebacks = new ControversyChargebacks();
        self::populate($controversyChargebacks, $fields);

        return $controversyChargebacks;
    }

    /**
     *
     * @static
     * @param ControversyChargebacks controversyChargebacks
     * @param array $fields
     */
    public static function populate($controversyChargebacks, $fields)
    {
        if( !($controversyChargebacks instanceof ControversyChargebacks) ){
            static::throwException("El objecto no es un ControversyChargebacks");
        }

        if( isset($fields['id_controversy_chargeback']) ){
            $controversyChargebacks->setIdControversyChargeback($fields['id_controversy_chargeback']);
        }

        if( isset($fields['id_controversy_reason']) ){
            if($fields['id_controversy_reason'] == 0){
				$controversyChargebacks->setIdControversyReason(new \Zend_Db_Expr("NULL"));
            } else {
				$controversyChargebacks->setIdControversyReason($fields['id_controversy_reason']);
			}
        }

        if( isset($fields['name']) ){
            $controversyChargebacks->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $controversyChargebacks->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $controversyChargebacks->setStatus($fields['status']);
        }
    }

    /**
     * @throws ControversyChargebacksException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ControversyChargebacksException($message);
    }

}