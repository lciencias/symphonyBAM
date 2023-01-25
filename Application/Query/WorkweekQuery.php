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

use Application\Storage\Storage;

use Query\Query;
use Application\Model\Catalog\WorkweekCatalog;
use Application\Model\Bean\Workweek;

use Application\Query\BaseQuery;

/**
 * Application\Query\WorkweekQuery
 *
 * @method \Application\Query\WorkweekQuery pk() pk(int $primaryKey)
 * @method \Application\Query\WorkweekQuery useMemoryCache()
 * @method \Application\Query\WorkweekQuery useFileCache()
 * @method \Application\Model\Collection\WorkweekCollection find()
 * @method \Application\Model\Bean\Workweek findOne()
 * @method \Application\Model\Bean\Workweek findOneOrElse() findOneOrElse(Workweek $alternative)
 * @method \Application\Model\Bean\Workweek findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Workweek findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Workweek findByPKOrElse() findByPKOrElse($pk, Workweek $alternative)
 * @method \Application\Model\Bean\Workweek findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\WorkweekQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\WorkweekQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\WorkweekQuery removeJoins()
 * @method \Application\Query\WorkweekQuery removeJoin() removeJoin($table)
 * @method \Application\Query\WorkweekQuery from() from($table, $alias = null)
 * @method \Application\Query\WorkweekQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\WorkweekQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\WorkweekQuery bind() bind($parameters)
 * @method \Application\Query\WorkweekQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\WorkweekQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\WorkweekQuery setLimit() setLimit($limit)
 * @method \Application\Query\WorkweekQuery setOffset() setOffset($offset)
 * @method \Application\Query\WorkweekQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\WorkweekQuery distinct()
 * @method \Application\Query\WorkweekQuery select()
 * @method \Application\Query\WorkweekQuery addColumns() addColumns($columns)
 * @method \Application\Query\WorkweekQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\WorkweekQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\WorkweekQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\WorkweekQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\WorkweekQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\WorkweekQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\WorkweekQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class WorkweekQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\WorkweekCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('WorkweekCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Workweek::TABLENAME, "Workweek");

        $defaultColumn = array("Workweek.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\WorkweekQuery
     */
    public function pk($value){
        $this->filter(array(
            Workweek::ID_WORKWEEK => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Workweek::ID_WORKWEEK, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\WorkweekQuery
     */
    public function filter($fields, $prefix = 'Workweek'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Workweek')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_workweek']) && !empty($fields['id_workweek']) ){
            $criteria->add(Workweek::ID_WORKWEEK, $fields['id_workweek']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Workweek::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Workweek::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\WorkweekQuery
     */
    public function actives(){
        return $this->filter(array(
            Workweek::STATUS => Workweek::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\WorkweekQuery
     */
    public function inactives(){
        return $this->filter(array(
            Workweek::STATUS => Workweek::$Status['Inactive'],
        ));
    }

}