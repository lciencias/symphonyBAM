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
use Application\Model\Catalog\AccessRoleCatalog;
use Application\Model\Bean\AccessRole;

use Application\Query\BaseQuery;

/**
 * Application\Query\AccessRoleQuery
 *
 * @method \Application\Query\AccessRoleQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AccessRoleQuery useMemoryCache()
 * @method \Application\Query\AccessRoleQuery useFileCache()
 * @method \Application\Model\Collection\AccessRoleCollection find()
 * @method \Application\Model\Bean\AccessRole findOne()
 * @method \Application\Model\Bean\AccessRole findOneOrElse() findOneOrElse(AccessRole $alternative)
 * @method \Application\Model\Bean\AccessRole findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\AccessRole findByPK() findByPK($pk)
 * @method \Application\Model\Bean\AccessRole findByPKOrElse() findByPKOrElse($pk, AccessRole $alternative)
 * @method \Application\Model\Bean\AccessRole findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AccessRoleQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AccessRoleQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AccessRoleQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AccessRoleQuery removeJoins()
 * @method \Application\Query\AccessRoleQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AccessRoleQuery from() from($table, $alias = null)
 * @method \Application\Query\AccessRoleQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AccessRoleQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AccessRoleQuery bind() bind($parameters)
 * @method \Application\Query\AccessRoleQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AccessRoleQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AccessRoleQuery setLimit() setLimit($limit)
 * @method \Application\Query\AccessRoleQuery setOffset() setOffset($offset)
 * @method \Application\Query\AccessRoleQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AccessRoleQuery distinct()
 * @method \Application\Query\AccessRoleQuery select()
 * @method \Application\Query\AccessRoleQuery addColumns() addColumns($columns)
 * @method \Application\Query\AccessRoleQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AccessRoleQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AccessRoleQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AccessRoleQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AccessRoleQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AccessRoleQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AccessRoleQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AccessRoleQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AccessRoleCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AccessRoleCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(AccessRole::TABLENAME, "AccessRole");

        $defaultColumn = array("AccessRole.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\AccessRoleQuery
     */
    public function pk($value){
        $this->filter(array(
            AccessRole::ID_ACCESS_ROLE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(AccessRole::ID_ACCESS_ROLE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AccessRoleQuery
     */
    public function filter($fields, $prefix = 'AccessRole'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'AccessRole')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_access_role']) && !empty($fields['id_access_role']) ){
            $criteria->add(AccessRole::ID_ACCESS_ROLE, $fields['id_access_role']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(AccessRole::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(AccessRole::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\AccessRoleQuery
     */
    public function actives(){
        return $this->filter(array(
            AccessRole::STATUS => AccessRole::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\AccessRoleQuery
     */
    public function inactives(){
        return $this->filter(array(
            AccessRole::STATUS => AccessRole::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AccessRoleQuery
     */
    public function innerJoinSecurityAction($alias = 'AccessRole', $aliasForeignTable = 'SecurityAction')
    {
        $this->innerJoinOn('pcs_common_security_actions_access_roles', 'AccessRole2SecurityAction')
            ->equalFields(array($alias, 'id_access_role'), array('AccessRole2SecurityAction', 'id_access_role'));

        $this->innerJoinOn(\Application\Model\Bean\SecurityAction::TABLENAME, $aliasForeignTable)
            ->equalFields(array('AccessRole2SecurityAction', 'id_security_action'), array($aliasForeignTable, 'id_action'));

        return $this;
    }


}