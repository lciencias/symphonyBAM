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
use Application\Model\Catalog\ServiceLevelLogCatalog;
use Application\Model\Bean\ServiceLevelLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ServiceLevelLogQuery
 *
 * @method \Application\Query\ServiceLevelLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ServiceLevelLogQuery useMemoryCache()
 * @method \Application\Query\ServiceLevelLogQuery useFileCache()
 * @method \Application\Model\Collection\ServiceLevelLogCollection find()
 * @method \Application\Model\Bean\ServiceLevelLog findOne()
 * @method \Application\Model\Bean\ServiceLevelLog findOneOrElse() findOneOrElse(ServiceLevelLog $alternative)
 * @method \Application\Model\Bean\ServiceLevelLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ServiceLevelLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ServiceLevelLog findByPKOrElse() findByPKOrElse($pk, ServiceLevelLog $alternative)
 * @method \Application\Model\Bean\ServiceLevelLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ServiceLevelLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery removeJoins()
 * @method \Application\Query\ServiceLevelLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ServiceLevelLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ServiceLevelLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ServiceLevelLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ServiceLevelLogQuery bind() bind($parameters)
 * @method \Application\Query\ServiceLevelLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ServiceLevelLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ServiceLevelLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ServiceLevelLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ServiceLevelLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ServiceLevelLogQuery distinct()
 * @method \Application\Query\ServiceLevelLogQuery select()
 * @method \Application\Query\ServiceLevelLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ServiceLevelLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ServiceLevelLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ServiceLevelLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ServiceLevelLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ServiceLevelLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ServiceLevelLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ServiceLevelLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ServiceLevelLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ServiceLevelLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ServiceLevelLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ServiceLevelLog::TABLENAME, "ServiceLevelLog");

        $defaultColumn = array("ServiceLevelLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ServiceLevelLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ServiceLevelLog::ID_SERVICE_LEVEL_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ServiceLevelLog::ID_SERVICE_LEVEL_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ServiceLevelLogQuery
     */
    public function filter($fields, $prefix = 'ServiceLevelLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ServiceLevelLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_service_level_log']) && !empty($fields['id_service_level_log']) ){
            $criteria->add(ServiceLevelLog::ID_SERVICE_LEVEL_LOG, $fields['id_service_level_log']);
        }
        if( isset($fields['id_service_level']) && !empty($fields['id_service_level']) ){
            $criteria->add(ServiceLevelLog::ID_SERVICE_LEVEL, $fields['id_service_level']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ServiceLevelLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ServiceLevelLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(ServiceLevelLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ServiceLevelLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ServiceLevelLogQuery
     */
    public function innerJoinServiceLevel($alias = 'ServiceLevelLog', $aliasForeignTable = 'ServiceLevel')
    {
        $this->innerJoinOn(\Application\Model\Bean\ServiceLevel::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_service_level'), array($aliasForeignTable, 'id_service_level'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ServiceLevelLogQuery
     */
    public function innerJoinUser($alias = 'ServiceLevelLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}