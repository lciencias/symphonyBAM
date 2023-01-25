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
use Application\Model\Catalog\TicketTypeLogCatalog;
use Application\Model\Bean\TicketTypeLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketTypeLogQuery
 *
 * @method \Application\Query\TicketTypeLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketTypeLogQuery useMemoryCache()
 * @method \Application\Query\TicketTypeLogQuery useFileCache()
 * @method \Application\Model\Collection\TicketTypeLogCollection find()
 * @method \Application\Model\Bean\TicketTypeLog findOne()
 * @method \Application\Model\Bean\TicketTypeLog findOneOrElse() findOneOrElse(TicketTypeLog $alternative)
 * @method \Application\Model\Bean\TicketTypeLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketTypeLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketTypeLog findByPKOrElse() findByPKOrElse($pk, TicketTypeLog $alternative)
 * @method \Application\Model\Bean\TicketTypeLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketTypeLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery removeJoins()
 * @method \Application\Query\TicketTypeLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketTypeLogQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketTypeLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketTypeLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketTypeLogQuery bind() bind($parameters)
 * @method \Application\Query\TicketTypeLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketTypeLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketTypeLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketTypeLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketTypeLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketTypeLogQuery distinct()
 * @method \Application\Query\TicketTypeLogQuery select()
 * @method \Application\Query\TicketTypeLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketTypeLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketTypeLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketTypeLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketTypeLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketTypeLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketTypeLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketTypeLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketTypeLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketTypeLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketTypeLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketTypeLog::TABLENAME, "TicketTypeLog");

        $defaultColumn = array("TicketTypeLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketTypeLogQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketTypeLog::ID_TICKET_TYPE_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketTypeLog::ID_TICKET_TYPE_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketTypeLogQuery
     */
    public function filter($fields, $prefix = 'TicketTypeLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketTypeLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_type_log']) && !empty($fields['id_ticket_type_log']) ){
            $criteria->add(TicketTypeLog::ID_TICKET_TYPE_LOG, $fields['id_ticket_type_log']);
        }
        if( isset($fields['id_ticket_type']) && !empty($fields['id_ticket_type']) ){
            $criteria->add(TicketTypeLog::ID_TICKET_TYPE, $fields['id_ticket_type']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(TicketTypeLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(TicketTypeLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_log']) && !empty($fields['event_log']) ){
            $criteria->add(TicketTypeLog::EVENT_LOG, $fields['event_log']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(TicketTypeLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketTypeLogQuery
     */
    public function innerJoinTicketType($alias = 'TicketTypeLog', $aliasForeignTable = 'TicketType')
    {
        $this->innerJoinOn(\Application\Model\Bean\TicketType::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket_type'), array($aliasForeignTable, 'id_ticket_type'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketTypeLogQuery
     */
    public function innerJoinUser($alias = 'TicketTypeLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}