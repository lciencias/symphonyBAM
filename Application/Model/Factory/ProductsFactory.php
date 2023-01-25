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

use Application\Model\Bean\Products;

/**
 *
 * ProductsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ProductsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Products
     */
    public static function createFromArray($fields)
    {
        $products = new Products();
        self::populate($products, $fields);

        return $products;
    }
    
    
    /**
     *
     * @param ClientAccount $clientAccount
     * @param \stdClass $stdClass
     */
    public static function populateFromStdClass(Products $products,\stdClass $stdClass){
    
    	if(isset($stdClass->idProduct))
    		$products->setIdProduct($stdClass->idProduct);
    
    	if (isset($stdClass->name))
    		$products->setName($stdClass->name);
    
    	if (isset($stdClass->idProductBam))
    		$products->setIdProductBam($stdClass->idProductBam);

    	if (isset($stdClass->description))
    		$products->setDescription($stdClass->description);
    		
    	if (isset($stdClass->requirements))
    		$products->setRequirements($stdClass->requirements);
    		
    	if (isset($stdClass->commissions))
    		$products->setCommissions($stdClass->commissions);
    		
    	if (isset($stdClass->status))
    		$products->setStatus($stdClass->status);
    }
    

    /**
     *
     * @static
     * @param Products products
     * @param array $fields
     */
    public static function populate($products, $fields)
    {
        if( !($products instanceof Products) ){
            static::throwException("El objecto no es un Products");
        }

        if( isset($fields['id_product']) ){
            $products->setIdProduct($fields['id_product']);
        }

        if( isset($fields['name']) ){
            $products->setName(trim($fields['name']));
        }

        if( isset($fields['id_product_bam']) ){
//             if($fields['id_product_bam'] == 0){
// 				$products->setIdProductBam(new \Zend_Db_Expr("NULL"));
//             } else {
				$products->setIdProductBam($fields['id_product_bam']);
// 			}
        }

        if( isset($fields['description']) ){
            $products->setDescription(trim($fields['description']));
        }

        if( isset($fields['requirements']) ){
            $products->setRequirements(trim($fields['requirements']));
        }

        if( isset($fields['commissions']) ){
            $products->setCommissions(trim($fields['commissions']));
        }

        if( isset($fields['status']) ){
            $products->setStatus($fields['status']);
        }
        if( isset($fields['especial']) ){
        	$products->setEspecial($fields['especial']);
        }
    }

    /**
     * @throws ProductsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ProductsException($message);
    }

}