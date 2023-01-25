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
use Application\Model\Bean\ControversyReasons;
use Application\Model\Factory\ControversyReasonsFactory;
use Application\Model\Collection\ControversyReasonsCollection;
use Application\Model\Exception\ControversyReasonsException;
use Application\Model\Bean\Bean;
use Application\Query\ControversyReasonsQuery;
use Query\Query;
use Application\Model\Collection\ControversyChargebacksCollection;

/**
 *
 * ControversyReasonsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyReasons getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ControversyReasonsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ControversyReasonsCatalog extends AbstractCatalog {

	
    /**
     *
     * Validate Query
     * @param ControversyReasonsQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ControversyReasonsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }
    

    public function create($controversyReasons)
    {
    	$this->validateBean($controversyReasons);
    	try
    	{
    		$data = $controversyReasons->toArrayFor(
    				array('name', 'type', 'status','debit_time',)
    				);
    		$data = array_filter($data, array($this, 'isNotNull'));
    		$this->getDb()->insert(ControversyReasons::TABLENAME, $data);
    		$controversyReasons->setIdReason($this->getDb()->lastInsertId());
    	}
    	catch(\Exception $e)
    	{
    		$this->throwException("The ControversyReason can't be saved \n", $e);
    	}
    }
    
    /**
     * Metodo para actualizar un Channel en la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function update($controversyReasons)
    {
    	$this->validateBean($controversyReasons);
    	try
    	{
    		$data = $controversyReasons->toArrayFor(
    				array('name', 'type', 'status','debit_time',)
    				);
    		$data = array_filter($data, array($this, 'isNotNull'));
    		$this->getDb()->update(ControversyReasons::TABLENAME, $data, "id_controversy_reason = '{$controversyReasons->getIdControversyReasons()}'");
    	}
    	catch(\Exception $e)
    	{
    		$this->throwException("The ControlversyReason can't be saved \n", $e);
    	}
    }
    
    /**
     * Metodo para eliminar un Channel a partir de su Id
     * @param int $idChannel
     */
    public function deleteById($idControversyReasons)
    {
    	try
    	{
    		$where = array($this->getDb()->quoteInto('id_controversy_chargeback = ?', $idControversyReasons));
    		$this->getDb()->delete(ControversyReasons::TABLENAME, $where);
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
    	return new ControversyReasonsCollection();
    }
    
    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
    	return ControversyReasonsFactory::createFromArray($resultset);
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
    		throw new ControversyReasonsException("$message ". $exception->getMessage(), 500, $exception);
    	}else{
    		throw new ControversyReasonsException($message);
    	}
    }
    
 }