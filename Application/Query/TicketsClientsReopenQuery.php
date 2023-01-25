<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Bean\TicketsClientsReopen;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;

/**
 * Application\Query\TicketsClientsTransactionsQuery
 *
 * @method \Application\Query\TicketsClientsReopenQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketsClientsReopenQuery useMemoryCache()
 * @method \Application\Query\TicketsClientsReopenQuery useFileCache()
 * @method \Application\Model\Collection\TicketsClientsReopenCollection find()
 * @method \Application\Model\Bean\TicketsClientsReopen findOne()
 * @method \Application\Model\Bean\TicketsClientsReopen findOneOrElse() findOneOrElse(TicketsClientsReopen $alternative)
 * @method \Application\Model\Bean\TicketsClientsReopen findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketsClientsReopen findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketsClientsReopen findByPKOrElse() findByPKOrElse($pk, TicketsClientsReopen $alternative)
 * @method \Application\Model\Bean\TicketsClientsReopen findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketsClientsReopenQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery removeJoins()
 * @method \Application\Query\TicketsClientsReopenQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketsClientsReopenQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketsClientsReopenQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketsClientsReopenQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketsClientsReopenQuery bind() bind($parameters)
 * @method \Application\Query\TicketsClientsReopenQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketsClientsReopenQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketsClientsReopenQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketsClientsReopenQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketsClientsReopenQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketsClientsReopenQuery distinct()
 * @method \Application\Query\TicketsClientsReopenQuery select()
 * @method \Application\Query\TicketsClientsReopenQuery pk() pk($id)
 * @method \Application\Query\TicketsClientsReopenQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\TicketsClientsReopenQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketsClientsReopenQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketsClientsReopenQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketsClientsReopenQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketsClientsReopenQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketsClientsReopenQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketsClientsReopenQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketsClientsReopenQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketsClientsReopenQuery extends BaseQuery{

	
	/**
	 *
	 * @return \Application\Model\Catalog\CompanyCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('TicketsClientsReopenCatalog');
	}
	

	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(TicketsClientsReopen::TABLENAME, "TicketsClientsReopen");
	
		$defaultColumn = array("TicketsClientsReopen.*");
		$this->setDefaultColumn($defaultColumn);
		$this->setStorage(StorageFactory::create('memory'));
	}
	

    /**
     * @param mixed $value
     * @return Application\Query\TicketsClientsReopenQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketsClientsReopen ::ID => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketsClientsReopen::ID, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketsClientsReopenQuery
     */
    public function filter($fields, $prefix = 'TicketsClientsReopen'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketsClientsReopen')
    {
        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id']) && !empty($fields['id']) ){
            $criteria->add(TicketsClientsReopen::ID, $fields['id']);
        }
        if( isset($fields['id_ticket_client']) && !empty($fields['id_ticket_client']) ){
            $criteria->add(TicketsClientsReopen::ID_TICKET_CLIENT, $fields['id_ticket_client']);
        }        
        if( isset($fields['id_ticket_client_transaction']) && !empty($fields['id_ticket_client_transaction']) ){
        	$criteria->add(TicketsClientsReopen::ID_TICKET_CLIENT_TRANSACTION, $fields['id_ticket_client_transaction']);
        }
        if( isset($fields['amount']) && !empty($fields['amount']) ){
        	$criteria->add(TicketsClientsReopen::AMOUNT, $fields['amount']);
        }
        if( isset($fields['good_faith_payment']) && !empty($fields['good_faith_payment']) ){
        	$criteria->add(TicketsClientsReopen::GOOD_FAITH_PAYMENT, $fields['good_faith_payment']);
        }
        if( isset($fields['good_faith_date']) && !empty($fields['good_faith_date']) ){
        	$criteria->add(TicketsClientsReopen::GOOD_FAITH_DATE, $fields['good_faith_date']);
        }
        if( isset($fields['good_faith_amount']) && !empty($fields['good_faith_amount']) ){
        	$criteria->add(TicketsClientsReopen::GOOD_FAITH_AMOUNT, $fields['good_faith_amount']);
        }
        if( isset($fields['good_faith_request']) && !empty($fields['good_faith_request']) ){
        	$criteria->add(TicketsClientsReopen::GOOD_FAITH_REQUEST, $fields['good_faith_request']);
        }
       $criteria->endPrefix();
    }
}