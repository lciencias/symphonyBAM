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
use Application\Model\Catalog\PositionLogCatalog;
use Application\Model\Bean\PositionLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\PositionLogQuery
 *
 * @method \Application\Query\PositionLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PositionLogQuery useMemoryCache()
 * @method \Application\Query\PositionLogQuery useFileCache()
 * @method \Application\Model\Collection\PositionLogCollection find()
 * @method \Application\Model\Bean\PositionLog findOne()
 * @method \Application\Model\Bean\PositionLog findOneOrElse() findOneOrElse(PositionLog $alternative)
 * @method \Application\Model\Bean\PositionLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\PositionLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\PositionLog findByPKOrElse() findByPKOrElse($pk, PositionLog $alternative)
 * @method \Application\Model\Bean\PositionLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PositionLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PositionLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PositionLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PositionLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PositionLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PositionLogQuery removeJoins()
 * @method \Application\Query\PositionLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PositionLogQuery from() from($table, $alias = null)
 * @method \Application\Query\PositionLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PositionLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PositionLogQuery bind() bind($parameters)
 * @method \Application\Query\PositionLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PositionLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PositionLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\PositionLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\PositionLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PositionLogQuery distinct()
 * @method \Application\Query\PositionLogQuery select()
 * @method \Application\Query\PositionLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\PositionLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PositionLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PositionLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PositionLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PositionLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PositionLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PositionLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PositionLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PositionLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PositionLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(PositionLog::TABLENAME, "PositionLog");

        $defaultColumn = array("PositionLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\PositionLogQuery
     */
    public function pk($value){
        $this->filter(array(
            PositionLog::ID_POSITION_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(PositionLog::ID_POSITION_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PositionLogQuery
     */
    public function filter($fields, $prefix = 'PositionLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'PositionLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_position_log']) && !empty($fields['id_position_log']) ){
            $criteria->add(PositionLog::ID_POSITION_LOG, $fields['id_position_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(PositionLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_position']) && !empty($fields['id_position']) ){
            $criteria->add(PositionLog::ID_POSITION, $fields['id_position']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(PositionLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(PositionLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(PositionLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PositionLogQuery
     */
    public function innerJoinUser($alias = 'PositionLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PositionLogQuery
     */
    public function innerJoinPosition($alias = 'PositionLog', $aliasForeignTable = 'Position')
    {
        $this->innerJoinOn(\Application\Model\Bean\Position::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_position'), array($aliasForeignTable, 'id_position'));

        return $this;
    }


}