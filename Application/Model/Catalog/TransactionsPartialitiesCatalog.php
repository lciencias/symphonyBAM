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

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\TransactionsPartialities;
use Application\Model\Factory\TransactionsPartialitiesFactory;
use Application\Model\Collection\TransactionsPartialitiesCollection;
use Application\Model\Exception\TransactionsPartialitiesException;
use Application\Model\Bean\Bean;
use Application\Query\TransactionsPartialitiesQuery;
use Query\Query;

/**
 *
 * TransactionsPartialitiesCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TransactionsPartialities getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TransactionsPartialitiesCatalog extends AbstractCatalog {

	
	public function create($transactionsPartialities)
	{
		$this->validateBean($transactionsPartialities);
		try
		{
			$data = $transactionsPartialities->toArrayFor(array('id_ticket_client_transaction', 'voucher', 'amount', 'deposit_date', 'type', ));
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(TransactionsPartialities::TABLENAME, $data);
			$transactionsPartialities->setIdTicketClientTransactionPartiality($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The TransactionsPartialities can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para actualizar un Ticket en la base de datos
	 * @param Ticket $ticket Objeto Ticket
	 */
	public function update($transactionsPartialities)
	{
		$this->validateBean($transactionsPartialities);
		try
		{
			$data = $transactionsPartialities->toArrayFor(
					array('id_ticket_client_transaction', 'voucher', 'amount', 'deposit_date', 'type', )
					);
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(TransactionsPartialities::TABLENAME, $data, "id_ticket_client_transaction_partiality = '{$transactionsPartialities->getIdTicketClientTransactionPartiality()}'");
			parent::update($transactionsPartialities);
		}
		catch(\Exception $e)
		{
			$this->throwException("The TransactionsPartialities can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un Ticket a partir de su Id
	 * @param int $idTicket
	 */
	public function deleteById($idTransactionsPartialities)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id_ticket_client_transaction_partiality = ?', $idTransactionsPartialities));
			$this->getDb()->delete(TransactionsPartialities::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The TransactionsPartialities can't be deleted\n", $e);
		}
	}

	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\ChannelCollection
	 */
	protected function makeCollection(){
		return new TransactionsPartialitiesCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\TransactionsPartialities
	 */
	protected function makeBean($resultset){
		return TransactionsPartialitiesFactory::createFromArray($resultset);
	}
	
	/**
	 *
	 * Validate Query
	 * @param TransactionsPartialitiesQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof TransactionsPartialitiesQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	/**
	 *
	 * Validate TransactionsPartialities
	 * @param TransactionsPartialities $transactionsPartialities
	 * @throws Exception
	 */
	protected function validateBean($transactionsPartialities = null){
		if( !($transactionsPartialities instanceof TransactionsPartialities) ){
			$this->throwException("passed parameter isn't a TransactionsPartialities instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new TransactionsPartialitiesException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new TransactionsPartialitiesException($message);
		}
	}  
 }