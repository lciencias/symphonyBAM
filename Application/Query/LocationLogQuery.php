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
use Application\Model\Catalog\LocationLogCatalog;
use Application\Model\Bean\LocationLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\LocationLogQuery
 *
 * @method \Application\Query\LocationLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\LocationLogQuery useMemoryCache()
 * @method \Application\Query\LocationLogQuery useFileCache()
 * @method \Application\Model\Collection\LocationLogCollection find()
 * @method \Application\Model\Bean\LocationLog findOne()
 * @method \Application\Model\Bean\LocationLog findOneOrElse() findOneOrElse(LocationLog $alternative)
 * @method \Application\Model\Bean\LocationLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\LocationLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\LocationLog findByPKOrElse() findByPKOrElse($pk, LocationLog $alternative)
 * @method \Application\Model\Bean\LocationLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\LocationLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\LocationLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\LocationLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\LocationLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\LocationLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\LocationLogQuery removeJoins()
 * @method \Application\Query\LocationLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\LocationLogQuery from() from($table, $alias = null)
 * @method \Application\Query\LocationLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\LocationLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\LocationLogQuery bind() bind($parameters)
 * @method \Application\Query\LocationLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\LocationLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\LocationLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\LocationLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\LocationLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\LocationLogQuery distinct()
 * @method \Application\Query\LocationLogQuery select()
 * @method \Application\Query\LocationLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\LocationLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\LocationLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\LocationLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\LocationLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\LocationLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\LocationLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\LocationLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class LocationLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\LocationLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('LocationLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(LocationLog::TABLENAME, "LocationLog");

        $defaultColumn = array("LocationLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\LocationLogQuery
     */
    public function pk($value){
        $this->filter(array(
            LocationLog::ID_LOCATION_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(LocationLog::ID_LOCATION_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\LocationLogQuery
     */
    public function filter($fields, $prefix = 'LocationLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'LocationLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_location_log']) && !empty($fields['id_location_log']) ){
            $criteria->add(LocationLog::ID_LOCATION_LOG, $fields['id_location_log']);
        }
        if( isset($fields['id_location']) && !empty($fields['id_location']) ){
            $criteria->add(LocationLog::ID_LOCATION, $fields['id_location']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(LocationLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(LocationLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(LocationLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(LocationLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\LocationLogQuery
     */
    public function innerJoinLocation($alias = 'LocationLog', $aliasForeignTable = 'Location')
    {
        $this->innerJoinOn(\Application\Model\Bean\Location::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_location'), array($aliasForeignTable, 'id_location'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\LocationLogQuery
     */
    public function innerJoinUser($alias = 'LocationLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}