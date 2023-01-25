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
use Application\Model\Catalog\ResolutionLogCatalog;
use Application\Model\Bean\ResolutionLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ResolutionLogQuery
 *
 * @method \Application\Query\ResolutionLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ResolutionLogQuery useMemoryCache()
 * @method \Application\Query\ResolutionLogQuery useFileCache()
 * @method \Application\Model\Collection\ResolutionLogCollection find()
 * @method \Application\Model\Bean\ResolutionLog findOne()
 * @method \Application\Model\Bean\ResolutionLog findOneOrElse() findOneOrElse(ResolutionLog $alternative)
 * @method \Application\Model\Bean\ResolutionLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ResolutionLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ResolutionLog findByPKOrElse() findByPKOrElse($pk, ResolutionLog $alternative)
 * @method \Application\Model\Bean\ResolutionLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ResolutionLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ResolutionLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ResolutionLogQuery removeJoins()
 * @method \Application\Query\ResolutionLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ResolutionLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ResolutionLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ResolutionLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ResolutionLogQuery bind() bind($parameters)
 * @method \Application\Query\ResolutionLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ResolutionLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ResolutionLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ResolutionLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ResolutionLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ResolutionLogQuery distinct()
 * @method \Application\Query\ResolutionLogQuery select()
 * @method \Application\Query\ResolutionLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ResolutionLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ResolutionLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ResolutionLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ResolutionLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ResolutionLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ResolutionLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ResolutionLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ResolutionLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ResolutionLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ResolutionLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ResolutionLog::TABLENAME, "ResolutionLog");

        $defaultColumn = array("ResolutionLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ResolutionLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ResolutionLog::ID_RESOLUTION_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ResolutionLog::ID_RESOLUTION_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ResolutionLogQuery
     */
    public function filter($fields, $prefix = 'ResolutionLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ResolutionLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_resolution_log']) && !empty($fields['id_resolution_log']) ){
            $criteria->add(ResolutionLog::ID_RESOLUTION_LOG, $fields['id_resolution_log']);
        }
        if( isset($fields['id_resolution']) && !empty($fields['id_resolution']) ){
            $criteria->add(ResolutionLog::ID_RESOLUTION, $fields['id_resolution']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ResolutionLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ResolutionLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(ResolutionLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ResolutionLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ResolutionLogQuery
     */
    public function innerJoinResolution($alias = 'ResolutionLog', $aliasForeignTable = 'Resolution')
    {
        $this->innerJoinOn(\Application\Model\Bean\Resolution::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_resolution'), array($aliasForeignTable, 'id_resolution'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ResolutionLogQuery
     */
    public function innerJoinUser($alias = 'ResolutionLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}