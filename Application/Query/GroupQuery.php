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
use Application\Model\Catalog\GroupCatalog;
use Application\Model\Bean\Group;

use Application\Query\BaseQuery;

/**
 * Application\Query\GroupQuery
 *
 * @method \Application\Query\GroupQuery pk() pk(int $primaryKey)
 * @method \Application\Query\GroupQuery useMemoryCache()
 * @method \Application\Query\GroupQuery useFileCache()
 * @method \Application\Model\Collection\GroupCollection find()
 * @method \Application\Model\Bean\Group findOne()
 * @method \Application\Model\Bean\Group findOneOrElse() findOneOrElse(Group $alternative)
 * @method \Application\Model\Bean\Group findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Group findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Group findByPKOrElse() findByPKOrElse($pk, Group $alternative)
 * @method \Application\Model\Bean\Group findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\GroupQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\GroupQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\GroupQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\GroupQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\GroupQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\GroupQuery removeJoins()
 * @method \Application\Query\GroupQuery removeJoin() removeJoin($table)
 * @method \Application\Query\GroupQuery from() from($table, $alias = null)
 * @method \Application\Query\GroupQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\GroupQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\GroupQuery bind() bind($parameters)
 * @method \Application\Query\GroupQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\GroupQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\GroupQuery setLimit() setLimit($limit)
 * @method \Application\Query\GroupQuery setOffset() setOffset($offset)
 * @method \Application\Query\GroupQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\GroupQuery distinct()
 * @method \Application\Query\GroupQuery select()
 * @method \Application\Query\GroupQuery addColumns() addColumns($columns)
 * @method \Application\Query\GroupQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\GroupQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\GroupQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\GroupQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\GroupQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\GroupQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\GroupQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class GroupQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\GroupCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('GroupCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Group::TABLENAME, "Group");

        $defaultColumn = array("Group.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\GroupQuery
     */
    public function pk($value){
        $this->filter(array(
            Group::ID_GROUP => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Group::ID_GROUP, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\GroupQuery
     */
    public function filter($fields, $prefix = 'Group'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Group')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_group']) && !empty($fields['id_group']) ){
            $criteria->add(Group::ID_GROUP, $fields['id_group']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(Group::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_workweek']) && !empty($fields['id_workweek']) ){
            $criteria->add(Group::ID_WORKWEEK, $fields['id_workweek']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Group::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Group::STATUS, $fields['status']);
        }
        if( isset($fields['id_user_assigned_for_tickets']) && !empty($fields['id_user_assigned_for_tickets']) ){
        	$criteria->add(Group::ID_USER_ASSIGNED_FOR_TICKETS, $fields['id_user_assigned_for_tickets']);
        }
        if( isset($fields['acl']) && !empty($fields['acl']) ){
        	$criteria->add(Group::ACL, $fields['acl']);
        }
        
        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\GroupQuery
     */
    public function actives(){
        return $this->filter(array(
            Group::STATUS => Group::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\GroupQuery
     */
    public function inactives(){
        return $this->filter(array(
            Group::STATUS => Group::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupQuery
     */
    public function innerJoinUserResponsible($alias = 'Group', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupQuery
     */
    public function innerJoinWorkweek($alias = 'Group', $aliasForeignTable = 'Workweek')
    {
        $this->innerJoinOn(\Application\Model\Bean\Workweek::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_workweek'), array($aliasForeignTable, 'id_workweek'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupQuery
     */
    public function innerJoinUser($alias = 'Group', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn('pcs_symphony_user_group', 'Group2User')
            ->equalFields(array($alias, 'id_group'), array('Group2User', 'id_group'));

        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Group2User', 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupQuery
     */
    public function innerJoinUserForTickets($alias = 'Group', $aliasForeignTable = 'User')
    {
    	$this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_user_assigned_for_ticket'), array($aliasForeignTable, 'id_user'));
    
    	return $this;
    }

}