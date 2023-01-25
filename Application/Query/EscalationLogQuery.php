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
use Application\Model\Catalog\EscalationLogCatalog;
use Application\Model\Bean\EscalationLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\EscalationLogQuery
 *
 * @method \Application\Query\EscalationLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EscalationLogQuery useMemoryCache()
 * @method \Application\Query\EscalationLogQuery useFileCache()
 * @method \Application\Model\Collection\EscalationLogCollection find()
 * @method \Application\Model\Bean\EscalationLog findOne()
 * @method \Application\Model\Bean\EscalationLog findOneOrElse() findOneOrElse(EscalationLog $alternative)
 * @method \Application\Model\Bean\EscalationLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\EscalationLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\EscalationLog findByPKOrElse() findByPKOrElse($pk, EscalationLog $alternative)
 * @method \Application\Model\Bean\EscalationLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EscalationLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EscalationLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EscalationLogQuery removeJoins()
 * @method \Application\Query\EscalationLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EscalationLogQuery from() from($table, $alias = null)
 * @method \Application\Query\EscalationLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EscalationLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EscalationLogQuery bind() bind($parameters)
 * @method \Application\Query\EscalationLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EscalationLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EscalationLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\EscalationLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\EscalationLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EscalationLogQuery distinct()
 * @method \Application\Query\EscalationLogQuery select()
 * @method \Application\Query\EscalationLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\EscalationLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EscalationLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EscalationLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EscalationLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EscalationLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EscalationLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EscalationLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EscalationLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\EscalationLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EscalationLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(EscalationLog::TABLENAME, "EscalationLog");

        $defaultColumn = array("EscalationLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\EscalationLogQuery
     */
    public function pk($value){
        $this->filter(array(
            EscalationLog::ID_ESCALATION_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(EscalationLog::ID_ESCALATION_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EscalationLogQuery
     */
    public function filter($fields, $prefix = 'EscalationLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'EscalationLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_escalation_log']) && !empty($fields['id_escalation_log']) ){
            $criteria->add(EscalationLog::ID_ESCALATION_LOG, $fields['id_escalation_log']);
        }
        if( isset($fields['id_escalation']) && !empty($fields['id_escalation']) ){
            $criteria->add(EscalationLog::ID_ESCALATION, $fields['id_escalation']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(EscalationLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(EscalationLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(EscalationLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(EscalationLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EscalationLogQuery
     */
    public function innerJoinEscalation($alias = 'EscalationLog', $aliasForeignTable = 'Escalation')
    {
        $this->innerJoinOn(\Application\Model\Bean\Escalation::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_escalation'), array($aliasForeignTable, 'id_escalation'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EscalationLogQuery
     */
    public function innerJoinUser($alias = 'EscalationLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}