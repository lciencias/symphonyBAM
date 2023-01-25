<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Application\Model\Bean\Employee;

use Query\Query;
use Application\Model\Catalog\ActivityCatalog;
use Application\Model\Bean\Activity;

use Application\Query\BaseQuery;

/**
 * Application\Query\ActivityQuery
 *
 * @method \Application\Query\ActivityQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ActivityQuery useMemoryCache()
 * @method \Application\Query\ActivityQuery useFileCache()
 * @method \Application\Model\Collection\ActivityCollection find()
 * @method \Application\Model\Bean\Activity findOne()
 * @method \Application\Model\Bean\Activity findOneOrElse() findOneOrElse(Activity $alternative)
 * @method \Application\Model\Bean\Activity findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Activity findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Activity findByPKOrElse() findByPKOrElse($pk, Activity $alternative)
 * @method \Application\Model\Bean\Activity findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ActivityQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ActivityQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ActivityQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ActivityQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ActivityQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ActivityQuery removeJoins()
 * @method \Application\Query\ActivityQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ActivityQuery from() from($table, $alias = null)
 * @method \Application\Query\ActivityQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ActivityQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ActivityQuery bind() bind($parameters)
 * @method \Application\Query\ActivityQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ActivityQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ActivityQuery setLimit() setLimit($limit)
 * @method \Application\Query\ActivityQuery setOffset() setOffset($offset)
 * @method \Application\Query\ActivityQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ActivityQuery distinct()
 * @method \Application\Query\ActivityQuery select()
 * @method \Application\Query\ActivityQuery addColumns() addColumns($columns)
 * @method \Application\Query\ActivityQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ActivityQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ActivityQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ActivityQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ActivityQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ActivityQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ActivityQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ActivityQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ActivityCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ActivityCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Activity::TABLENAME, "Activity");

        $defaultColumn = array("Activity.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ActivityQuery
     */
    public function pk($value){
        $this->filter(array(
            Activity::ID_ACTIVITY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Activity::ID_ACTIVITY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ActivityQuery
     */
    public function filter($fields, $prefix = 'Activity'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Activity')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_activity']) && !empty($fields['id_activity']) ){
            $criteria->add(Activity::ID_ACTIVITY, $fields['id_activity']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Activity::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(Activity::ID_USER, $fields['id_user']);
        }
        
        if( isset($fields['start_date']) && !empty($fields['start_date']) ){
            $criteria->add(Activity::START_DATE, $fields['start_date']);
        }
        if( isset($fields['end_date']) && !empty($fields['end_date']) ){
            $criteria->add(Activity::END_DATE, $fields['end_date']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(Activity::NOTE, $fields['note']);
        }
        if( isset($fields['activity_start_date']) && !empty($fields['activity_start_date']) ){
            $criteria->add(Activity::START_DATE, $fields['activity_start_date'].':00', self::GREATER_OR_EQUAL);
        }
        if( isset($fields['activity_end_date']) && !empty($fields['activity_end_date']) ){
            $criteria->add(Activity::START_DATE, $fields['activity_end_date'].':00', self::LESS_OR_EQUAL);
        }
        if( !empty($fields['id_company']) || !empty($fields['id_location']) || !empty($fields['id_area']) ){
            $query->innerJoinTicket()
                ->innerJoinOn(Employee::TABLENAME, 'Employee')
                ->equalFields('Ticket.id_employee', 'Employee.id_employee')->endJoin();

            EmployeeQuery::build($query, array(
                'id_company' => $fields['id_company'],
                'id_location' => $fields['id_location'],
                'id_area' => $fields['id_area'],
            ));
        }

        if( !empty($fields['register_end_date']) || !empty($fields['register_start_date'])
            || !empty($fields['status']) || !empty($fields['id_category']) || !empty($fields['id_channel']) ){
            if( !$query->hasJoin('Ticket') ){
                $query->innerJoinTicket();
            }

            TicketQuery::build($query, array(
                'start_created_date' => $fields['register_start_date'],
                'end_created_date' => $fields['register_end_date'],
                'status' => $fields['status'],
                'id_category' => $fields['id_category'],
                'id_channel' => $fields['id_channel'],
            ));
        }
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ActivityQuery
     */
    public function innerJoinUser($alias = 'Activity', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

       /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ActivityQuery
     */
    public function innerJoinBaseTicket($alias = 'Activity', $aliasForeignTable = 'BaseTicket')
    {
        $this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ActivityQuery
     */
    public function innerJoinTicket($alias = 'Activity', $aliasForeignTable = 'Ticket')
    {
    	$this->innerJoinOn(\Application\Model\Bean\Ticket::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));
    
    	return $this;
    }
}