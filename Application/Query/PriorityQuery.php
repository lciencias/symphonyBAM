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
use Application\Model\Catalog\PriorityCatalog;
use Application\Model\Bean\Priority;

use Application\Query\BaseQuery;

/**
 * Application\Query\PriorityQuery
 *
 * @method \Application\Query\PriorityQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PriorityQuery useMemoryCache()
 * @method \Application\Query\PriorityQuery useFileCache()
 * @method \Application\Model\Collection\PriorityCollection find()
 * @method \Application\Model\Bean\Priority findOne()
 * @method \Application\Model\Bean\Priority findOneOrElse() findOneOrElse(Priority $alternative)
 * @method \Application\Model\Bean\Priority findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Priority findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Priority findByPKOrElse() findByPKOrElse($pk, Priority $alternative)
 * @method \Application\Model\Bean\Priority findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PriorityQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PriorityQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PriorityQuery removeJoins()
 * @method \Application\Query\PriorityQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PriorityQuery from() from($table, $alias = null)
 * @method \Application\Query\PriorityQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PriorityQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PriorityQuery bind() bind($parameters)
 * @method \Application\Query\PriorityQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PriorityQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PriorityQuery setLimit() setLimit($limit)
 * @method \Application\Query\PriorityQuery setOffset() setOffset($offset)
 * @method \Application\Query\PriorityQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PriorityQuery distinct()
 * @method \Application\Query\PriorityQuery select()
 * @method \Application\Query\PriorityQuery addColumns() addColumns($columns)
 * @method \Application\Query\PriorityQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PriorityQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PriorityQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PriorityQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PriorityQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PriorityQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PriorityQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PriorityQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PriorityCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PriorityCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Priority::TABLENAME, "Priority");

        $defaultColumn = array("Priority.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\PriorityQuery
     */
    public function pk($value){
        $this->filter(array(
            Priority::ID_PRIORITY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Priority::ID_PRIORITY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PriorityQuery
     */
    public function filter($fields, $prefix = 'Priority'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Priority')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_priority']) && !empty($fields['id_priority']) ){
            $criteria->add(Priority::ID_PRIORITY, $fields['id_priority']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Priority::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Priority::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\PriorityQuery
     */
    public function actives(){
        return $this->filter(array(
            Priority::STATUS => Priority::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\PriorityQuery
     */
    public function inactives(){
        return $this->filter(array(
            Priority::STATUS => Priority::$Status['Inactive'],
        ));
    }


}