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
use Application\Model\Catalog\ChannelLogCatalog;
use Application\Model\Bean\ChannelLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ChannelLogQuery
 *
 * @method \Application\Query\ChannelLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ChannelLogQuery useMemoryCache()
 * @method \Application\Query\ChannelLogQuery useFileCache()
 * @method \Application\Model\Collection\ChannelLogCollection find()
 * @method \Application\Model\Bean\ChannelLog findOne()
 * @method \Application\Model\Bean\ChannelLog findOneOrElse() findOneOrElse(ChannelLog $alternative)
 * @method \Application\Model\Bean\ChannelLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ChannelLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ChannelLog findByPKOrElse() findByPKOrElse($pk, ChannelLog $alternative)
 * @method \Application\Model\Bean\ChannelLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ChannelLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ChannelLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ChannelLogQuery removeJoins()
 * @method \Application\Query\ChannelLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ChannelLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ChannelLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ChannelLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ChannelLogQuery bind() bind($parameters)
 * @method \Application\Query\ChannelLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ChannelLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ChannelLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ChannelLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ChannelLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ChannelLogQuery distinct()
 * @method \Application\Query\ChannelLogQuery select()
 * @method \Application\Query\ChannelLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ChannelLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ChannelLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ChannelLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ChannelLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ChannelLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ChannelLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ChannelLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ChannelLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ChannelLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ChannelLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ChannelLog::TABLENAME, "ChannelLog");

        $defaultColumn = array("ChannelLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ChannelLog::ID_CHANNELS_LOGS => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ChannelLog::ID_CHANNELS_LOGS, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelLogQuery
     */
    public function filter($fields, $prefix = 'ChannelLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ChannelLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_channels_logs']) && !empty($fields['id_channels_logs']) ){
            $criteria->add(ChannelLog::ID_CHANNELS_LOGS, $fields['id_channels_logs']);
        }
        if( isset($fields['id_channel']) && !empty($fields['id_channel']) ){
            $criteria->add(ChannelLog::ID_CHANNEL, $fields['id_channel']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ChannelLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ChannelLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ChannelLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ChannelLogQuery
     */
    public function innerJoinChannel($alias = 'ChannelLog', $aliasForeignTable = 'Channel')
    {
        $this->innerJoinOn(\Application\Model\Bean\Channel::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_channel'), array($aliasForeignTable, 'id_channel'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ChannelLogQuery
     */
    public function innerJoinUser($alias = 'ChannelLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}