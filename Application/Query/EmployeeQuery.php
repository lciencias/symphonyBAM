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

use Query\Criterion;

use Query\Query;
use Application\Model\Catalog\EmployeeCatalog;
use Application\Model\Bean\Employee;


/**
 * Application\Query\EmployeeQuery
 *
 * @method \Application\Query\EmployeeQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EmployeeQuery useMemoryCache()
 * @method \Application\Query\EmployeeQuery useFileCache()
 * @method \Application\Model\Collection\EmployeeCollection find()
 * @method \Application\Model\Bean\Employee findOne()
 * @method \Application\Model\Bean\Employee findOneOrElse() findOneOrElse(Employee $alternative)
 * @method \Application\Model\Bean\Employee findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Employee findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Employee findByPKOrElse() findByPKOrElse($pk, Employee $alternative)
 * @method \Application\Model\Bean\Employee findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EmployeeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EmployeeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EmployeeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EmployeeQuery removeJoins()
 * @method \Application\Query\EmployeeQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EmployeeQuery from() from($table, $alias = null)
 * @method \Application\Query\EmployeeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EmployeeQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EmployeeQuery bind() bind($parameters)
 * @method \Application\Query\EmployeeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EmployeeQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EmployeeQuery setLimit() setLimit($limit)
 * @method \Application\Query\EmployeeQuery setOffset() setOffset($offset)
 * @method \Application\Query\EmployeeQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EmployeeQuery distinct()
 * @method \Application\Query\EmployeeQuery select()
 * @method \Application\Query\EmployeeQuery addColumns() addColumns($columns)
 * @method \Application\Query\EmployeeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EmployeeQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EmployeeQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EmployeeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EmployeeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EmployeeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EmployeeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EmployeeQuery extends PersonQuery{

    /**
     *
     * @return \Application\Model\Catalog\EmployeeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EmployeeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Employee::TABLENAME, "Employee");
        $this->innerJoinPerson();

        $defaultColumn = array("Employee.*");
        $defaultColumn[] = "Person.*";
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\EmployeeQuery
     */
    public function pk($value){
        $this->filter(array(
            Employee::ID_EMPLOYEE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Employee::ID_EMPLOYEE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EmployeeQuery
     */
    public function filter($fields, $prefix = 'Employee'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Employee')
    {
        parent::build($query, $fields);

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_employee']) && !empty($fields['id_employee']) ){
            $criteria->add(Employee::ID_EMPLOYEE, $fields['id_employee']);
        }
        if( isset($fields['id_person']) && !empty($fields['id_person']) ){
            $criteria->add(Employee::ID_PERSON, $fields['id_person']);
        }
        if( isset($fields['id_position']) && !empty($fields['id_position']) ){
            $criteria->add(Employee::ID_POSITION, $fields['id_position']);
        }
        if( isset($fields['id_location']) && !empty($fields['id_location']) ){
            $criteria->add(Employee::ID_LOCATION, $fields['id_location']);
        }
        if( isset($fields['id_area']) && !empty($fields['id_area']) ){
            $criteria->add(Employee::ID_AREA, $fields['id_area']);
        }
        if( isset($fields['status_employee']) && !empty($fields['status_employee']) ){
            $criteria->add(Employee::STATUS_EMPLOYEE, $fields['status_employee']);
        }
        if( isset($fields['is_vip']) && !empty($fields['is_vip']) ){
            $criteria->add(Employee::IS_VIP, $fields['is_vip']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Employee::ID_COMPANY, $fields['id_company']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\EmployeeQuery
     */
    public function actives(){
        return $this->filter(array(
            Employee::STATUS_EMPLOYEE => Employee::$StatusEmployee['Active'],
        ));
    }

    /**
     * @return \Application\Query\EmployeeQuery
     */
    public function inactives(){
        return $this->filter(array(
            Employee::STATUS_EMPLOYEE => Employee::$StatusEmployee['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeQuery
     */
    public function innerJoinPerson($alias = 'Employee', $aliasForeignTable = 'Person')
    {
        $this->innerJoinOn(\Application\Model\Bean\Person::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_person'), array($aliasForeignTable, 'id_person'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeQuery
     */
    public function innerJoinPosition($alias = 'Employee', $aliasForeignTable = 'Position')
    {
        $this->innerJoinOn(\Application\Model\Bean\Position::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_position'), array($aliasForeignTable, 'id_position'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeQuery
     */
    public function withoutUser($alias = 'Employee', $aliasForeignTable = 'User')
    {
        $this->leftJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
        ->equalFields(array($alias, 'id_employee'), array($aliasForeignTable, 'id_employee'));

        $this->whereAdd('User.id_user', null, self::IS_NULL);

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeQuery
     */
    public function innerJoinLocation($alias = 'Employee', $aliasForeignTable = 'Location')
    {
        $this->innerJoinOn(\Application\Model\Bean\Location::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_location'), array($aliasForeignTable, 'id_location'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmployeeQuery
     */
    public function innerJoinArea($alias = 'Employee', $aliasForeignTable = 'Area')
    {
        $this->innerJoinOn(\Application\Model\Bean\Area::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_area'), array($aliasForeignTable, 'id_area'));
        return $this;
    }

    /**
     * @param string $alias
     * @param string $aliasForeingTAble
     * @return \Application\Query\EmployeeQuery
     */

    public function innerJoinCompany($alias =  'Employee', $aliasForeingTable = 'Company')
    {
    	$this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeingTable)
    	->equalFields(array($alias, 'id_company'), array($aliasForeingTable, 'id_company'));
    	return $this;
    }


}