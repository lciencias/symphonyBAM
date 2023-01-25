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

use Application\Model\Bean\TicketsClientsReopen;

/**
 *
 * TicketsClientsReopenCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TicketsClientsReopen current()
 * @method \Application\Model\Bean\TicketsClientsReopen read()
 * @method \Application\Model\Bean\TicketsClientsReopen getOne()
 * @method \Application\Model\Bean\TicketsClientsReopen getOneOrElse() getOneOrElse(Application\Model\Bean\TicketsClientsTransactions $ticketsClientsTransactions)
 * @method \Application\Model\Bean\TicketsClientsReopen getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\TicketsClientsReopen getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\TicketsClientsTransactions $ticketsClientsTransactions)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection intersect() intersect(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection merge() merge(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection diff() diff(\Application\Model\Collection\TicketsClientsTransactionsCollection $collection)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection copy()
 */
class TicketsClientsReopenCollection extends Collection{

    /**
     *
     * @param TicketsClientsReopen $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TicketsClientsReopen) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TicketsClientsReopen");

        }
    }

    /**
     * convert to array
     * @return array
     */
    public function toArrayForList(){
		return $this->map(function(TicketsClientsReopen $ticketsClientsReopen){
			return array( $ticketsClientsReopen->getId() => $ticketsClientsReopen->getId() );
		});
    }
    

	/**
	 * Returns an array with ids the 
	 * @return array
	 */
	public function getIds()
	{
		return $this->map(function(TicketsClientsReopen $ticketsClientsReopen){
			return array( $ticketsClientsReopen->getId() => $ticketsClientsReopen->getId() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\TicketsClientsReopenCollection
     */
	public function getById($id)
	{
		$ticketsClientsReopenCollection = new TicketsClientsReopenCollection();
		$this->each(function(TicketsClientsReopen $ticketsClientsReopen) use ($id, $ticketsClientsReopenCollection){
			if( $ticketsClientsReopen->getId() == $id)
				$ticketsClientsReopenCollection->append($ticketsClientsReopen);
		});
		
		return $ticketsClientsReopenCollection;
	}
	

}