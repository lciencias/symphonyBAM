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
use Application\Model\Bean\ControversyChargebacks;
use Application\Model\Factory\ControversyChargebacksFactory;
use Application\Model\Collection\ControversyChargebacksCollection;
use Application\Model\Exception\ControversyChargebacksException;
use Application\Model\Bean\Bean;
use Application\Query\ControversyChargebacksQuery;
use Query\Query;

/**
 *
 * ControversyChargebacksCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyChargebacks getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ControversyChargebacksCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ControversyChargebacksCatalog extends AbstractCatalog {
	
	public function create($controversyChargeback)
	{
		$this->validateBean($controversyChargeback);
		try
		{
			$data = $controversyChargeback->toArrayFor(
					array('name', 'type', 'status','id_controversy_reason',)
					);
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(ControversyChargebacks::TABLENAME, $data);
			$controversyChargeback->setIdReason($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The Reason can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para actualizar un Channel en la base de datos
	 * @param Channel $channel Objeto Channel
	 */
	public function update($controversyChargeback)
	{
		$this->validateBean($controversyChargeback);
		try
		{
			$data = $controversyChargeback->toArrayFor(
					array('name', 'type', 'status','id_controversy_reason',)
					);
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(ControversyChargebacks::TABLENAME, $data, "id_controversy_chargeback = '{$controversyChargeback->getIdControversyChargeback()}'");
		}
		catch(\Exception $e)
		{
			$this->throwException("The Reason can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un Channel a partir de su Id
	 * @param int $idChannel
	 */
	public function deleteById($idControversyChargeback)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id_controversy_chargeback = ?', $idControversyChargeback));
			$this->getDb()->delete(ControversyChargebacks::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The ControversyChargebacks can't be deleted\n", $e);
		}
	}
	
	
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\ChannelCollection
	 */
	protected function makeCollection(){
		return new ControversyChargebacksCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\Channel
	 */
	protected function makeBean($resultset){
		return ControversyChargebacksFactory::createFromArray($resultset);
	}
	
    /**
     *
     * Validate Query
     * @param ControversyChargebacksQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ControversyChargebacksQuery) ){
            $this->throwException("No es un Query valido");
        }
    }
	
	/**
	 *
	 * Validate Channel
	 * @param Channel $channel
	 * @throws Exception
	 */
	protected function validateBean($controversyChargebacks = null){
		if( !($controversyChargebacks instanceof ControversyChargebacks) ){
			$this->throwException("passed parameter isn't a ControversyChargebacks instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new ControversyChargebacksException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new ControversyChargebacksException($message);
		}
	}
 }