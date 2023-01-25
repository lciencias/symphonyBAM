<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Application\Storage\StorageFactory;

use Query\Query;
use Application\Model\Catalog\ImpactCatalog;
use Application\Model\Bean\Impact;

use Application\Query\BaseQuery;

/**
 * Application\Query\ImpactQuery
 *
 * @method \Application\Query\ImpactQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ImpactQuery useMemoryCache()
 * @method \Application\Query\ImpactQuery useFileCache()
 * @method \Application\Model\Collection\ImpactCollection find()
 * @method \Application\Model\Bean\Impact findOne()
 * @method \Application\Model\Bean\Impact findOneOrElse() findOneOrElse(Impact $alternative)
 * @method \Application\Model\Bean\Impact findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Impact findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Impact findByPKOrElse() findByPKOrElse($pk, Impact $alternative)
 * @method \Application\Model\Bean\Impact findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ImpactQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ImpactQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ImpactQuery removeJoins()
 * @method \Application\Query\ImpactQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ImpactQuery from() from($table, $alias = null)
 * @method \Application\Query\ImpactQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ImpactQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ImpactQuery bind() bind($parameters)
 * @method \Application\Query\ImpactQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ImpactQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ImpactQuery setLimit() setLimit($limit)
 * @method \Application\Query\ImpactQuery setOffset() setOffset($offset)
 * @method \Application\Query\ImpactQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ImpactQuery distinct()
 * @method \Application\Query\ImpactQuery select()
 * @method \Application\Query\ImpactQuery addColumns() addColumns($columns)
 * @method \Application\Query\ImpactQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ImpactQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ImpactQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ImpactQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ImpactQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ImpactQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ImpactQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ImpactQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ImpactCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ImpactCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Impact::TABLENAME, "Impact");

        $defaultColumn = array("Impact.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ImpactQuery
     */
    public function pk($value){
        $this->filter(array(
            Impact::ID_IMPACT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Impact::ID_IMPACT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ImpactQuery
     */
    public function filter($fields, $prefix = 'Impact'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Impact')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_impact']) && !empty($fields['id_impact']) ){
            $criteria->add(Impact::ID_IMPACT, $fields['id_impact']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Impact::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Impact::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ImpactQuery
     */
    public function actives(){
        return $this->filter(array(
            Impact::STATUS => Impact::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\ImpactQuery
     */
    public function inactives(){
        return $this->filter(array(
            Impact::STATUS => Impact::$Status['Inactive'],
        ));
    }


}