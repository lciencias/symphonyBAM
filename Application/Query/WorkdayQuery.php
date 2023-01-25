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
use Application\Model\Catalog\WorkdayCatalog;
use Application\Model\Bean\Workday;

use Application\Query\BaseQuery;

/**
 * Application\Query\WorkdayQuery
 *
 * @method \Application\Query\WorkdayQuery pk() pk(int $primaryKey)
 * @method \Application\Query\WorkdayQuery useMemoryCache()
 * @method \Application\Query\WorkdayQuery useFileCache()
 * @method \Application\Model\Collection\WorkdayCollection find()
 * @method \Application\Model\Bean\Workday findOne()
 * @method \Application\Model\Bean\Workday findOneOrElse() findOneOrElse(Workday $alternative)
 * @method \Application\Model\Bean\Workday findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Workday findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Workday findByPKOrElse() findByPKOrElse($pk, Workday $alternative)
 * @method \Application\Model\Bean\Workday findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\WorkdayQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\WorkdayQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\WorkdayQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\WorkdayQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\WorkdayQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\WorkdayQuery removeJoins()
 * @method \Application\Query\WorkdayQuery removeJoin() removeJoin($table)
 * @method \Application\Query\WorkdayQuery from() from($table, $alias = null)
 * @method \Application\Query\WorkdayQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\WorkdayQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\WorkdayQuery bind() bind($parameters)
 * @method \Application\Query\WorkdayQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\WorkdayQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\WorkdayQuery setLimit() setLimit($limit)
 * @method \Application\Query\WorkdayQuery setOffset() setOffset($offset)
 * @method \Application\Query\WorkdayQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\WorkdayQuery distinct()
 * @method \Application\Query\WorkdayQuery select()
 * @method \Application\Query\WorkdayQuery addColumns() addColumns($columns)
 * @method \Application\Query\WorkdayQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\WorkdayQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\WorkdayQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\WorkdayQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\WorkdayQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\WorkdayQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\WorkdayQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class WorkdayQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\WorkdayCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('WorkdayCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Workday::TABLENAME, "Workday");

        $defaultColumn = array("Workday.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\WorkdayQuery
     */
    public function pk($value){
        $this->filter(array(
            Workday::ID_WORKDAY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Workday::ID_WORKDAY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\WorkdayQuery
     */
    public function filter($fields, $prefix = 'Workday'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Workday')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_workday']) && !empty($fields['id_workday']) ){
            $criteria->add(Workday::ID_WORKDAY, $fields['id_workday']);
        }
        if( isset($fields['id_workweek']) && !empty($fields['id_workweek']) ){
            $criteria->add(Workday::ID_WORKWEEK, $fields['id_workweek']);
        }
        if( isset($fields['day_of_week']) && !empty($fields['day_of_week']) ){
            $criteria->add(Workday::DAY_OF_WEEK, $fields['day_of_week']);
        }
        if( isset($fields['start_time']) && !empty($fields['start_time']) ){
            $criteria->add(Workday::START_TIME, $fields['start_time']);
        }
        if( isset($fields['lunch_start_time']) && !empty($fields['lunch_start_time']) ){
            $criteria->add(Workday::LUNCH_START_TIME, $fields['lunch_start_time']);
        }
        if( isset($fields['lunch_end_time']) && !empty($fields['lunch_end_time']) ){
            $criteria->add(Workday::LUNCH_END_TIME, $fields['lunch_end_time']);
        }
        if( isset($fields['end_time']) && !empty($fields['end_time']) ){
            $criteria->add(Workday::END_TIME, $fields['end_time']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\WorkdayQuery
     */
    public function innerJoinWorkweek($alias = 'Workday', $aliasForeignTable = 'Workweek')
    {
        $this->innerJoinOn(\Application\Model\Bean\Workweek::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_workweek'), array($aliasForeignTable, 'id_workweek'));

        return $this;
    }


}