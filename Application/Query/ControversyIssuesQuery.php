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
use Application\Model\Metadata\ControversyIssuesMetadata;
use Application\Model\Bean\ControversyIssues;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;

/**
 * Application\Query\ControversyIssuesQuery
 *
 * @method \Application\Query\ControversyIssuesQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ControversyIssuesQuery useMemoryCache()
 * @method \Application\Query\ControversyIssuesQuery useFileCache()
 * @method \Application\Model\Collection\ControversyIssuesCollection find()
 * @method \Application\Model\Bean\ControversyIssues findOne()
 * @method \Application\Model\Bean\ControversyIssues findOneOrElse() findOneOrElse(ControversyIssues $alternative)
 * @method \Application\Model\Bean\ControversyIssues findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ControversyIssues findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ControversyIssues findByPKOrElse() findByPKOrElse($pk, ControversyIssues $alternative)
 * @method \Application\Model\Bean\ControversyIssues findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ControversyIssuesQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery removeJoins()
 * @method \Application\Query\ControversyIssuesQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ControversyIssuesQuery from() from($table, $alias = null)
 * @method \Application\Query\ControversyIssuesQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ControversyIssuesQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ControversyIssuesQuery bind() bind($parameters)
 * @method \Application\Query\ControversyIssuesQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ControversyIssuesQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ControversyIssuesQuery setLimit() setLimit($limit)
 * @method \Application\Query\ControversyIssuesQuery setOffset() setOffset($offset)
 * @method \Application\Query\ControversyIssuesQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ControversyIssuesQuery distinct()
 * @method \Application\Query\ControversyIssuesQuery select()
 * @method \Application\Query\ControversyIssuesQuery pk() pk($id)
 * @method \Application\Query\ControversyIssuesQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ControversyIssuesQuery addColumns() addColumns($columns)
 * @method \Application\Query\ControversyIssuesQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ControversyIssuesQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ControversyIssuesQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ControversyIssuesQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ControversyIssuesQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ControversyIssuesQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ControversyIssuesQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ControversyIssuesQuery extends BaseQuery{


	/**
	 *
	 * @return \Application\Model\Catalog\ControversyIssues
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('ControversyIssuesCatalog');
	}
	
	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(ControversyIssues::TABLENAME, "controversy_issues");
	
		$defaultColumn = array("controversy_issues.*");
		$this->setDefaultColumn($defaultColumn);
		$this->setStorage(StorageFactory::create('memory'));
	}
	
	/**
	 * @param mixed $value
	 * @return Application\Query\ControversyIssuesQuery
	 */
	public function pk($value){
		$this->filter(array(
				ControversyIssues::ID_CONTROVERSY_ISSUE => $value,
		));
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function fetchIds(){
		$this->removeColumn()->addColumn(ControversyIssues::ID_CONTROVERSY_ISSUE, 'ids');
		return $this->fetchCol();
	}
	
	/**
	 * build fromArray
	 * @param array $fields
	 * @param string $prefix
	 * @return Application\Query\ControversyIssuesQuery
	 */
	public function filter($fields, $prefix = 'controversy_issues'){
		$this->build($this, $fields, $prefix);
		return $this;
	}
	
	/**
	 * build fromArray
	 * @param Query $query
	 * @param array $fields
	 * @param string $prefix
	 */
	public static function build(Query $query, $fields, $prefix = 'controversy_issues')
	{
	
		$criteria = $query->where();
		$criteria->prefix($prefix);
	
		if( isset($fields['id_controversy_issue']) && !empty($fields['id_controversy_issue']) ){
			$criteria->add(ControversyIssues::ID_CONTROVERSY_ISSUE, $fields['id_controversy_issue']);
		}
		if( isset($fields['name']) && !empty($fields['name']) ){
			$criteria->add(ControversyIssues::NAME, $fields['name'],  ReasonsQuery::LIKE);
		}
		if( isset($fields['type']) && !empty($fields['type']) ){
			$criteria->add(ControversyIssues::TYPE, $fields['type']);
		}
		if( isset($fields['id_controversy_reason']) && !empty($fields['id_controversy_reason']) ){
			$criteria->add(ControversyIssues::ID_CONTROVERSY_REASON, $fields['id_controversy_reason']);
		}
		
		$criteria->endPrefix();
	}
	
	/**
	 * @return \Application\Query\ControversyIssuesQuery
	 */
	public function actives(){
		return $this->filter(array(
				ControversyIssues::STATUS => ControversyIssues::$Status['Active'],
		));
	}
	
	/**
	 * @return \Application\Query\ControversyIssuesQuery
	 */
	public function inactives(){
		return $this->filter(array(
				ControversyIssues::STATUS => ControversyIssues::$Status['Inactive'],
		));
	}

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ControversyIssuesQuery
     */
    public function innerJoinControversyReasons($alias = 'ControversyIssues', $aliasForeignTable = 'ControversyReasons')
    {
        $this->innerJoinOn(\Application\Model\Bean\ControversyReasons::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_controversy_reason'), array($aliasForeignTable, 'id_controversy_reason'));

        return $this;
    }


}