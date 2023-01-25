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
use Application\Model\Metadata\ControversyReasonsMetadata;
use Application\Model\Bean\ControversyReasons;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;

/**
 * Application\Query\ControversyReasonsQuery
 *
 * @method \Application\Query\ControversyReasonsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ControversyReasonsQuery useMemoryCache()
 * @method \Application\Query\ControversyReasonsQuery useFileCache()
 * @method \Application\Model\Collection\ControversyReasonsCollection find()
 * @method \Application\Model\Bean\ControversyReasons findOne()
 * @method \Application\Model\Bean\ControversyReasons findOneOrElse() findOneOrElse(ControversyReasons $alternative)
 * @method \Application\Model\Bean\ControversyReasons findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ControversyReasons findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ControversyReasons findByPKOrElse() findByPKOrElse($pk, ControversyReasons $alternative)
 * @method \Application\Model\Bean\ControversyReasons findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ControversyReasonsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery removeJoins()
 * @method \Application\Query\ControversyReasonsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ControversyReasonsQuery from() from($table, $alias = null)
 * @method \Application\Query\ControversyReasonsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ControversyReasonsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ControversyReasonsQuery bind() bind($parameters)
 * @method \Application\Query\ControversyReasonsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ControversyReasonsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ControversyReasonsQuery setLimit() setLimit($limit)
 * @method \Application\Query\ControversyReasonsQuery setOffset() setOffset($offset)
 * @method \Application\Query\ControversyReasonsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ControversyReasonsQuery distinct()
 * @method \Application\Query\ControversyReasonsQuery select()
 * @method \Application\Query\ControversyReasonsQuery pk() pk($id)
 * @method \Application\Query\ControversyReasonsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ControversyReasonsQuery addColumns() addColumns($columns)
 * @method \Application\Query\ControversyReasonsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ControversyReasonsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ControversyReasonsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ControversyReasonsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ControversyReasonsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ControversyReasonsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ControversyReasonsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ControversyReasonsQuery extends BaseQuery{

	/**
	 *
	 * @return \Application\Model\Catalog\ChannelCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('ControversyReasonsCatalog');
	}
	
	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(ControversyReasons::TABLENAME, "controversy_reasons");
	
		$defaultColumn = array("controversy_reasons.*");
		$this->setDefaultColumn($defaultColumn);
		$this->setStorage(StorageFactory::create('memory'));
	}
	
	/**
	 * @param mixed $value
	 * @return Application\Query\ChannelQuery
	 */
	public function pk($value){
		$this->filter(array(
				ControversyReasons::ID_CONTROVERSY_REASON => $value,
		));
		return $this;
	}
	
	/**
	 * @return array
	 */
	public function fetchIds(){
		$this->removeColumn()->addColumn(ControversyReasons::ID_CONTROVERSY_REASON, 'ids');
		return $this->fetchCol();
	}
	
	/**
	 * build fromArray
	 * @param array $fields
	 * @param string $prefix
	 * @return Application\Query\ChannelQuery
	 */
	public function filter($fields, $prefix = 'controversy_reasons'){
		$this->build($this, $fields, $prefix);
		return $this;
	}
	
	/**
	 * build fromArray
	 * @param Query $query
	 * @param array $fields
	 * @param string $prefix
	 */
	public static function build(Query $query, $fields, $prefix = 'controversy_reasons')
	{
	
		$criteria = $query->where();
		$criteria->prefix($prefix);
	
		if( isset($fields['id_controversy_reason']) && !empty($fields['id_controversy_reason']) ){
			$criteria->add(ControversyReasons::ID_CONTROVERSY_REASON, $fields['id_controversy_reason']);
		}
		if( isset($fields['name']) && !empty($fields['name']) ){
			$criteria->add(ControversyReasons::NAME, $fields['name'],  ReasonsQuery::LIKE);
		}
		if( isset($fields['type']) && !empty($fields['type']) ){
			$criteria->add(ControversyReasons::TYPE, $fields['type']);
		}
		if( isset($fields['status']) && !empty($fields['status']) ){
			$criteria->add(ControversyReasons::STATUS, $fields['status']);
		}
		if( isset($fields['debit_time']) && !empty($fields['debit_time']) ){
			$criteria->add(ControversyReasons::DEBIT_TIME, $fields['debit_time']);
		}
		$criteria->endPrefix();
	}
	
    /**
     * @return \Application\Query\ControversyReasonsQuery
     */
    public function actives(){
        return $this->filter(array(
            ControversyReasons::STATUS => ControversyReasons::$Status['Active'],
        ));
    }
    
    /**
     * @return \Application\Query\ControversyReasonsQuery
     */
    public function inactives(){
        return $this->filter(array(
            ControversyReasons::STATUS => ControversyReasons::$Status['Inactive'],
        ));
    }
}