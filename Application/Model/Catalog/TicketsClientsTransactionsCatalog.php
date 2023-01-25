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
use Application\Model\Bean\TicketsClientsTransactions;
use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Collection\TicketsClientsTransactionsCollection;
use Application\Model\Exception\TicketsClientsTransactionsException;
use Application\Model\Factory\TicketsClientsTransactionsFactory;
use Application\Query\TicketsClientsTransactionsQuery;
use Query\Query;

/**
 *
 * TicketsClientsTransactionsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TicketsClientsTransactions getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketsClientsTransactionsCatalog extends AbstractCatalog {


	/**
	 * Metodo para agregar un TicketsClientsTransactions a la base de datos
	 * @param TicketClient TicketsClientsTransactions Objeto TicketClient
	 */
	
	public function save($ticketsClientsTransactions){
		$this->validateBean($ticketsClientsTransactions);
		print_r($ticketsClientsTransactions); die("asas");
	}
	
	public function create($ticketsClientsTransactions)
	{
		$this->validateBean($ticketsClientsTransactions);
		try
		{
			$data = $ticketsClientsTransactions->toArrayFor(array('id_ticket_client', 'id_transaction_bam', 'transaction_date', 'amount', 'good_faith_payment', 'good_faith_date', 'good_faith_amount', 'id_controversy_chargeback', 'payment_request_date', 'payment_delivery_date', 'accepted_payment', 'delivered_payment', 'type', 'file_payment', 'file_delivery', 'good_faith_request', 'reference', 'afiliation', 'commerce', 'description', 'idT24',));
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(TicketsClientsTransactions::TABLENAME, $data);
			$ticketsClientsTransactions->setIdTicketClientTransaction($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsTransactions can't be saved \n", $e);
		}
	}

	
	/**
	 * Metodo para actualizar un TicketsClientsTransactions en la base de datos
	 * @param TicketsClientsTransactions $ticketsClientsTransactions Objeto TicketsClientsTransactions
	 */
	public function update($ticketsClientsTransactions)
	{
		$this->validateBean($ticketsClientsTransactions);
		try
		{
			$data = $ticketsClientsTransactions->toArrayFor(array('id_ticket_client', 'id_transaction_bam', 'transaction_date', 'amount', 'good_faith_payment', 'good_faith_date', 'good_faith_amount', 'id_controversy_chargeback', 'payment_request_date', 'payment_delivery_date', 'accepted_payment', 'delivered_payment', 'type', 'file_payment', 'file_delivery', 'good_faith_request', 'reference', 'afiliation', 'commerce', 'description', 'idT24',));			
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(TicketsClientsTransactions::TABLENAME, $data, "id_ticket_client_transaction = '{$ticketsClientsTransactions->getIdTicketClientTransaction()}'");			
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsTransactions can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un TicketsClientsTransactions a partir de su Id
	 * @param int $idTicketsClientsTransactions
	 */
	public function deleteById($idTicketsClientsTransactions)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id_ticket_client_transaction = ?', $idTicketsClientsTransactions));
			$this->getDb()->delete(TicketsClientsTransactions::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsTransactions can't be deleted\n", $e);
		}
	}
	
	
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\TicketsClientsTransactionsCollection
	 */
	protected function makeCollection(){
		return new TicketsClientsTransactionsCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\TicketsClientsTransactions
	 */
	protected function makeBean($resultset){
		return TicketsClientsTransactionsFactory::createFromArray($resultset);
	}
	
	/**
	 *
	 * Validate Query
	 * @param TicketClientQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof TicketsClientsTransactionsQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	/**
	 *
	 * Validate TicketClient
	 * @param TicketClient $ticketClient
	 * @throws Exception
	 */
	protected function validateBean($ticketsClientsTransactions = null){
		if( !($ticketsClientsTransactions instanceof TicketsClientsTransactions) ){
			$this->throwException("passed parameter isn't a TicketsClientsTransactions instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new TicketsClientsTransactionsException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new TicketsClientsTransactionsException($message);
		}
	}
 }