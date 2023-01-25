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

use Application\Model\Bean\Prod;

/**
 *
 * ProductsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ProdFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Prod
     */
    public static function createFromArray($fields)
    {
        $products = new Prod();
        self::populate($products, $fields);
        return $products;
    }
    
    
    /**
     *
     * @param ClientAccount $clientAccount
     * @param \stdClass $stdClass
     */
    public static function populateFromStdClass(Prod $products,\stdClass $stdClass){
    
    	if(isset($stdClass->idBam))
    		$products->setIdBam($stdClass->idBam);
    
    	if (isset($stdClass->name))
    		$products->setName($stdClass->name);
    
    	if (isset($stdClass->noTarjeta))
    		$products->setNoTarjeta($stdClass->noTarjeta);
    }
    

    /**
     *
     * @static
     * @param Products products
     * @param array $fields
     */
    public static function populate($products, $fields)
    {
        if( !($products instanceof Prod) ){
            static::throwException("El objecto no es un Products");
        }

        if( isset($fields['id_bam']) ){
            $products->setIdBam($fields['id_bam']);
        }

        if( isset($fields['name']) ){
            $products->setName(trim($fields['name']));
        }

        if( isset($fields['no_tarjeta']) ){
			$products->setNoTarjeta($fields['no_tarjeta']);
        }
    }

    /**
     * @throws ProductsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ProdException($message);
    }

}