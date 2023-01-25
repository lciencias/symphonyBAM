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
use Application\Model\Bean\TicketsClientsReopen;
use Application\Model\Bean\TicketsClientsTransactions;
use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Collection\TicketsClientsReopenCollection;
use Application\Model\Exception\TicketsClientsReopenException;
use Application\Model\Factory\TicketsClientsReopenFactory;
use Query\Query;

/**
 *
 * TicketsClientsReopenCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\TicketsClientsReopen getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketsClientsReopenCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketsClientsReopenCatalog extends AbstractCatalog {


	/**
	 * Metodo para agregar un TicketsClientsReopen a la base de datos
	 * @param TicketClient TicketsClientsReopen Objeto TicketClient
	 */
	
	public function save($ticketsClientsReopen){
		$this->validateBean($ticketsClientsReopen);
	}
	
	public function create($ticketsClientsReopen)
	{
		$this->validateBean($ticketsClientsReopen);
		try
		{
			$data = $ticketsClientsReopen->toArrayFor(array('id_ticket_client', 'id_ticket_client_transaction', 'amount', 'good_faith_payment', 'good_faith_date', 'good_faith_amount', 'good_faith_request',));
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(TicketsClientsReopen::TABLENAME, $data);
			$ticketsClientsReopen->setId($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsReopen can't be saved \n", $e);
		}
	}

	
	/**
	 * Metodo para actualizar un TicketsClientsReopen en la base de datos
	 * @param TicketsClientsTransactions $ticketsClientsReopen Objeto TicketsClientsReopen
	 */
	public function update($ticketsClientsReopen)
	{
		$this->validateBean($ticketsClientsReopen);
		try
		{
			$data = $ticketsClientsReopen->toArrayFor(array('id_ticket_client', 'id_ticket_client_transaction','amount', 'good_faith_payment', 'good_faith_date', 'good_faith_amount', 'good_faith_request',));			
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(TicketsClientsReopen::TABLENAME, $data, "id = '{$ticketsClientsReopen->getId()}'");			
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsReopen can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un TicketsClientsReopen a partir de su Id
	 * @param int $idTicketsClientsReopen
	 */
	public function deleteById($idTicketsClientsReopen)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id = ?', $idTicketsClientsReopen));
			$this->getDb()->delete(TicketsClientsReopen::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The TicketsClientsReopen can't be deleted\n", $e);
		}
	}
	
	
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\TicketsClientsReopenCollection
	 */
	protected function makeCollection(){
		return new TicketsClientsReopenCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\TicketsClientsReopen
	 */
	protected function makeBean($resultset){
		return TicketsClientsReopenFactory::createFromArray($resultset);
	}
	
	/**
	 *
	 * Validate Query
	 * @param TicketClientQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof TicketsClientsReopenQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	/**
	 *
	 * Validate TicketClient
	 * @param TicketClient $ticketClient
	 * @throws Exception
	 */
	protected function validateBean($ticketsClientsReopen = null){
		if( !($ticketsClientsReopen instanceof TicketsClientsReopen) ){
			$this->throwException("passed parameter isn't a TicketsClientsReopen instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new TicketsClientsReopenException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new TicketsClientsReopenException($message);
		}
	}
 }