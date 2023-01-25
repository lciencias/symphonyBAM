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

use Application\Model\Bean\ReasonProducts;

/**
 *
 * ReasonProductsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ReasonProducts current()
 * @method \Application\Model\Bean\ReasonProducts read()
 * @method \Application\Model\Bean\ReasonProducts getOne()
 * @method \Application\Model\Bean\ReasonProducts getOneOrElse() getOneOrElse(Application\Model\Bean\ReasonProducts $reasonProducts)
 * @method \Application\Model\Bean\ReasonProducts getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\ReasonProducts getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\ReasonProducts $reasonProducts)
 * @method \Application\Model\Collection\ReasonProductsCollection intersect() intersect(\Application\Model\Collection\ReasonProductsCollection $collection)
 * @method \Application\Model\Collection\ReasonProductsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ReasonProductsCollection merge() merge(\Application\Model\Collection\ReasonProductsCollection $collection)
 * @method \Application\Model\Collection\ReasonProductsCollection diff() diff(\Application\Model\Collection\ReasonProductsCollection $collection)
 * @method \Application\Model\Collection\ReasonProductsCollection copy()
 */
class ReasonProductsCollection extends Collection{

    /**
     *
     * @param ReasonProducts $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ReasonProducts) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ReasonProducts");
        }
    }



	/**
	 * Returns an array with ids the Reasons
	 * @return array
	 */
	public function getReasonsIds()
	{
		return $this->map(function(ReasonProducts $reasonProducts){
			return array( $reasonProducts->getIdReasons() => $reasonProducts->getIdReasons() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ReasonProductsCollection
     */
	public function getByIdReasons($idReasons)
	{
		$reasonProductsCollection = new ReasonProductsCollection();
		$this->each(function(ReasonProducts $reasonProducts) use ($idReasons, $reasonProductsCollection){
			if( $reasonProducts->getIdReasons() == $idReasons)
				$reasonProductsCollection->append($reasonProducts);
		});
		
		return $reasonProductsCollection;
	}
	
	/**
	 * Returns an array with ids the Products
	 * @return array
	 */
	public function getProductsIds()
	{
		return $this->map(function(ReasonProducts $reasonProducts){
			return array( $reasonProducts->getIdProducts() => $reasonProducts->getIdProducts() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ReasonProductsCollection
     */
	public function getByIdProducts($idProducts)
	{
		$reasonProductsCollection = new ReasonProductsCollection();
		$this->each(function(ReasonProducts $reasonProducts) use ($idProducts, $reasonProductsCollection){
			if( $reasonProducts->getIdProducts() == $idProducts)
				$reasonProductsCollection->append($reasonProducts);
		});
		
		return $reasonProductsCollection;
	}
	

}