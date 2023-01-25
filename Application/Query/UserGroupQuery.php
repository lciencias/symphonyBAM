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
use Application\Model\Metadata\UserGroupMetadata;
use Application\Model\Bean\UserGroup;

use Application\Query\BaseQuery;

/**
 * Application\Query\UserGroupQuery
 *
 * @method \Application\Query\UserGroupQuery pk() pk(int $primaryKey)
 * @method \Application\Query\UserGroupQuery useMemoryCache()
 * @method \Application\Query\UserGroupQuery useFileCache()
 * @method \Application\Model\Collection\UserGroupCollection find()
 * @method \Application\Model\Bean\UserGroup findOne()
 * @method \Application\Model\Bean\UserGroup findOneOrElse() findOneOrElse(UserGroup $alternative)
 * @method \Application\Model\Bean\UserGroup findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\UserGroup findByPK() findByPK($pk)
 * @method \Application\Model\Bean\UserGroup findByPKOrElse() findByPKOrElse($pk, UserGroup $alternative)
 * @method \Application\Model\Bean\UserGroup findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\UserGroupQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\UserGroupQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\UserGroupQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\UserGroupQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\UserGroupQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\UserGroupQuery removeJoins()
 * @method \Application\Query\UserGroupQuery removeJoin() removeJoin($table)
 * @method \Application\Query\UserGroupQuery from() from($table, $alias = null)
 * @method \Application\Query\UserGroupQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\UserGroupQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\UserGroupQuery bind() bind($parameters)
 * @method \Application\Query\UserGroupQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\UserGroupQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\UserGroupQuery setLimit() setLimit($limit)
 * @method \Application\Query\UserGroupQuery setOffset() setOffset($offset)
 * @method \Application\Query\UserGroupQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\UserGroupQuery distinct()
 * @method \Application\Query\UserGroupQuery select()
 * @method \Application\Query\UserGroupQuery pk() pk($id)
 * @method \Application\Query\UserGroupQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\UserGroupQuery addColumns() addColumns($columns)
 * @method \Application\Query\UserGroupQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\UserGroupQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\UserGroupQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\UserGroupQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\UserGroupQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\UserGroupQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\UserGroupQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class UserGroupQuery extends BaseQuery{

	/**
	 *
	 * @return \Application\Model\Catalog\UserLogCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('UserGroupCatalog');
	}
	
	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(UserGroup::TABLENAME, "UserGroup");
	
		$defaultColumn = array("UserGroup.*");
		$this->setDefaultColumn($defaultColumn);
	}
	
	
	/**
	 * build fromArray
	 * @param array $fields
	 * @param string $prefix
	 * @return Application\Query\UserLogQuery
	 */
	public function filter($fields, $prefix = 'UserGroup'){
		$this->build($this, $fields, $prefix);
		return $this;
	}
	
	/**
	 * @param mixed $value
	 * @return Application\Query\UserGroupQuery
	 */
	public function pk($value){
		$this->filter(array(
				UserGroup::ID_USER => $value,
		));
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function fetchIds(){
		$this->removeColumn()->addColumn(UserGroup::ID_USER, 'ids');
		return $this->fetchCol();
	}
	
	/**
	 * build fromArray
	 * @param Query $query
	 * @param array $fields
	 * @param string $prefix
	 */
	public static function build(Query $query, $fields, $prefix = 'UserGroup')
	{
	
		$criteria = $query->where();
		$criteria->prefix($prefix);
	
		if( isset($fields['id_group']) && !empty($fields['id_group']) ){
			$criteria->add(UserGroup::ID_GROUP, $fields['id_group']);
		}
		if( isset($fields['id_user']) && !empty($fields['id_user']) ){
			$criteria->add(UserGroup::ID_USER, $fields['id_user']);
		}
		$criteria->endPrefix();
	}
}