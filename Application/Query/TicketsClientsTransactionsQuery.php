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
use Application\Model\Metadata\TicketsClientsTransactionsMetadata;
use Application\Model\Bean\TicketsClientsTransactions;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;

/**
 * Application\Query\TicketsClientsTransactionsQuery
 *
 * @method \Application\Query\TicketsClientsTransactionsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketsClientsTransactionsQuery useMemoryCache()
 * @method \Application\Query\TicketsClientsTransactionsQuery useFileCache()
 * @method \Application\Model\Collection\TicketsClientsTransactionsCollection find()
 * @method \Application\Model\Bean\TicketsClientsTransactions findOne()
 * @method \Application\Model\Bean\TicketsClientsTransactions findOneOrElse() findOneOrElse(TicketsClientsTransactions $alternative)
 * @method \Application\Model\Bean\TicketsClientsTransactions findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketsClientsTransactions findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketsClientsTransactions findByPKOrElse() findByPKOrElse($pk, TicketsClientsTransactions $alternative)
 * @method \Application\Model\Bean\TicketsClientsTransactions findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketsClientsTransactionsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery removeJoins()
 * @method \Application\Query\TicketsClientsTransactionsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketsClientsTransactionsQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketsClientsTransactionsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery bind() bind($parameters)
 * @method \Application\Query\TicketsClientsTransactionsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketsClientsTransactionsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketsClientsTransactionsQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketsClientsTransactionsQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketsClientsTransactionsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery distinct()
 * @method \Application\Query\TicketsClientsTransactionsQuery select()
 * @method \Application\Query\TicketsClientsTransactionsQuery pk() pk($id)
 * @method \Application\Query\TicketsClientsTransactionsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketsClientsTransactionsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketsClientsTransactionsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketsClientsTransactionsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketsClientsTransactionsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketsClientsTransactionsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketsClientsTransactionsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketsClientsTransactionsQuery extends BaseQuery{

	
	/**
	 *
	 * @return \Application\Model\Catalog\CompanyCatalog
	 */
	protected function getCatalog(){
		return \Zend_Registry::getInstance()->get('container')->get('TicketsClientsTransactionsCatalog');
	}
	

	/**
	 * initialization
	 */
	protected function init()
	{
		$this->from(TicketsClientsTransactions::TABLENAME, "TicketsClientsTransactions");
	
		$defaultColumn = array("TicketsClientsTransactions.*");
		$this->setDefaultColumn($defaultColumn);
		$this->setStorage(StorageFactory::create('memory'));
	}
	

    /**
     * @param mixed $value
     * @return Application\Query\TicketsClientsTransactionsQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketsClientsTransactions ::ID_TICKET_CLIENT_TRANSACTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketsClientsTransactions::ID_TICKET_CLIENT_TRANSACTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketsClientsTransactionsQuery
     */
    public function filter($fields, $prefix = 'TicketsClientsTransactions'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketsClientsTransactions')
    {
        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_client_transaction']) && !empty($fields['id_ticket_client_transaction']) ){
            $criteria->add(TicketsClientsTransactions::ID_TICKET_CLIENT_TRANSACTION, $fields['id_ticket_client_transaction']);
        }
        if( isset($fields['id_ticket_client']) && !empty($fields['id_ticket_client']) ){
            $criteria->add(TicketsClientsTransactions::ID_TICKET_CLIENT, $fields['id_ticket_client']);
        }
        if( isset($fields['id_transaction_bam']) && !empty($fields['id_transaction_bam']) ){
            $criteria->add(TicketsClientsTransactions::ID_TRANSACTION_BAM, $fields['id_transaction_bam']);
        }
        if( isset($fields['transaction_date']) && !empty($fields['transaction_date']) ){
        	$criteria->add(TicketsClientsTransactions::TRANSACTION_DATE, $fields['transaction_date']);
        }
        if( isset($fields['amount']) && !empty($fields['amount']) ){
        	$criteria->add(TicketsClientsTransactions::AMOUNT, $fields['amount']);
        }
        if( isset($fields['good_faith_payment']) && !empty($fields['good_faith_payment']) ){
        	$criteria->add(TicketsClientsTransactions::GOOD_FAITH_PAYMENT, $fields['good_faith_payment']);
        }
        if( isset($fields['good_faith_date']) && !empty($fields['good_faith_date']) ){
        	$criteria->add(TicketsClientsTransactions::GOOD_FAITH_DATE, $fields['good_faith_date']);
        }
        if( isset($fields['good_faith_amount']) && !empty($fields['good_faith_amount']) ){
        	$criteria->add(TicketsClientsTransactions::GOOD_FAITH_AMOUNT, $fields['good_faith_amount']);
        }
        if( isset($fields['id_controversy_chargeback']) && !empty($fields['id_controversy_chargeback']) ){
        	$criteria->add(TicketsClientsTransactions::ID_CONTROVERSY_CHARGEBACK, $fields['id_controversy_chargeback']);
        }
        if( isset($fields['payment_request_date']) && !empty($fields['payment_request_date']) ){
        	$criteria->add(TicketsClientsTransactions::PAYMENT_REQUEST_DATE, $fields['payment_request_date']);
        }
        if( isset($fields['payment_delivery_date']) && !empty($fields['payment_delivery_date']) ){
        	$criteria->add(TicketsClientsTransactions::PAYMENT_DELIVERY_DATE, $fields['payment_delivery_date']);
        }
        if( isset($fields['accepted_payment']) && !empty($fields['accepted_payment']) ){
        	$criteria->add(TicketsClientsTransactions::ACCEPTED_PAYMENT, $fields['accepted_payment']);
        }
        if( isset($fields['delivered_payment']) && !empty($fields['delivered_payment']) ){
        	$criteria->add(TicketsClientsTransactions::DELIVERED_PAYMENT, $fields['delivered_payment']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
        	$criteria->add(TicketsClientsTransactions::TYPE, $fields['type']);
        }
        if( isset($fields['file_payment']) && !empty($fields['file_payment']) ){
        	$criteria->add(TicketsClientsTransactions::FILE_PAYMENT, $fields['file_payment']);
        }
        if( isset($fields['file_delivery']) && !empty($fields['file_delivery']) ){
        	$criteria->add(TicketsClientsTransactions::FILE_DELIVERY, $fields['file_delivery']);
        }
        if( isset($fields['good_faith_request']) && !empty($fields['good_faith_request']) ){
        	$criteria->add(TicketsClientsTransactions::GOOD_FAITH_REQUEST, $fields['good_faith_request']);
        }
        if( isset($fields['reference']) && !empty($fields['reference']) ){
        	$criteria->add(TicketsClientsTransactions::REFERENCE, $fields['reference']);
        }
        if( isset($fields['afiliation']) && !empty($fields['afiliation']) ){
        	$criteria->add(TicketsClientsTransactions::AFILIATION, $fields['afiliation']);
        }
        if( isset($fields['commerce']) && !empty($fields['commerce']) ){
        	$criteria->add(TicketsClientsTransactions::COMMERCE, $fields['commerce']);
        }
        if( isset($fields['description']) && !empty($fields['description']) ){
        	$criteria->add(TicketsClientsTransactions::DESCRIPTION, $fields['description']);
        }
        if( isset($fields['idT24']) && !empty($fields['idT24']) ){
        	$criteria->add(TicketsClientsTransactions::IDT24, $fields['idT24']);
        }
        $criteria->endPrefix();
    }
}