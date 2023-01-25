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

use Application\Model\Bean\TransactionsPartialities;

/**
 *
 * TransactionsPartialitiesCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TransactionsPartialities current()
 * @method \Application\Model\Bean\TransactionsPartialities read()
 * @method \Application\Model\Bean\TransactionsPartialities getOne()
 * @method \Application\Model\Bean\TransactionsPartialities getOneOrElse() getOneOrElse(Application\Model\Bean\TransactionsPartialities $transactionsPartialities)
 * @method \Application\Model\Bean\TransactionsPartialities getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\TransactionsPartialities getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\TransactionsPartialities $transactionsPartialities)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection intersect() intersect(\Application\Model\Collection\TransactionsPartialitiesCollection $collection)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection merge() merge(\Application\Model\Collection\TransactionsPartialitiesCollection $collection)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection diff() diff(\Application\Model\Collection\TransactionsPartialitiesCollection $collection)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection copy()
 */
class TransactionsPartialitiesCollection extends Collection{

    /**
     *
     * @param TransactionsPartialities $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TransactionsPartialities) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TransactionsPartialities");
        }
    }



	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(TransactionsPartialities $transactionsPartialities){
			return array( $transactionsPartialities->getId() => $transactionsPartialities->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\TransactionsPartialitiesCollection
     */
	public function getById($id)
	{
		$transactionsPartialitiesCollection = new TransactionsPartialitiesCollection();
		$this->each(function(TransactionsPartialities $transactionsPartialities) use ($id, $transactionsPartialitiesCollection){
			if( $transactionsPartialities->getId() == $id)
				$transactionsPartialitiesCollection->append($transactionsPartialities);
		});
		
		return $transactionsPartialitiesCollection;
	}
	
	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(TransactionsPartialities $transactionsPartialities){
			return array( $transactionsPartialities->getId() => $transactionsPartialities->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\TransactionsPartialitiesCollection
     */
	public function getById($id)
	{
		$transactionsPartialitiesCollection = new TransactionsPartialitiesCollection();
		$this->each(function(TransactionsPartialities $transactionsPartialities) use ($id, $transactionsPartialitiesCollection){
			if( $transactionsPartialities->getId() == $id)
				$transactionsPartialitiesCollection->append($transactionsPartialities);
		});
		
		return $transactionsPartialitiesCollection;
	}
	

}