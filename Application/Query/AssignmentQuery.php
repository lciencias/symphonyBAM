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

use Query\Query;
use Application\Model\Catalog\AssignmentCatalog;
use Application\Model\Bean\Assignment;

use Application\Query\BaseQuery;

/**
 * Application\Query\AssignmentQuery
 *
 * @method \Application\Query\AssignmentQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AssignmentQuery useMemoryCache()
 * @method \Application\Query\AssignmentQuery useFileCache()
 * @method \Application\Model\Collection\AssignmentCollection find()
 * @method \Application\Model\Bean\Assignment findOne()
 * @method \Application\Model\Bean\Assignment findOneOrElse() findOneOrElse(Assignment $alternative)
 * @method \Application\Model\Bean\Assignment findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Assignment findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Assignment findByPKOrElse() findByPKOrElse($pk, Assignment $alternative)
 * @method \Application\Model\Bean\Assignment findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AssignmentQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AssignmentQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AssignmentQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AssignmentQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AssignmentQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AssignmentQuery removeJoins()
 * @method \Application\Query\AssignmentQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AssignmentQuery from() from($table, $alias = null)
 * @method \Application\Query\AssignmentQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AssignmentQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AssignmentQuery bind() bind($parameters)
 * @method \Application\Query\AssignmentQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AssignmentQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AssignmentQuery setLimit() setLimit($limit)
 * @method \Application\Query\AssignmentQuery setOffset() setOffset($offset)
 * @method \Application\Query\AssignmentQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AssignmentQuery distinct()
 * @method \Application\Query\AssignmentQuery select()
 * @method \Application\Query\AssignmentQuery addColumns() addColumns($columns)
 * @method \Application\Query\AssignmentQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AssignmentQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AssignmentQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AssignmentQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AssignmentQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AssignmentQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AssignmentQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AssignmentQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AssignmentCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AssignmentCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Assignment::TABLENAME, "Assignment");

        $defaultColumn = array("Assignment.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\AssignmentQuery
     */
    public function pk($value){
        $this->filter(array(
            Assignment::ID_ASSIGNMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Assignment::ID_ASSIGNMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AssignmentQuery
     */
    public function filter($fields, $prefix = 'Assignment'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Assignment')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_assignment']) && !empty($fields['id_assignment']) ){
            $criteria->add(Assignment::ID_ASSIGNMENT, $fields['id_assignment']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Assignment::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(Assignment::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_resolution']) && !empty($fields['id_resolution']) ){
            $criteria->add(Assignment::ID_RESOLUTION, $fields['id_resolution']);
        }
        if( isset($fields['assignment_date']) && !empty($fields['assignment_date']) ){
            $criteria->add(Assignment::ASSIGNMENT_DATE, $fields['assignment_date']);
        }
        if( isset($fields['resolution_date']) && !empty($fields['resolution_date']) ){
            $criteria->add(Assignment::RESOLUTION_DATE, $fields['resolution_date']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(Assignment::NOTE, $fields['note']);
        }
        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
            $criteria->add(Assignment::ID_FILE, $fields['id_file']);
        }
        if( isset($fields['recovery_amount']) && !empty($fields['recovery_amount']) ){
        	$criteria->add(Assignment::RECOVERY_AMOUNT, $fields['recovery_amount']);
        }
        if( isset($fields['is_recovered_amount']) && !empty($fields['is_recovered_amount']) ){
        	$criteria->add(Assignment::IS_RECOVERED_AMOUNT, $fields['is_recovered_amount']);
        }        
        if( isset($fields['id_resolution_file']) && !empty($fields['id_resolution_file']) ){
        	$criteria->add(Assignment::ID_RESOLUTION_FILE, $fields['id_resolution_file']);
        }
    	if( isset($fields['status']) && !empty($fields['status']) ){
        	$criteria->add(Assignment::STATUS, $fields['status']);
        }        
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AssignmentQuery
     */
    public function innerJoinBaseTicket($alias = 'Assignment', $aliasForeignTable = 'BaseTicket')
    {
        $this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AssignmentQuery
     */
    public function innerJoinUser($alias = 'Assignment', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AssignmentQuery
     */
    public function innerJoinResolution($alias = 'Assignment', $aliasForeignTable = 'Resolution')
    {
        $this->innerJoinOn(\Application\Model\Bean\Resolution::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_resolution'), array($aliasForeignTable, 'id_resolution'));

        return $this;
    }
    
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AssignmentQuery
     */
    public function innerJoinResolution2($alias = 'Assignment', $aliasForeignTable = 'Resolution')
    {
        $this->innerJoinOn(\Application\Model\Bean\ClientResolution::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_resolution'), array($aliasForeignTable, 'id_client_resolution'));

        return $this;
    }


}