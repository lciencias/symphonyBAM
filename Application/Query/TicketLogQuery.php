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
use Application\Model\Catalog\TicketLogCatalog;
use Application\Model\Bean\TicketLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketLogQuery
 *
 * @method \Application\Query\TicketLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketLogQuery useMemoryCache()
 * @method \Application\Query\TicketLogQuery useFileCache()
 * @method \Application\Model\Collection\TicketLogCollection find()
 * @method \Application\Model\Bean\TicketLog findOne()
 * @method \Application\Model\Bean\TicketLog findOneOrElse() findOneOrElse(TicketLog $alternative)
 * @method \Application\Model\Bean\TicketLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketLog findByPKOrElse() findByPKOrElse($pk, TicketLog $alternative)
 * @method \Application\Model\Bean\TicketLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketLogQuery removeJoins()
 * @method \Application\Query\TicketLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketLogQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketLogQuery bind() bind($parameters)
 * @method \Application\Query\TicketLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketLogQuery distinct()
 * @method \Application\Query\TicketLogQuery select()
 * @method \Application\Query\TicketLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketLog::TABLENAME, "TicketLog");

        $defaultColumn = array("TicketLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketLogQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketLog::ID_TICKET_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketLog::ID_TICKET_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketLogQuery
     */
    public function filter($fields, $prefix = 'TicketLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_log']) && !empty($fields['id_ticket_log']) ){
            $criteria->add(TicketLog::ID_TICKET_LOG, $fields['id_ticket_log']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(TicketLog::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(TicketLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(TicketLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(TicketLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['changed_from']) && !empty($fields['changed_from']) ){
            $criteria->add(TicketLog::CHANGED_FROM, $fields['changed_from']);
        }
        if( isset($fields['changed_to']) && !empty($fields['changed_to']) ){
            $criteria->add(TicketLog::CHANGED_TO, $fields['changed_to']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(TicketLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketLogQuery
     */
    public function innerJoinTicket($alias = 'TicketLog', $aliasForeignTable = 'Ticket')
    {
        $this->innerJoinOn(\Application\Model\Bean\Ticket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket'), array($aliasForeignTable, 'id_ticket'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketLogQuery
     */
    public function innerJoinUser($alias = 'TicketLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}