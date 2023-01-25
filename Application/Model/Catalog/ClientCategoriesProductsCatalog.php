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
use Application\Model\Bean\ClientCategoriesProducts;
use Application\Model\Factory\ClientCategoriesProductsFactory;
use Application\Model\Collection\ClientCategoriesProductsCollection;
use Application\Model\Exception\ClientCategoriesProductsException;
use Application\Model\Bean\Bean;
use Application\Query\ClientCategoriesProductsQuery;
use Query\Query;

/**
 *
 * ClientCategoriesProductsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ClientCategoriesProducts getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientCategoriesProductsCatalog extends AbstractCatalog {

	/**
	 * Metodo para agregar un ClientCategoriesProducts a la base de datos
	 * @param ClientCategory $clientCategoriesProducts Objeto ClientCategoriesProducts
	 */
	public function create($clientCategoriesProducts)
	{
		$this->validateBean($clientCategoriesProducts);
		try
		{
			$data = $clientCategoriesProducts->toArrayFor(array('id_client_category_product', 'id_client_category', 'id_product'));
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->insert(ClientCategoriesProducts::TABLENAME, $data);
			$clientCategoriesProducts->setIdClientCategory($this->getDb()->lastInsertId());
		}
		catch(\Exception $e)
		{
			$this->throwException("The ClientCategoriesProducts can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para actualizar un ClientCategoriesProducts en la base de datos
	 * @param ClientCategory $clientCategoriesProducts Objeto ClientCategory
	 */
	public function update($clientCategoriesProducts)
	{
		$this->validateBean($clientCategoriesProducts);
		try
		{
			$data = $clientCategoriesProducts->toArrayFor(array('id_client_category_product', 'id_client_category', 'id_product'));			
			$data = array_filter($data, array($this, 'isNotNull'));
			$this->getDb()->update(ClientCategoriesProducts::TABLENAME, $data, "id_client_category = '{$clientCategory->getIdClientCategory()}'");
		}
		catch(\Exception $e)
		{
			$this->throwException("The ClientCategoriesProducts can't be saved \n", $e);
		}
	}
	
	/**
	 * Metodo para eliminar un ClientCategoriesProducts a partir de su Id
	 * @param int $idClientCategory
	 */
	public function deleteById($idClientCategoriesProducts)
	{
		try
		{
			$where = array($this->getDb()->quoteInto('id_client_category_product = ?', $idClientCategoriesProducts));
			$this->getDb()->delete(ClientCategoriesProducts::TABLENAME, $where);
		}
		catch(\Exception $e)
		{
			$this->throwException("The ClientCategoriesProducts can't be deleted\n", $e);
		}
	}
	
	
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\ClientCategoriesProductsCollection
	 */
	protected function makeCollection(){
		return new ClientCategoriesProductsCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\ClientCategoriesProducts
	 */
	protected function makeBean($resultset){
		return ClientCategoriesProductsFactory::createFromArray($resultset);
	}
	
	/**
	 *
	 * Validate Query
	 * @param ClientCategoriesProductsQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof ClientCategoriesProductsQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	/**
	 *
	 * Validate ClientCategoriesProducts
	 * @param ClientCategoriesProducts $clientCategoriesProducts
	 * @throws Exception
	 */
	protected function validateBean($clientCategory = null){
		if( !($clientCategory instanceof ClientCategoriesProducts) ){
			$this->throwException("passed parameter isn't a ClientCategoriesProducts instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new ClientCategoriesProductsException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new ClientCategoriesProductsException($message);
		}
	}	
 }