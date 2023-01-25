<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Catalog\FieldLogCatalog;
use Application\Model\Bean\FieldLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\FieldLogQuery
 *
 * @method \Application\Query\FieldLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\FieldLogQuery useMemoryCache()
 * @method \Application\Query\FieldLogQuery useFileCache()
 * @method \Application\Model\Collection\FieldLogCollection find()
 * @method \Application\Model\Bean\FieldLog findOne()
 * @method \Application\Model\Bean\FieldLog findOneOrElse() findOneOrElse(FieldLog $alternative)
 * @method \Application\Model\Bean\FieldLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\FieldLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\FieldLog findByPKOrElse() findByPKOrElse($pk, FieldLog $alternative)
 * @method \Application\Model\Bean\FieldLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\FieldLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\FieldLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\FieldLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\FieldLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\FieldLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\FieldLogQuery removeJoins()
 * @method \Application\Query\FieldLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\FieldLogQuery from() from($table, $alias = null)
 * @method \Application\Query\FieldLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\FieldLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\FieldLogQuery bind() bind($parameters)
 * @method \Application\Query\FieldLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\FieldLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\FieldLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\FieldLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\FieldLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\FieldLogQuery distinct()
 * @method \Application\Query\FieldLogQuery select()
 * @method \Application\Query\FieldLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\FieldLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\FieldLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\FieldLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\FieldLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\FieldLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\FieldLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\FieldLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class FieldLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\FieldLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('FieldLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(FieldLog::TABLENAME, "FieldLog");

        $defaultColumn = array("FieldLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\FieldLogQuery
     */
    public function pk($value){
        $this->filter(array(
            FieldLog::ID_FIELD_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(FieldLog::ID_FIELD_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\FieldLogQuery
     */
    public function filter($fields, $prefix = 'FieldLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'FieldLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_field_log']) && !empty($fields['id_field_log']) ){
            $criteria->add(FieldLog::ID_FIELD_LOG, $fields['id_field_log']);
        }
        if( isset($fields['id_field']) && !empty($fields['id_field']) ){
            $criteria->add(FieldLog::ID_FIELD, $fields['id_field']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(FieldLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(FieldLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(FieldLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(FieldLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }


}