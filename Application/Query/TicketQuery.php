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

use Application\Model\Bean\Impact;

use Application\Model\Bean\Priority;

use Application\Model\Bean\Company;

use Application\Model\Bean\Employee;

use Query\Query;
use Application\Model\Catalog\TicketCatalog;
use Application\Model\Bean\Ticket;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketQuery
 *
 * @method \Application\Query\TicketQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketQuery useMemoryCache()
 * @method \Application\Query\TicketQuery useFileCache()
 * @method \Application\Model\Collection\TicketCollection find()
 * @method \Application\Model\Bean\Ticket findOne()
 * @method \Application\Model\Bean\Ticket findOneOrElse() findOneOrElse(Ticket $alternative)
 * @method \Application\Model\Bean\Ticket findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Ticket findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Ticket findByPKOrElse() findByPKOrElse($pk, Ticket $alternative)
 * @method \Application\Model\Bean\Ticket findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketQuery removeJoins()
 * @method \Application\Query\TicketQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketQuery bind() bind($parameters)
 * @method \Application\Query\TicketQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketQuery distinct()
 * @method \Application\Query\TicketQuery select()
 * @method \Application\Query\TicketQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketQuery extends BaseTicketQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Ticket::TABLENAME, "Ticket");
        $this->innerJoinBaseTicket();

        $defaultColumn = array("Ticket.*");
        $defaultColumn[] = "BaseTicket.*";
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketQuery
     */
    public function pk($value){
        $this->filter(array(
            Ticket::ID_TICKET => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Ticket::ID_TICKET, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketQuery
     */
    public function filter($fields, $prefix = 'Ticket'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Ticket')
    {
        parent::build($query, $fields);

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket']) && !empty($fields['id_ticket']) ){
            $criteria->add(Ticket::ID_TICKET, $fields['id_ticket']);
        }
        if( isset($fields['id_category']) && !empty($fields['id_category']) ){
            $criteria->add(Ticket::ID_CATEGORY, $fields['id_category']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Ticket::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_employee']) && !empty($fields['id_employee']) ){
            $criteria->add(Ticket::ID_EMPLOYEE, $fields['id_employee']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Ticket::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['id_priority']) && !empty($fields['id_priority']) ){
            $criteria->add(Ticket::ID_PRIORITY, $fields['id_priority']);
        }
        if( isset($fields['id_impact']) && !empty($fields['id_impact']) ){
            $criteria->add(Ticket::ID_IMPACT, $fields['id_impact']);
        }

        $criteria->endPrefix();

        if( isset($fields['employee_fullname']) && !empty($fields['employee_fullname']) ){
            $query->innerJoinEmployee($prefix)
                ->innerJoinOn(\Application\Model\Bean\Person::TABLENAME, 'Person')
                ->equalFields(array('Employee', 'id_person'), array('Person', 'id_person'));
            PersonQuery::build($query, array('fullname' => $fields['employee_fullname']));
        }

    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoinBaseTicket($alias = 'Ticket', $aliasForeignTable = 'BaseTicket')
    {
        $this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoinCategory($alias = 'Ticket', $aliasForeignTable = 'Category')
    {
        $this->innerJoinOn(Category::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_category'), array($aliasForeignTable, 'id_category'));

        return $this;
    }
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoin($alias = 'Ticket', $aliasForeignTable = 'Employee')
    {
        $this->innerJoinOn(Employee::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_employee'), array($aliasForeignTable, 'id_employee'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoinCompany($alias = 'Ticket', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoinPriority($alias = 'Ticket', $aliasForeignTable = 'Priority')
    {
        $this->innerJoinOn(Priority::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_priority'), array($aliasForeignTable, 'id_priority'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketQuery
     */
    public function innerJoinImpact($alias = 'Ticket', $aliasForeignTable = 'Impact')
    {
        $this->innerJoinOn(Impact::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_impact'), array($aliasForeignTable, 'id_impact'));

        return $this;
    }


}