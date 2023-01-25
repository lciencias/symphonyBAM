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
use Application\Model\Catalog\WorkweekLogCatalog;
use Application\Model\Bean\WorkweekLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\WorkweekLogQuery
 *
 * @method \Application\Query\WorkweekLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\WorkweekLogQuery useMemoryCache()
 * @method \Application\Query\WorkweekLogQuery useFileCache()
 * @method \Application\Model\Collection\WorkweekLogCollection find()
 * @method \Application\Model\Bean\WorkweekLog findOne()
 * @method \Application\Model\Bean\WorkweekLog findOneOrElse() findOneOrElse(WorkweekLog $alternative)
 * @method \Application\Model\Bean\WorkweekLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\WorkweekLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\WorkweekLog findByPKOrElse() findByPKOrElse($pk, WorkweekLog $alternative)
 * @method \Application\Model\Bean\WorkweekLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\WorkweekLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\WorkweekLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\WorkweekLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\WorkweekLogQuery removeJoins()
 * @method \Application\Query\WorkweekLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\WorkweekLogQuery from() from($table, $alias = null)
 * @method \Application\Query\WorkweekLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\WorkweekLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\WorkweekLogQuery bind() bind($parameters)
 * @method \Application\Query\WorkweekLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\WorkweekLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\WorkweekLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\WorkweekLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\WorkweekLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\WorkweekLogQuery distinct()
 * @method \Application\Query\WorkweekLogQuery select()
 * @method \Application\Query\WorkweekLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\WorkweekLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\WorkweekLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\WorkweekLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\WorkweekLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\WorkweekLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\WorkweekLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\WorkweekLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class WorkweekLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\WorkweekLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('WorkweekLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(WorkweekLog::TABLENAME, "WorkweekLog");

        $defaultColumn = array("WorkweekLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\WorkweekLogQuery
     */
    public function pk($value){
        $this->filter(array(
            WorkweekLog::ID_WORKWEEK_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(WorkweekLog::ID_WORKWEEK_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\WorkweekLogQuery
     */
    public function filter($fields, $prefix = 'WorkweekLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'WorkweekLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_workweek_log']) && !empty($fields['id_workweek_log']) ){
            $criteria->add(WorkweekLog::ID_WORKWEEK_LOG, $fields['id_workweek_log']);
        }
        if( isset($fields['id_workweek']) && !empty($fields['id_workweek']) ){
            $criteria->add(WorkweekLog::ID_WORKWEEK, $fields['id_workweek']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(WorkweekLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(WorkweekLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(WorkweekLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(WorkweekLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\WorkweekLogQuery
     */
    public function innerJoinWorkweek($alias = 'WorkweekLog', $aliasForeignTable = 'Workweek')
    {
        $this->innerJoinOn(\Application\Model\Bean\Workweek::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_workweek'), array($aliasForeignTable, 'id_workweek'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\WorkweekLogQuery
     */
    public function innerJoinUser($alias = 'WorkweekLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}