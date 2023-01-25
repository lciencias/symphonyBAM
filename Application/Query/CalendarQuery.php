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
use Application\Model\Catalog\CalendarCatalog;
use Application\Model\Bean\Calendar;

use Application\Query\BaseQuery;

/**
 * Application\Query\CalendarQuery
 *
 * @method \Application\Query\CalendarQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CalendarQuery useMemoryCache()
 * @method \Application\Query\CalendarQuery useFileCache()
 * @method \Application\Model\Collection\CalendarCollection find()
 * @method \Application\Model\Bean\Calendar findOne()
 * @method \Application\Model\Bean\Calendar findOneOrElse() findOneOrElse(Calendar $alternative)
 * @method \Application\Model\Bean\Calendar findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Calendar findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Calendar findByPKOrElse() findByPKOrElse($pk, Calendar $alternative)
 * @method \Application\Model\Bean\Calendar findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CalendarQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CalendarQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CalendarQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CalendarQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CalendarQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CalendarQuery removeJoins()
 * @method \Application\Query\CalendarQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CalendarQuery from() from($table, $alias = null)
 * @method \Application\Query\CalendarQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CalendarQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CalendarQuery bind() bind($parameters)
 * @method \Application\Query\CalendarQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CalendarQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CalendarQuery setLimit() setLimit($limit)
 * @method \Application\Query\CalendarQuery setOffset() setOffset($offset)
 * @method \Application\Query\CalendarQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CalendarQuery distinct()
 * @method \Application\Query\CalendarQuery select()
 * @method \Application\Query\CalendarQuery addColumns() addColumns($columns)
 * @method \Application\Query\CalendarQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CalendarQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CalendarQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CalendarQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CalendarQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CalendarQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CalendarQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CalendarQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CalendarCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CalendarCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Calendar::TABLENAME, "Calendar");

        $defaultColumn = array("Calendar.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\CalendarQuery
     */
    public function pk($value){
        $this->filter(array(
            Calendar::ID_CALENDAR => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Calendar::ID_CALENDAR, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CalendarQuery
     */
    public function filter($fields, $prefix = 'Calendar'){
        $this->build($this, $fields, $prefix);
        return $this;
    }


    /**
     * build fromArray
     * @param string $prefix
     * @return Application\Query\CalendarQuery
     */
    public function holiday($prefix = 'Calendar'){
        $this->build($this, array('is_holiday' => 1), $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Calendar')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_calendar']) && !empty($fields['id_calendar']) ){
            $criteria->add(Calendar::ID_CALENDAR, $fields['id_calendar']);
        }
        if( isset($fields['date']) && !empty($fields['date']) ){
            $criteria->add(Calendar::DATE, $fields['date']);
        }
        if( isset($fields['is_weekend']) && !empty($fields['is_weekend']) ){
            $criteria->add(Calendar::IS_WEEKEND, $fields['is_weekend']);
        }
        if( isset($fields['is_holiday']) && !empty($fields['is_holiday']) ){
            $criteria->add(Calendar::IS_HOLIDAY, $fields['is_holiday']);
        }
        if( isset($fields['name_holiday']) && !empty($fields['name_holiday']) ){
            $criteria->add(Calendar::NAME_HOLIDAY, $fields['name_holiday']);
        }
        if( isset($fields['name_holiday']) && !empty($fields['name_holiday']) ){
        	$criteria->add(Calendar::NAME_HOLIDAY, $fields['name_holiday']);
        }
        if( isset($fields['day_number']) && !empty($fields['day_number']) ){
        	$criteria->add(Calendar::DAY_NUMBER, $fields['day_number']);
        }
        

        $criteria->endPrefix();
    }


}