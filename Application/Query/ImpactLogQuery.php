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
use Application\Model\Catalog\ImpactLogCatalog;
use Application\Model\Bean\ImpactLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ImpactLogQuery
 *
 * @method \Application\Query\ImpactLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ImpactLogQuery useMemoryCache()
 * @method \Application\Query\ImpactLogQuery useFileCache()
 * @method \Application\Model\Collection\ImpactLogCollection find()
 * @method \Application\Model\Bean\ImpactLog findOne()
 * @method \Application\Model\Bean\ImpactLog findOneOrElse() findOneOrElse(ImpactLog $alternative)
 * @method \Application\Model\Bean\ImpactLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ImpactLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ImpactLog findByPKOrElse() findByPKOrElse($pk, ImpactLog $alternative)
 * @method \Application\Model\Bean\ImpactLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ImpactLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ImpactLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ImpactLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ImpactLogQuery removeJoins()
 * @method \Application\Query\ImpactLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ImpactLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ImpactLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ImpactLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ImpactLogQuery bind() bind($parameters)
 * @method \Application\Query\ImpactLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ImpactLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ImpactLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ImpactLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ImpactLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ImpactLogQuery distinct()
 * @method \Application\Query\ImpactLogQuery select()
 * @method \Application\Query\ImpactLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ImpactLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ImpactLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ImpactLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ImpactLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ImpactLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ImpactLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ImpactLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ImpactLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ImpactLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ImpactLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ImpactLog::TABLENAME, "ImpactLog");

        $defaultColumn = array("ImpactLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ImpactLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ImpactLog::ID_IMPACT_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ImpactLog::ID_IMPACT_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ImpactLogQuery
     */
    public function filter($fields, $prefix = 'ImpactLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ImpactLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_impact_log']) && !empty($fields['id_impact_log']) ){
            $criteria->add(ImpactLog::ID_IMPACT_LOG, $fields['id_impact_log']);
        }
        if( isset($fields['id_impact']) && !empty($fields['id_impact']) ){
            $criteria->add(ImpactLog::ID_IMPACT, $fields['id_impact']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ImpactLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ImpactLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(ImpactLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ImpactLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ImpactLogQuery
     */
    public function innerJoinImpact($alias = 'ImpactLog', $aliasForeignTable = 'Impact')
    {
        $this->innerJoinOn(\Application\Model\Bean\Impact::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_impact'), array($aliasForeignTable, 'id_impact'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ImpactLogQuery
     */
    public function innerJoinUser($alias = 'ImpactLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}