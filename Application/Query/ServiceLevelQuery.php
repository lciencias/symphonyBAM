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
use Application\Model\Catalog\ServiceLevelCatalog;
use Application\Model\Bean\ServiceLevel;

use Application\Query\BaseQuery;

/**
 * Application\Query\ServiceLevelQuery
 *
 * @method \Application\Query\ServiceLevelQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ServiceLevelQuery useMemoryCache()
 * @method \Application\Query\ServiceLevelQuery useFileCache()
 * @method \Application\Model\Collection\ServiceLevelCollection find()
 * @method \Application\Model\Bean\ServiceLevel findOne()
 * @method \Application\Model\Bean\ServiceLevel findOneOrElse() findOneOrElse(ServiceLevel $alternative)
 * @method \Application\Model\Bean\ServiceLevel findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ServiceLevel findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ServiceLevel findByPKOrElse() findByPKOrElse($pk, ServiceLevel $alternative)
 * @method \Application\Model\Bean\ServiceLevel findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ServiceLevelQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ServiceLevelQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ServiceLevelQuery removeJoins()
 * @method \Application\Query\ServiceLevelQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ServiceLevelQuery from() from($table, $alias = null)
 * @method \Application\Query\ServiceLevelQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ServiceLevelQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ServiceLevelQuery bind() bind($parameters)
 * @method \Application\Query\ServiceLevelQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ServiceLevelQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ServiceLevelQuery setLimit() setLimit($limit)
 * @method \Application\Query\ServiceLevelQuery setOffset() setOffset($offset)
 * @method \Application\Query\ServiceLevelQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ServiceLevelQuery distinct()
 * @method \Application\Query\ServiceLevelQuery select()
 * @method \Application\Query\ServiceLevelQuery addColumns() addColumns($columns)
 * @method \Application\Query\ServiceLevelQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ServiceLevelQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ServiceLevelQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ServiceLevelQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ServiceLevelQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ServiceLevelQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ServiceLevelQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ServiceLevelQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ServiceLevelCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ServiceLevelCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ServiceLevel::TABLENAME, "ServiceLevel");

        $defaultColumn = array("ServiceLevel.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ServiceLevelQuery
     */
    public function pk($value){
        $this->filter(array(
            ServiceLevel::ID_SERVICE_LEVEL => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ServiceLevel::ID_SERVICE_LEVEL, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ServiceLevelQuery
     */
    public function filter($fields, $prefix = 'ServiceLevel'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ServiceLevel')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_service_level']) && !empty($fields['id_service_level']) ){
            $criteria->add(ServiceLevel::ID_SERVICE_LEVEL, $fields['id_service_level']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(ServiceLevel::NAME, $fields['name']);
        }
        if( isset($fields['resolution_time']) && !empty($fields['resolution_time']) ){
            $criteria->add(ServiceLevel::RESOLUTION_TIME, $fields['resolution_time']);
        }
        if( isset($fields['response_time']) && !empty($fields['response_time']) ){
            $criteria->add(ServiceLevel::RESPONSE_TIME, $fields['response_time']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ServiceLevel::NOTE, $fields['note']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(ServiceLevel::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ServiceLevelQuery
     */
    public function actives(){
        return $this->filter(array(
            ServiceLevel::STATUS => ServiceLevel::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\ServiceLevelQuery
     */
    public function inactives(){
        return $this->filter(array(
            ServiceLevel::STATUS => ServiceLevel::$Status['Inactive'],
        ));
    }


}