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
use Application\Model\Metadata\ControversyChargebacksMetadata;
use Application\Model\Bean\ControversyChargebacks;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;

/**
 * Application\Query\ControversyChargebacksQuery
 *
 * @method \Application\Query\ControversyChargebacksQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ControversyChargebacksQuery useMemoryCache()
 * @method \Application\Query\ControversyChargebacksQuery useFileCache()
 * @method \Application\Model\Collection\ControversyChargebacksCollection find()
 * @method \Application\Model\Bean\ControversyChargebacks findOne()
 * @method \Application\Model\Bean\ControversyChargebacks findOneOrElse() findOneOrElse(ControversyChargebacks $alternative)
 * @method \Application\Model\Bean\ControversyChargebacks findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ControversyChargebacks findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ControversyChargebacks findByPKOrElse() findByPKOrElse($pk, ControversyChargebacks $alternative)
 * @method \Application\Model\Bean\ControversyChargebacks findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ControversyChargebacksQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery removeJoins()
 * @method \Application\Query\ControversyChargebacksQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ControversyChargebacksQuery from() from($table, $alias = null)
 * @method \Application\Query\ControversyChargebacksQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ControversyChargebacksQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ControversyChargebacksQuery bind() bind($parameters)
 * @method \Application\Query\ControversyChargebacksQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ControversyChargebacksQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ControversyChargebacksQuery setLimit() setLimit($limit)
 * @method \Application\Query\ControversyChargebacksQuery setOffset() setOffset($offset)
 * @method \Application\Query\ControversyChargebacksQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ControversyChargebacksQuery distinct()
 * @method \Application\Query\ControversyChargebacksQuery select()
 * @method \Application\Query\ControversyChargebacksQuery pk() pk($id)
 * @method \Application\Query\ControversyChargebacksQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ControversyChargebacksQuery addColumns() addColumns($columns)
 * @method \Application\Query\ControversyChargebacksQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ControversyChargebacksQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ControversyChargebacksQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ControversyChargebacksQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ControversyChargebacksQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ControversyChargebacksQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ControversyChargebacksQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ControversyChargebacksQuery extends BaseQuery{
    
     /**
     *
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ControversyChargebacksCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ControversyChargebacks::TABLENAME, "controversy_chargebacks");

        $defaultColumn = array("controversy_chargebacks.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelQuery
     */
    public function pk($value){
        $this->filter(array(
            ControversyChargebacks::ID_CONTROVERSY_CHARGEBACK => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ControversyChargebacks::ID_CONTROVERSY_CHARGEBACK, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelQuery
     */
    public function filter($fields, $prefix = 'controversy_chargebacks'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'controversy_chargebacks')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_controversy_chargeback']) && !empty($fields['id_controversy_chargeback']) ){
            $criteria->add(ControversyChargebacks::ID_CONTROVERSY_CHARGEBACK, $fields['id_controversy_chargeback']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(ControversyChargebacks::NAME, $fields['name'],  ReasonsQuery::LIKE);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(ControversyChargebacks::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
        	$criteria->add(ControversyChargebacks::STATUS, $fields['status']);
        }        
        if( isset($fields['id_controversy_reason']) && !empty($fields['id_controversy_reason']) ){
        	$criteria->add(ControversyChargebacks::ID_CONTROVERSY_REASON, $fields['id_controversy_reason']);
        }
        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ChannelQuery
     */
    public function actives(){
    	return $this->filter(array(
    			ControversyChargebacks::STATUS => ControversyChargebacks::$Status['Active'],
    	));
    }
    
    /**
     * @return \Application\Query\ChannelQuery
     */
    public function inactives(){
    	return $this->filter(array(
    			ControversyChargebacks::STATUS => ControversyChargebacks::$Status['Inactive'],
    	));
    }
}