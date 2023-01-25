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

namespace Application\Model\Catalog;

use Application\Model\Bean\Bean;
use Application\Model\Bean\Transactions;
use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Collection\TransactionsCollection;
use Application\Model\Factory\TransactionsFactory;

/**
 *
 * TransactionsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Transactions getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TransactionsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TransactionsCatalog extends AbstractCatalog {


	protected function validate($collectable)
	{
		if( !($collectable instanceof Transactions) ){
			throw new \InvalidArgumentException("Debe de ser un objecto Transactions");
		}
	}
	/**
	 * convert to array
	 * @return array
	 */
	public function toArrayForList(){
		return $this->map(function(Transactions $transaction){
			return array($transaction->getIdTransaction() => $transaction->toArrayForList());
		});
	}
	

	protected function makeCollection(){
		return new TransactionsCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\TicketClient
	 */
	protected function makeBean($resultset){
		return TransactionsFactory::createFromArray($resultset);
	}
	
	
    /**
     *
     * Validate Query
     * @param TransactionsQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TransactionsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }
    

 }