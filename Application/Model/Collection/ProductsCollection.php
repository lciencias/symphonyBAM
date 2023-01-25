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

namespace Application\Model\Collection;

use Application\Model\Bean\Products;

/**
 *
 * ProductsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Products current()
 * @method \Application\Model\Bean\Products read()
 * @method \Application\Model\Bean\Products getOne()
 * @method \Application\Model\Bean\Products getOneOrElse() getOneOrElse(Application\Model\Bean\Products $products)
 * @method \Application\Model\Bean\Products getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\Products getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\Products $products)
 * @method \Application\Model\Collection\ProductsCollection intersect() intersect(\Application\Model\Collection\ProductsCollection $collection)
 * @method \Application\Model\Collection\ProductsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ProductsCollection merge() merge(\Application\Model\Collection\ProductsCollection $collection)
 * @method \Application\Model\Collection\ProductsCollection diff() diff(\Application\Model\Collection\ProductsCollection $collection)
 * @method \Application\Model\Collection\ProductsCollection copy()
 */
class ProductsCollection extends Collection{

    /**
     *
     * @param Products $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Products) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Products");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(Products $products){
    			    return array( $products->getIdProduct() => $products->getName() );
    		});
    			return $array;
    }
    

    /**
     *
     * @return \Application\Model\Collection\ProductsCollection
     */
    public function actives(){
        return $this->filter(function(Products $products){
            return $products->isActive();
        });
    }
    
    /**
     *
     * @return \Application\Model\Collection\ProductsCollection
     */
    public function inactives(){
        return $this->filter(function(Products $products){
            return $products->isInactive();
        });
    }



}