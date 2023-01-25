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

use Application\Model\Bean\TicketsClientsTransactions;

/**
 *
 * TicketsClientsTransactionsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TicketsClientsTransactions current()
 * @method \Application\Model\Bean\TicketsClientsTransactions read()
 * @method \Application\Model\Bean\TicketsClientsTransactions getOne()
 * @method \Application\Model\Bean\TicketsClientsTransactions getOneOrElse() getOneOrElse(Application\Model\Bean\TicketsClientsTransactions $ticketsClientsTransactions)
 * @method \Application\Model\Bean\TicketsClientsTransactions getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\TicketsClientsTransactions getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\TicketsClientsTransactions $ticketsClientsTransactions)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection intersect() intersect(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection merge() merge(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection diff() diff(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection copy()
 */
class TicketsClientsTransactionsCollection extends Collection{

    /**
     *
     * @param TicketsClientsTransactions $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketsClientsTransactions) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketsClientsTransactions");
        }
    }

    /**
     * convert to array
     * @return array
     */
    public function toArrayForList(){
		return $this->map(function(TicketsClientsTransactions $ticketsClientsTransactions){
			return array( $ticketsClientsTransactions->getId() => $ticketsClientsTransactions->getId() );
		});
    }
    

	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(TicketsClientsTransactions $ticketsClientsTransactions){
			return array( $ticketsClientsTransactions->getId() => $ticketsClientsTransactions->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\TicketsClientsTransactionsCollection
     */
	public function getById($id)
	{
		$ticketsClientsTransactionsCollection = new TicketsClientsTransactionsCollection();
		$this->each(function(TicketsClientsTransactions $ticketsClientsTransactions) use ($id, $ticketsClientsTransactionsCollection){
			if( $ticketsClientsTransactions->getId() == $id)
				$ticketsClientsTransactionsCollection->append($ticketsClientsTransactions);
		});
		
		return $ticketsClientsTransactionsCollection;
	}
	

}