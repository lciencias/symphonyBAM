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
use Application\Model\Catalog\AccessRoleLogCatalog;
use Application\Model\Bean\AccessRoleLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\AccessRoleLogQuery
 *
 * @method \Application\Query\AccessRoleLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AccessRoleLogQuery useMemoryCache()
 * @method \Application\Query\AccessRoleLogQuery useFileCache()
 * @method \Application\Model\Collection\AccessRoleLogCollection find()
 * @method \Application\Model\Bean\AccessRoleLog findOne()
 * @method \Application\Model\Bean\AccessRoleLog findOneOrElse() findOneOrElse(AccessRoleLog $alternative)
 * @method \Application\Model\Bean\AccessRoleLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\AccessRoleLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\AccessRoleLog findByPKOrElse() findByPKOrElse($pk, AccessRoleLog $alternative)
 * @method \Application\Model\Bean\AccessRoleLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AccessRoleLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery removeJoins()
 * @method \Application\Query\AccessRoleLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AccessRoleLogQuery from() from($table, $alias = null)
 * @method \Application\Query\AccessRoleLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AccessRoleLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AccessRoleLogQuery bind() bind($parameters)
 * @method \Application\Query\AccessRoleLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AccessRoleLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AccessRoleLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\AccessRoleLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\AccessRoleLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AccessRoleLogQuery distinct()
 * @method \Application\Query\AccessRoleLogQuery select()
 * @method \Application\Query\AccessRoleLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\AccessRoleLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AccessRoleLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AccessRoleLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AccessRoleLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AccessRoleLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AccessRoleLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AccessRoleLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AccessRoleLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AccessRoleLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AccessRoleLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(AccessRoleLog::TABLENAME, "AccessRoleLog");

        $defaultColumn = array("AccessRoleLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\AccessRoleLogQuery
     */
    public function pk($value){
        $this->filter(array(
            AccessRoleLog::ID_ACCESS_ROLE_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(AccessRoleLog::ID_ACCESS_ROLE_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AccessRoleLogQuery
     */
    public function filter($fields, $prefix = 'AccessRoleLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'AccessRoleLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_access_role_log']) && !empty($fields['id_access_role_log']) ){
            $criteria->add(AccessRoleLog::ID_ACCESS_ROLE_LOG, $fields['id_access_role_log']);
        }
        if( isset($fields['id_access_role']) && !empty($fields['id_access_role']) ){
            $criteria->add(AccessRoleLog::ID_ACCESS_ROLE, $fields['id_access_role']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(AccessRoleLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(AccessRoleLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(AccessRoleLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(AccessRoleLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AccessRoleLogQuery
     */
    public function innerJoinAccessRole($alias = 'AccessRoleLog', $aliasForeignTable = 'AccessRole')
    {
        $this->innerJoinOn(\Application\Model\Bean\AccessRole::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_access_role'), array($aliasForeignTable, 'id_access_role'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AccessRoleLogQuery
     */
    public function innerJoinUser($alias = 'AccessRoleLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}