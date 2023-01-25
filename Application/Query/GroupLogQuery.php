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
use Application\Model\Catalog\GroupLogCatalog;
use Application\Model\Bean\GroupLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\GroupLogQuery
 *
 * @method \Application\Query\GroupLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\GroupLogQuery useMemoryCache()
 * @method \Application\Query\GroupLogQuery useFileCache()
 * @method \Application\Model\Collection\GroupLogCollection find()
 * @method \Application\Model\Bean\GroupLog findOne()
 * @method \Application\Model\Bean\GroupLog findOneOrElse() findOneOrElse(GroupLog $alternative)
 * @method \Application\Model\Bean\GroupLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\GroupLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\GroupLog findByPKOrElse() findByPKOrElse($pk, GroupLog $alternative)
 * @method \Application\Model\Bean\GroupLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\GroupLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\GroupLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\GroupLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\GroupLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\GroupLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\GroupLogQuery removeJoins()
 * @method \Application\Query\GroupLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\GroupLogQuery from() from($table, $alias = null)
 * @method \Application\Query\GroupLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\GroupLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\GroupLogQuery bind() bind($parameters)
 * @method \Application\Query\GroupLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\GroupLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\GroupLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\GroupLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\GroupLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\GroupLogQuery distinct()
 * @method \Application\Query\GroupLogQuery select()
 * @method \Application\Query\GroupLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\GroupLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\GroupLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\GroupLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\GroupLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\GroupLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\GroupLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\GroupLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class GroupLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\GroupLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('GroupLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(GroupLog::TABLENAME, "GroupLog");

        $defaultColumn = array("GroupLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\GroupLogQuery
     */
    public function pk($value){
        $this->filter(array(
            GroupLog::ID_GROUP_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(GroupLog::ID_GROUP_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\GroupLogQuery
     */
    public function filter($fields, $prefix = 'GroupLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'GroupLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_group_log']) && !empty($fields['id_group_log']) ){
            $criteria->add(GroupLog::ID_GROUP_LOG, $fields['id_group_log']);
        }
        if( isset($fields['id_group']) && !empty($fields['id_group']) ){
            $criteria->add(GroupLog::ID_GROUP, $fields['id_group']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(GroupLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(GroupLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(GroupLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(GroupLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupLogQuery
     */
    public function innerJoinGroup($alias = 'GroupLog', $aliasForeignTable = 'Group')
    {
        $this->innerJoinOn(\Application\Model\Bean\Group::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_group'), array($aliasForeignTable, 'id_group'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\GroupLogQuery
     */
    public function innerJoinUser($alias = 'GroupLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}