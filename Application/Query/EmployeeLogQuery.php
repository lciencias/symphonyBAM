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
use Application\Model\Catalog\EmployeeLogCatalog;
use Application\Model\Bean\EmployeeLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\EmployeeLogQuery
 *
 * @method \Application\Query\EmployeeLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EmployeeLogQuery useMemoryCache()
 * @method \Application\Query\EmployeeLogQuery useFileCache()
 * @method \Application\Model\Collection\EmployeeLogCollection find()
 * @method \Application\Model\Bean\EmployeeLog findOne()
 * @method \Application\Model\Bean\EmployeeLog findOneOrElse() findOneOrElse(EmployeeLog $alternative)
 * @method \Application\Model\Bean\EmployeeLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\EmployeeLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\EmployeeLog findByPKOrElse() findByPKOrElse($pk, EmployeeLog $alternative)
 * @method \Application\Model\Bean\EmployeeLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EmployeeLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EmployeeLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EmployeeLogQuery removeJoins()
 * @method \Application\Query\EmployeeLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EmployeeLogQuery from() from($table, $alias = null)
 * @method \Application\Query\EmployeeLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EmployeeLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EmployeeLogQuery bind() bind($parameters)
 * @method \Application\Query\EmployeeLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EmployeeLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EmployeeLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\EmployeeLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\EmployeeLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EmployeeLogQuery distinct()
 * @method \Application\Query\EmployeeLogQuery select()
 * @method \Application\Query\EmployeeLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\EmployeeLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EmployeeLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EmployeeLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EmployeeLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EmployeeLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EmployeeLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EmployeeLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EmployeeLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\EmployeeLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EmployeeLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(EmployeeLog::TABLENAME, "EmployeeLog");

        $defaultColumn = array("EmployeeLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\EmployeeLogQuery
     */
    public function pk($value){
        $this->filter(array(
            EmployeeLog::ID_EMPLOYEE_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(EmployeeLog::ID_EMPLOYEE_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EmployeeLogQuery
     */
    public function filter($fields, $prefix = 'EmployeeLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'EmployeeLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_employee_log']) && !empty($fields['id_employee_log']) ){
            $criteria->add(EmployeeLog::ID_EMPLOYEE_LOG, $fields['id_employee_log']);
        }
        if( isset($fields['id_employee']) && !empty($fields['id_employee']) ){
            $criteria->add(EmployeeLog::ID_EMPLOYEE, $fields['id_employee']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(EmployeeLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(EmployeeLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(EmployeeLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(EmployeeLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeLogQuery
     */
    public function innerJoinEmployee($alias = 'EmployeeLog', $aliasForeignTable = 'Employee')
    {
        $this->innerJoinOn(\Application\Model\Bean\Employee::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_employee'), array($aliasForeignTable, 'id_employee'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeLogQuery
     */
    public function innerJoinUser($alias = 'EmployeeLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}