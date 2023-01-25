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

namespace Application\Query;

use Query\Query;
use Application\Model\Metadata\ClientCategoriesProductsMetadata;
use Application\Model\Bean\ClientCategoriesProducts;

use Application\Query\BaseQuery;
use Application\Model\Bean\ClientCategory;
use Application\Model\Bean\Products;

/**
 * Application\Query\ClientCategoriesProductsQuery
 *
 * @method \Application\Query\ClientCategoriesProductsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientCategoriesProductsQuery useMemoryCache()
 * @method \Application\Query\ClientCategoriesProductsQuery useFileCache()
 * @method \Application\Model\Collection\ClientCategoriesProductsCollection find()
 * @method \Application\Model\Bean\ClientCategoriesProducts findOne()
 * @method \Application\Model\Bean\ClientCategoriesProducts findOneOrElse() findOneOrElse(ClientCategoriesProducts $alternative)
 * @method \Application\Model\Bean\ClientCategoriesProducts findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientCategoriesProducts findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientCategoriesProducts findByPKOrElse() findByPKOrElse($pk, ClientCategoriesProducts $alternative)
 * @method \Application\Model\Bean\ClientCategoriesProducts findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientCategoriesProductsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery removeJoins()
 * @method \Application\Query\ClientCategoriesProductsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientCategoriesProductsQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientCategoriesProductsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientCategoriesProductsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientCategoriesProductsQuery bind() bind($parameters)
 * @method \Application\Query\ClientCategoriesProductsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientCategoriesProductsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientCategoriesProductsQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientCategoriesProductsQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientCategoriesProductsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientCategoriesProductsQuery distinct()
 * @method \Application\Query\ClientCategoriesProductsQuery select()
 * @method \Application\Query\ClientCategoriesProductsQuery pk() pk($id)
 * @method \Application\Query\ClientCategoriesProductsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ClientCategoriesProductsQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientCategoriesProductsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientCategoriesProductsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientCategoriesProductsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientCategoriesProductsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientCategoriesProductsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientCategoriesProductsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientCategoriesProductsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientCategoriesProductsQuery extends BaseQuery{

	/**
	 *
	 * @return \Application\Model\Catalog\ClientCategoryCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('ClientCategoriesProductsCatalog');
	}
	
	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(ClientCategoriesProducts::TABLENAME, "ClientCategoriesProducts");	
		$defaultColumn = array("ClientCategoriesProducts.*");
		$this->setDefaultColumn($defaultColumn);
	}
	
	/**
	 * @param mixed $value
	 * @return Application\Query\ClientCategoriesProductsQuery
	 */
	public function pk($value){
		$this->filter(array(
				ClientCategoriesProducts::ID_CLIENT_CATEGORY_PRODUCT => $value,
		));
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function fetchIds(){
		$this->removeColumn()->addColumn(ClientCategoriesProducts::ID_CLIENT_CATEGORY_PRODUCT, 'ids');
		return $this->fetchCol();
	}
	
	/**
	 * build fromArray
	 * @param array $fields
	 * @param string $prefix
	 * @return Application\Query\ClientCategoriesProductsQuery
	 */
	public function filter($fields, $prefix = 'ClientCategoriesProducts'){
		$this->build($this, $fields, $prefix);
		return $this;
	}
	
	/**
	 * build fromArray
	 * @param Query $query
	 * @param array $fields
	 * @param string $prefix
	 */
	public static function build(Query $query, $fields, $prefix = 'ClientCategoriesProducts')
	{	
		$criteria = $query->where();
		$criteria->prefix($prefix);
	
		if( isset($fields['id_client_category_product']) && !empty($fields['id_client_category_product']) ){
			$criteria->add(ClientCategoriesProducts::ID_CLIENT_CATEGORY_PRODUCT, $fields['id_client_category_product']);
		}
		if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
			$criteria->add(ClientCategoriesProducts::ID_CLIENT_CATEGORY, $fields['id_client_category']);
		}
		if( isset($fields['id_product']) && !empty($fields['id_product']) ){
			$criteria->add(ClientCategoriesProducts::ID_PRODUCT, $fields['id_product']);
		}
		$criteria->endPrefix();
	}
	
	/**
	 * @param string $alias
	 * @param string aliasForeignTable
	 * @return Application\Query\ClientCategoriesProductsQuery
	 */
	public function innerJoinCategories($alias = 'ClientCategoriesProducts', $aliasForeignTable = 'ClientCategory')
	{
		$this->innerJoinOn(ClientCategory::TABLENAME, $aliasForeignTable)
		->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));
	
		return $this;
	}
	
	/**
	 * @param string $alias
	 * @param string aliasForeignTable
	 * @return Application\Query\ClientCategoriesProductsQuery
	 */
	public function innerJoinProducts($alias = 'ClientCategoriesProducts', $aliasForeignTable = 'Products')
	{
		$this->innerJoinOn(Products::TABLENAME, $aliasForeignTable)
		->equalFields(array($alias, 'id_product'), array($aliasForeignTable, 'id_product'));
	
		return $this;
	}
}