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

use Application\Model\Bean\ClientCategoriesProducts;

/**
 *
 * ClientCategoriesProductsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ClientCategoriesProductsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientCategoriesProducts
     */
    public static function createFromArray($fields)
    {
        $clientCategoriesProducts = new ClientCategoriesProducts();
        self::populate($clientCategoriesProducts, $fields);

        return $clientCategoriesProducts;
    }

    /**
     *
     * @static
     * @param ClientCategoriesProducts clientCategoriesProducts
     * @param array $fields
     */
    public static function populate($clientCategoriesProducts, $fields)
    {
        if( !($clientCategoriesProducts instanceof ClientCategoriesProducts) ){
            static::throwException("El objecto no es un ClientCategoriesProducts");
        }

        if( isset($fields['id_client_category_product']) ){
            $clientCategoriesProducts->setIdClientCategoryProduct($fields['id_client_category_product']);
        }

        if( isset($fields['id_client_category']) ){
            if($fields['id_client_category'] == 0){
				$clientCategoriesProducts->setIdClientCategory(new \Zend_Db_Expr("NULL"));
            } else {
				$clientCategoriesProducts->setIdClientCategory($fields['id_client_category']);
			}
        }

        if( isset($fields['id_product']) ){
            if($fields['id_product'] == 0){
				$clientCategoriesProducts->setIdProduct(new \Zend_Db_Expr("NULL"));
            } else {
				$clientCategoriesProducts->setIdProduct($fields['id_product']);
			}
        }
    }

    /**
     * @throws ClientCategoriesProductsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientCategoriesProductsException($message);
    }

}