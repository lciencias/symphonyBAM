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
use Application\Model\Catalog\UserLogCatalog;
use Application\Model\Bean\UserLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\UserLogQuery
 *
 * @method \Application\Query\UserLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\UserLogQuery useMemoryCache()
 * @method \Application\Query\UserLogQuery useFileCache()
 * @method \Application\Model\Collection\UserLogCollection find()
 * @method \Application\Model\Bean\UserLog findOne()
 * @method \Application\Model\Bean\UserLog findOneOrElse() findOneOrElse(UserLog $alternative)
 * @method \Application\Model\Bean\UserLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\UserLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\UserLog findByPKOrElse() findByPKOrElse($pk, UserLog $alternative)
 * @method \Application\Model\Bean\UserLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\UserLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\UserLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\UserLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\UserLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\UserLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\UserLogQuery removeJoins()
 * @method \Application\Query\UserLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\UserLogQuery from() from($table, $alias = null)
 * @method \Application\Query\UserLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\UserLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\UserLogQuery bind() bind($parameters)
 * @method \Application\Query\UserLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\UserLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\UserLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\UserLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\UserLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\UserLogQuery distinct()
 * @method \Application\Query\UserLogQuery select()
 * @method \Application\Query\UserLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\UserLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\UserLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\UserLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\UserLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\UserLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\UserLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\UserLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class UserLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\UserLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('UserLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(UserLog::TABLENAME, "UserLog");

        $defaultColumn = array("UserLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\UserLogQuery
     */
    public function pk($value){
        $this->filter(array(
            UserLog::ID_USER_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(UserLog::ID_USER_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\UserLogQuery
     */
    public function filter($fields, $prefix = 'UserLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'UserLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_user_log']) && !empty($fields['id_user_log']) ){
            $criteria->add(UserLog::ID_USER_LOG, $fields['id_user_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(UserLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(UserLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['ip']) && !empty($fields['ip']) ){
            $criteria->add(UserLog::IP, $fields['ip']);
        }
        if( isset($fields['id_responsible']) && !empty($fields['id_responsible']) ){
            $criteria->add(UserLog::ID_RESPONSIBLE, $fields['id_responsible']);
        }
        if( isset($fields['timestamp']) && !empty($fields['timestamp']) ){
            $criteria->add(UserLog::TIMESTAMP, $fields['timestamp']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(UserLog::NOTE, $fields['note']);
        }
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\UserLogQuery
     */
    public function innerJoinUser($alias = 'UserLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}