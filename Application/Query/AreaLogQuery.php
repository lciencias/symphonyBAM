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
use Application\Model\Catalog\AreaLogCatalog;
use Application\Model\Bean\AreaLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\AreaLogQuery
 *
 * @method \Application\Query\AreaLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AreaLogQuery useMemoryCache()
 * @method \Application\Query\AreaLogQuery useFileCache()
 * @method \Application\Model\Collection\AreaLogCollection find()
 * @method \Application\Model\Bean\AreaLog findOne()
 * @method \Application\Model\Bean\AreaLog findOneOrElse() findOneOrElse(AreaLog $alternative)
 * @method \Application\Model\Bean\AreaLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\AreaLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\AreaLog findByPKOrElse() findByPKOrElse($pk, AreaLog $alternative)
 * @method \Application\Model\Bean\AreaLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AreaLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AreaLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AreaLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AreaLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AreaLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AreaLogQuery removeJoins()
 * @method \Application\Query\AreaLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AreaLogQuery from() from($table, $alias = null)
 * @method \Application\Query\AreaLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AreaLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AreaLogQuery bind() bind($parameters)
 * @method \Application\Query\AreaLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AreaLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AreaLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\AreaLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\AreaLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AreaLogQuery distinct()
 * @method \Application\Query\AreaLogQuery select()
 * @method \Application\Query\AreaLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\AreaLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AreaLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AreaLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AreaLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AreaLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AreaLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AreaLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AreaLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AreaLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AreaLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(AreaLog::TABLENAME, "AreaLog");

        $defaultColumn = array("AreaLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\AreaLogQuery
     */
    public function pk($value){
        $this->filter(array(
            AreaLog::ID_AREA_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(AreaLog::ID_AREA_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AreaLogQuery
     */
    public function filter($fields, $prefix = 'AreaLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'AreaLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_area_log']) && !empty($fields['id_area_log']) ){
            $criteria->add(AreaLog::ID_AREA_LOG, $fields['id_area_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(AreaLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_area']) && !empty($fields['id_area']) ){
            $criteria->add(AreaLog::ID_AREA, $fields['id_area']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(AreaLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(AreaLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(AreaLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AreaLogQuery
     */
    public function innerJoinUser($alias = 'AreaLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AreaLogQuery
     */
    public function innerJoinArea($alias = 'AreaLog', $aliasForeignTable = 'Area')
    {
        $this->innerJoinOn(\Application\Model\Bean\Area::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_area'), array($aliasForeignTable, 'id_area'));

        return $this;
    }


}