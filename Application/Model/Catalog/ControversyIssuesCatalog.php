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
use Application\Model\Bean\ControversyIssues;
use Application\Model\Factory\ControversyIssuesFactory;
use Application\Model\Collection\ControversyIssuesCollection;
use Application\Model\Exception\ControversyIssuesException;
use Application\Model\Bean\Bean;
use Application\Query\ControversyIssuesQuery;
use Query\Query;

/**
 *
 * ControversyIssuesCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyIssues getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ControversyIssuesCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ControversyIssuesCatalog extends AbstractCatalog {


	/**
	 *
	 * Validate Query
	 * @param ControversyissuesQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof ControversyIssuesQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	
	public function create($controversyIssues)
	{
		$this->validateBean($controversyIssues);
		try
		{
			$data = $controversyIssues->toArrayFor(
					array('name', 'type', 'id_controversy_reason',)
					);
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(ControversyIssues::TABLENAME, $data);
			$controversyIssues->setIdReason($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The ControversyIssues can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para actualizar un ControversyIssues en la base de datos
	 * @param Channel $channel Objeto ControversyIssues
	 */
	public function update($controversyIssues)
	{
		$this->validateBean($controversyIssues);
		try
		{
			$data = $controversyIssues->toArrayFor(
					array('name', 'type', 'id_controversy_reason',)
					);
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(ControversyIssues::TABLENAME, $data, "id_controversy_issue = '{$controversyIssues->getIdControversyIssue()}'");
		}
		catch(\Exception $e)
		{
			$this->throwException("The ControlversyIssues can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un Channel a partir de su Id
	 * @param int $idChannel
	 */
	public function deleteById($idControversyIssues)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id_controversy_issue = ?', $idControversyIssues));
			$this->getDb()->delete(ControversyIssues::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The ControversyIssues can't be deleted\n", $e);
		}
	}
	
	
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\ChannelCollection
	 */
	protected function makeCollection(){
		return new ControversyIssuesCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\Channel
	 */
	protected function makeBean($resultset){
		return ControversyIssuesFactory::createFromArray($resultset);
	}
	
	
	/**
	 *
	 * Validate Channel
	 * @param Channel $channel
	 * @throws Exception
	 */
	protected function validateBean($controversyIssues = null){
		if( !($controversyIssues instanceof ControversyIssues) ){
			$this->throwException("passed parameter isn't a ControversyIssues instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new ControversyIssuesException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new ControversyIssuesException($message);
		}
	}
	
 }