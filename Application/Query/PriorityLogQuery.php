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

use Query\Query;
use Application\Model\Catalog\PriorityLogCatalog;
use Application\Model\Bean\PriorityLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\PriorityLogQuery
 *
 * @method \Application\Query\PriorityLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PriorityLogQuery useMemoryCache()
 * @method \Application\Query\PriorityLogQuery useFileCache()
 * @method \Application\Model\Collection\PriorityLogCollection find()
 * @method \Application\Model\Bean\PriorityLog findOne()
 * @method \Application\Model\Bean\PriorityLog findOneOrElse() findOneOrElse(PriorityLog $alternative)
 * @method \Application\Model\Bean\PriorityLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\PriorityLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\PriorityLog findByPKOrElse() findByPKOrElse($pk, PriorityLog $alternative)
 * @method \Application\Model\Bean\PriorityLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PriorityLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PriorityLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PriorityLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PriorityLogQuery removeJoins()
 * @method \Application\Query\PriorityLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PriorityLogQuery from() from($table, $alias = null)
 * @method \Application\Query\PriorityLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PriorityLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PriorityLogQuery bind() bind($parameters)
 * @method \Application\Query\PriorityLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PriorityLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PriorityLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\PriorityLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\PriorityLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PriorityLogQuery distinct()
 * @method \Application\Query\PriorityLogQuery select()
 * @method \Application\Query\PriorityLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\PriorityLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PriorityLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PriorityLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PriorityLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PriorityLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PriorityLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PriorityLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PriorityLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PriorityLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PriorityLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(PriorityLog::TABLENAME, "PriorityLog");

        $defaultColumn = array("PriorityLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\PriorityLogQuery
     */
    public function pk($value){
        $this->filter(array(
            PriorityLog::ID_PRIORITY_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(PriorityLog::ID_PRIORITY_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PriorityLogQuery
     */
    public function filter($fields, $prefix = 'PriorityLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'PriorityLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_priority_log']) && !empty($fields['id_priority_log']) ){
            $criteria->add(PriorityLog::ID_PRIORITY_LOG, $fields['id_priority_log']);
        }
        if( isset($fields['id_priority']) && !empty($fields['id_priority']) ){
            $criteria->add(PriorityLog::ID_PRIORITY, $fields['id_priority']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(PriorityLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(PriorityLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(PriorityLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PriorityLogQuery
     */
    public function innerJoinPriority($alias = 'PriorityLog', $aliasForeignTable = 'Priority')
    {
        $this->innerJoinOn(\Application\Model\Bean\Priority::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_priority'), array($aliasForeignTable, 'id_priority'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PriorityLogQuery
     */
    public function innerJoinUser($alias = 'PriorityLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}