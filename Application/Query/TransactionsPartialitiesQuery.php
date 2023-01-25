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
use Application\Model\Metadata\TransactionsPartialitiesMetadata;
use Application\Model\Bean\TransactionsPartialities;

use Application\Query\BaseQuery;

/**
 * Application\Query\TransactionsPartialitiesQuery
 *
 * @method \Application\Query\TransactionsPartialitiesQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TransactionsPartialitiesQuery useMemoryCache()
 * @method \Application\Query\TransactionsPartialitiesQuery useFileCache()
 * @method \Application\Model\Collection\TransactionsPartialitiesCollection find()
 * @method \Application\Model\Bean\TransactionsPartialities findOne()
 * @method \Application\Model\Bean\TransactionsPartialities findOneOrElse() findOneOrElse(TransactionsPartialities $alternative)
 * @method \Application\Model\Bean\TransactionsPartialities findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TransactionsPartialities findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TransactionsPartialities findByPKOrElse() findByPKOrElse($pk, TransactionsPartialities $alternative)
 * @method \Application\Model\Bean\TransactionsPartialities findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TransactionsPartialitiesQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery removeJoins()
 * @method \Application\Query\TransactionsPartialitiesQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TransactionsPartialitiesQuery from() from($table, $alias = null)
 * @method \Application\Query\TransactionsPartialitiesQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TransactionsPartialitiesQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TransactionsPartialitiesQuery bind() bind($parameters)
 * @method \Application\Query\TransactionsPartialitiesQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TransactionsPartialitiesQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TransactionsPartialitiesQuery setLimit() setLimit($limit)
 * @method \Application\Query\TransactionsPartialitiesQuery setOffset() setOffset($offset)
 * @method \Application\Query\TransactionsPartialitiesQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TransactionsPartialitiesQuery distinct()
 * @method \Application\Query\TransactionsPartialitiesQuery select()
 * @method \Application\Query\TransactionsPartialitiesQuery pk() pk($id)
 * @method \Application\Query\TransactionsPartialitiesQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\TransactionsPartialitiesQuery addColumns() addColumns($columns)
 * @method \Application\Query\TransactionsPartialitiesQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TransactionsPartialitiesQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TransactionsPartialitiesQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TransactionsPartialitiesQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TransactionsPartialitiesQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TransactionsPartialitiesQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TransactionsPartialitiesQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TransactionsPartialitiesQuery extends BaseQuery{


	/**
	 *
	 * @return \Application\Model\Catalog\TransactionsPartialitiesCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('TransactionsPartialitiesCatalog');
	}
	
	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(TransactionsPartialities::TABLENAME, "TransactionsPartialities");
		$defaultColumn = array("TransactionsPartialities.*");
		$this->setDefaultColumn($defaultColumn);
	}
}