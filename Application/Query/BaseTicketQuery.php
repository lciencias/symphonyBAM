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

use Application\Model\Bean\Category;

use Application\Model\Bean\Assignment;

use Application\Model\Bean\User;

use Application\Model\Bean\TicketType;

use Application\Model\Bean\Channel;

use Query\Query;
use Application\Model\Catalog\BaseTicketCatalog;
use Application\Model\Bean\BaseTicket;

use Application\Query\BaseQuery;

/**
 * Application\Query\BaseTicketQuery
 *
 * @method \Application\Query\BaseTicketQuery pk() pk(int $primaryKey)
 * @method \Application\Query\BaseTicketQuery useMemoryCache()
 * @method \Application\Query\BaseTicketQuery useFileCache()
 * @method \Application\Model\Collection\BaseTicketCollection find()
 * @method \Application\Model\Bean\BaseTicket findOne()
 * @method \Application\Model\Bean\BaseTicket findOneOrElse() findOneOrElse(BaseTicket $alternative)
 * @method \Application\Model\Bean\BaseTicket findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\BaseTicket findByPK() findByPK($pk)
 * @method \Application\Model\Bean\BaseTicket findByPKOrElse() findByPKOrElse($pk, BaseTicket $alternative)
 * @method \Application\Model\Bean\BaseTicket findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\BaseTicketQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\BaseTicketQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\BaseTicketQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\BaseTicketQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\BaseTicketQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\BaseTicketQuery removeJoins()
 * @method \Application\Query\BaseTicketQuery removeJoin() removeJoin($table)
 * @method \Application\Query\BaseTicketQuery from() from($table, $alias = null)
 * @method \Application\Query\BaseTicketQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\BaseTicketQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\BaseTicketQuery bind() bind($parameters)
 * @method \Application\Query\BaseTicketQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\BaseTicketQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\BaseTicketQuery setLimit() setLimit($limit)
 * @method \Application\Query\BaseTicketQuery setOffset() setOffset($offset)
 * @method \Application\Query\BaseTicketQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\BaseTicketQuery distinct()
 * @method \Application\Query\BaseTicketQuery select()
 * @method \Application\Query\BaseTicketQuery addColumns() addColumns($columns)
 * @method \Application\Query\BaseTicketQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\BaseTicketQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\BaseTicketQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\BaseTicketQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\BaseTicketQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\BaseTicketQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\BaseTicketQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class BaseTicketQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\BaseTicketCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('BaseTicketCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(BaseTicket::TABLENAME, "BaseTicket");

        $defaultColumn = array("BaseTicket.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\BaseTicketQuery
     */
    public function pk($value){
        $this->filter(array(
            BaseTicket::ID_BASE_TICKET => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(BaseTicket::ID_BASE_TICKET, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\BaseTicketQuery
     */
    public function filter($fields, $prefix = 'BaseTicket'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'BaseTicket')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(BaseTicket::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_channel']) && !empty($fields['id_channel']) ){
            $criteria->add(BaseTicket::ID_CHANNEL, $fields['id_channel']);
        }
        if( isset($fields['id_ticket_type']) && !empty($fields['id_ticket_type']) ){
            $criteria->add(BaseTicket::ID_TICKET_TYPE, $fields['id_ticket_type']);
        }
        if( isset($fields['id_ticket_type_sin']) && !empty($fields['id_ticket_type_sin']) ){
        	$criteria->add(BaseTicket::ID_TICKET_TYPE, $fields['id_ticket_type_sin'],' != ');
        }               
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(BaseTicket::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_assignment']) && !empty($fields['id_assignment']) ){
            $criteria->add(BaseTicket::ID_ASSIGNMENT, $fields['id_assignment']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(BaseTicket::STATUS, $fields['status']);
        }
        if( isset($fields['description']) && !empty($fields['description']) ){
            $criteria->add(BaseTicket::DESCRIPTION, $fields['description']);
        }
        if( isset($fields['created']) && !empty($fields['created']) ){
            $criteria->add(BaseTicket::CREATED, $fields['created']);
        }
        if( isset($fields['registry']) && !empty($fields['registry']) ){
        	$criteria->add(BaseTicket::REGISTRY, $fields['registry']);
        }
        if( isset($fields['scheduled_date']) && !empty($fields['scheduled_date']) ){
            $criteria->add(BaseTicket::SCHEDULED_DATE, $fields['scheduled_date']);
        }
        if( isset($fields['is_stopped']) && !empty($fields['is_stopped']) ){
            $criteria->add(BaseTicket::IS_STOPPED, $fields['is_stopped']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(BaseTicket::TYPE, $fields['type']);
        }

        $criteria->endPrefix();
        
        if( !empty($fields['id_location']) || !empty($fields['id_area']) ){
        
        	if( !$query->hasJoin('Employee') ){
        		$query->innerJoinEmployee($prefix);
        	}
        
        	EmployeeQuery::build($query, array(
        			'id_location' => $fields['id_location'],
        			'id_area' => $fields['id_area'],
        	));
        }
        
        if( isset($fields['id_user_assigned']) && !empty($fields['id_user_assigned']) ){
        	//$query->innerJoinUserAssigned($prefix);
        	//$criteria->add('UserAssigned.id_user', $fields['id_user_assigned']);
        	$query->innerJoinAssignment($prefix);
        	$criteria->add('Assignment.id_user', $fields['id_user_assigned']);
        }
    }



    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BaseTicketQuery
     */
    public function innerJoinChannel($alias = 'BaseTicket', $aliasForeignTable = 'Channel')
    {
        $this->innerJoinOn(Channel::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_channel'), array($aliasForeignTable, 'id_channel'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BaseTicketQuery
     */
    public function innerJoinTicketType($alias = 'BaseTicket', $aliasForeignTable = 'TicketType')
    {
        $this->innerJoinOn(TicketType::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket_type'), array($aliasForeignTable, 'id_ticket_type'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BaseTicketQuery
     */
    public function innerJoinUserAssigned($alias = 'BaseTicket', $aliasForeignTable = 'UserAssigned')
    {
        $this->innerJoinOn(User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BaseTicketQuery
     */
    public function innerJoinAssignment($alias = 'BaseTicket', $aliasForeignTable = 'Assignment')
    {
        $this->innerJoinOn(Assignment::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_assignment'), array($aliasForeignTable, 'id_assignment'));

        return $this;
    }


}