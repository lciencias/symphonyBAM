<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Catalog\CountryStateCatalog;
use Application\Model\Bean\CountryState;

use Application\Query\BaseQuery;

/**
 * Application\Query\CountryStateQuery
 *
 * @method \Application\Query\CountryStateQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CountryStateQuery useMemoryCache()
 * @method \Application\Query\CountryStateQuery useFileCache()
 * @method \Application\Model\Collection\CountryStateCollection find()
 * @method \Application\Model\Bean\CountryState findOne()
 * @method \Application\Model\Bean\CountryState findOneOrElse() findOneOrElse(CountryState $alternative)
 * @method \Application\Model\Bean\CountryState findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\CountryState findByPK() findByPK($pk)
 * @method \Application\Model\Bean\CountryState findByPKOrElse() findByPKOrElse($pk, CountryState $alternative)
 * @method \Application\Model\Bean\CountryState findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CountryStateQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CountryStateQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CountryStateQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CountryStateQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CountryStateQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CountryStateQuery removeJoins()
 * @method \Application\Query\CountryStateQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CountryStateQuery from() from($table, $alias = null)
 * @method \Application\Query\CountryStateQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CountryStateQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CountryStateQuery bind() bind($parameters)
 * @method \Application\Query\CountryStateQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CountryStateQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CountryStateQuery setLimit() setLimit($limit)
 * @method \Application\Query\CountryStateQuery setOffset() setOffset($offset)
 * @method \Application\Query\CountryStateQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CountryStateQuery distinct()
 * @method \Application\Query\CountryStateQuery select()
 * @method \Application\Query\CountryStateQuery addColumns() addColumns($columns)
 * @method \Application\Query\CountryStateQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CountryStateQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CountryStateQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CountryStateQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CountryStateQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CountryStateQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CountryStateQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CountryStateQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CountryStateCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CountryStateCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(CountryState::TABLENAME, "CountryState");

        $defaultColumn = array("CountryState.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\CountryStateQuery
     */
    public function pk($value){
        $this->filter(array(
            CountryState::ID_COUNTRY_STATE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(CountryState::ID_COUNTRY_STATE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CountryStateQuery
     */
    public function filter($fields, $prefix = 'CountryState'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'CountryState')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_country_state']) && !empty($fields['id_country_state']) ){
            $criteria->add(CountryState::ID_COUNTRY_STATE, $fields['id_country_state']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(CountryState::NAME, $fields['name']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(CountryState::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(CountryState::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }
    /**
     * 
     * @return \Application\Query\CountryStateQuery
     */
	public function actives(){
		$this->whereAdd(CountryState::STATUS, CountryState::$Statuses['Active']);
		return $this;
	}

}