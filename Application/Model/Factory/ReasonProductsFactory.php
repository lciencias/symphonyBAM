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

use Application\Model\Bean\ReasonProducts;

/**
 *
 * ReasonProductsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ReasonProductsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ReasonProducts
     */
    public static function createFromArray($fields)
    {
        $reasonProducts = new ReasonProducts();
        self::populate($reasonProducts, $fields);

        return $reasonProducts;
    }

    /**
     *
     * @static
     * @param ReasonProducts reasonProducts
     * @param array $fields
     */
    public static function populate($reasonProducts, $fields)
    {
        if( !($reasonProducts instanceof ReasonProducts) ){
            static::throwException("El objecto no es un ReasonProducts");
        }

        if( isset($fields['id_reason_product']) ){
            $reasonProducts->setIdReasonProduct($fields['id_reason_product']);
        }

        if( isset($fields['id_reason']) ){
            if($fields['id_reason'] == 0){
				$reasonProducts->setIdReason(new \Zend_Db_Expr("NULL"));
            } else {
				$reasonProducts->setIdReason($fields['id_reason']);
			}
        }

        if( isset($fields['id_product']) ){
            if($fields['id_product'] == 0){
				$reasonProducts->setIdProduct(new \Zend_Db_Expr("NULL"));
            } else {
				$reasonProducts->setIdProduct($fields['id_product']);
			}
        }
    }

    /**
     * @throws ReasonProductsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ReasonProductsException($message);
    }

}