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

use Application\Model\Bean\ClientCategoriesProducts;

/**
 *
 * ClientCategoriesProductsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ClientCategoriesProducts current()
 * @method \Application\Model\Bean\ClientCategoriesProducts read()
 * @method \Application\Model\Bean\ClientCategoriesProducts getOne()
 * @method \Application\Model\Bean\ClientCategoriesProducts getOneOrElse() getOneOrElse(Application\Model\Bean\ClientCategoriesProducts $clientCategoriesProducts)
 * @method \Application\Model\Bean\ClientCategoriesProducts getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\ClientCategoriesProducts getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\ClientCategoriesProducts $clientCategoriesProducts)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection intersect() intersect(\Application\Model\Collection\ClientCategoriesProductsCollection $collection)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection merge() merge(\Application\Model\Collection\ClientCategoriesProductsCollection $collection)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection diff() diff(\Application\Model\Collection\ClientCategoriesProductsCollection $collection)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection copy()
 */
class ClientCategoriesProductsCollection extends Collection{

    /**
     *
     * @param ClientCategoriesProducts $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientCategoriesProducts) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientCategoriesProducts");
        }
    }



	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(ClientCategoriesProducts $clientCategoriesProducts){
			return array( $clientCategoriesProducts->getId() => $clientCategoriesProducts->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ClientCategoriesProductsCollection
     */
	public function getById($id)
	{
		$clientCategoriesProductsCollection = new ClientCategoriesProductsCollection();
		$this->each(function(ClientCategoriesProducts $clientCategoriesProducts) use ($id, $clientCategoriesProductsCollection){
			if( $clientCategoriesProducts->getId() == $id)
				$clientCategoriesProductsCollection->append($clientCategoriesProducts);
		});
		
		return $clientCategoriesProductsCollection;
	}
	
	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(ClientCategoriesProducts $clientCategoriesProducts){
			return array( $clientCategoriesProducts->getId() => $clientCategoriesProducts->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ClientCategoriesProductsCollection
     */
	public function getById($id)
	{
		$clientCategoriesProductsCollection = new ClientCategoriesProductsCollection();
		$this->each(function(ClientCategoriesProducts $clientCategoriesProducts) use ($id, $clientCategoriesProductsCollection){
			if( $clientCategoriesProducts->getId() == $id)
				$clientCategoriesProductsCollection->append($clientCategoriesProducts);
		});
		
		return $clientCategoriesProductsCollection;
	}
	

}