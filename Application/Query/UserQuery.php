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

use Query\Query;
use Application\Model\Catalog\UserCatalog;
use Application\Model\Bean\User;


/**
 * Application\Query\UserQuery
 *
 * @method \Application\Query\UserQuery pk() pk(int $primaryKey)
 * @method \Application\Query\UserQuery useMemoryCache()
 * @method \Application\Query\UserQuery useFileCache()
 * @method \Application\Model\Collection\UserCollection find()
 * @method \Application\Model\Bean\User findOne()
 * @method \Application\Model\Bean\User findOneOrElse() findOneOrElse(User $alternative)
 * @method \Application\Model\Bean\User findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\User findByPK() findByPK($pk)
 * @method \Application\Model\Bean\User findByPKOrElse() findByPKOrElse($pk, User $alternative)
 * @method \Application\Model\Bean\User findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\UserQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\UserQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\UserQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\UserQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\UserQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\UserQuery removeJoins()
 * @method \Application\Query\UserQuery removeJoin() removeJoin($table)
 * @method \Application\Query\UserQuery from() from($table, $alias = null)
 * @method \Application\Query\UserQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\UserQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\UserQuery bind() bind($parameters)
 * @method \Application\Query\UserQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\UserQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\UserQuery setLimit() setLimit($limit)
 * @method \Application\Query\UserQuery setOffset() setOffset($offset)
 * @method \Application\Query\UserQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\UserQuery distinct()
 * @method \Application\Query\UserQuery select()
 * @method \Application\Query\UserQuery addColumns() addColumns($columns)
 * @method \Application\Query\UserQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\UserQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\UserQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\UserQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\UserQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\UserQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\UserQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class UserQuery extends EmployeeQuery{

    /**
     *
     * @return \Application\Model\Catalog\UserCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('UserCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(User::TABLENAME, "User");
        $this->innerJoinEmployee();
        $this->innerJoinPerson();

        $defaultColumn = array("User.*");
        $defaultColumn[] = "Employee.*";
        $defaultColumn[] = "Person.*";
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\UserQuery
     */
    public function pk($value){
        $this->filter(array(
            User::ID_USER => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(User::ID_USER, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\UserQuery
     */
    public function filter($fields, $prefix = 'User'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'User')
    {
        parent::build($query, $fields);

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(User::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_access_role']) && !empty($fields['id_access_role']) ){
            $criteria->add(User::ID_ACCESS_ROLE, $fields['id_access_role']);
        }
        if( isset($fields['id_employee']) && !empty($fields['id_employee']) ){
            $criteria->add(User::ID_EMPLOYEE, $fields['id_employee']);
        }
        if( isset($fields['username']) && !empty($fields['username']) ){
            $criteria->add(User::USERNAME, $fields['username']);
        }
        if( isset($fields['password']) && !empty($fields['password']) ){
            $criteria->add(User::PASSWORD, $fields['password']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(User::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\UserQuery
     */
    public function actives(){
        return $this->filter(array(
            User::STATUS => User::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\UserQuery
     */
    public function inactives(){
        return $this->filter(array(
            User::STATUS => User::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\UserQuery
     */
    public function innerJoinAccessRole($alias = 'User', $aliasForeignTable = 'AccessRole')
    {
        $this->innerJoinOn(\Application\Model\Bean\AccessRole::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_access_role'), array($aliasForeignTable, 'id_access_role'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\UserQuery
     */
    public function innerJoinEmployee($alias = 'User', $aliasForeignTable = 'Employee')
    {
        $this->innerJoinOn(\Application\Model\Bean\Employee::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_employee'), array($aliasForeignTable, 'id_employee'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\UserQuery
     */
    public function innerJoinGroup($alias = 'User', $aliasForeignTable = 'Group')
    {
        $this->innerJoinOn('pcs_symphony_user_group', 'User2Group')
            ->equalFields(array($alias, 'id_user'), array('User2Group', 'id_user'));

        $this->innerJoinOn(\Application\Model\Bean\Group::TABLENAME, $aliasForeignTable)
            ->equalFields(array('User2Group', 'id_group'), array($aliasForeignTable, 'id_group'));

        return $this;
    }


}