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
use Application\Model\Catalog\TicketClientCatalog;
use Application\Model\Bean\TicketClient;
use Application\Model\Bean\Products;
use Application\Model\Bean\BaseTicket;


/**
 * Application\Query\TicketClientQuery
 *
 * @method \Application\Query\TicketClientQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketClientQuery useMemoryCache()
 * @method \Application\Query\TicketClientQuery useFileCache()
 * @method \Application\Model\Collection\TicketClientCollection find()
 * @method \Application\Model\Bean\TicketClient findOne()
 * @method \Application\Model\Bean\TicketClient findOneOrElse() findOneOrElse(TicketClient $alternative)
 * @method \Application\Model\Bean\TicketClient findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketClient findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketClient findByPKOrElse() findByPKOrElse($pk, TicketClient $alternative)
 * @method \Application\Model\Bean\TicketClient findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketClientQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketClientQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketClientQuery removeJoins()
 * @method \Application\Query\TicketClientQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketClientQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketClientQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketClientQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketClientQuery bind() bind($parameters)
 * @method \Application\Query\TicketClientQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketClientQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketClientQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketClientQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketClientQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketClientQuery distinct()
 * @method \Application\Query\TicketClientQuery select()
 * @method \Application\Query\TicketClientQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketClientQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketClientQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketClientQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketClientQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketClientQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketClientQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketClientQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketClientQuery extends BaseTicketQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketClientCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketClientCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketClient::TABLENAME, "TicketClient");
        $this->innerJoinBaseTicket();

        $defaultColumn = array("TicketClient.*");
        $defaultColumn[] = "BaseTicket.*";
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketClientQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketClient::ID_TICKET_CLIENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketClient::ID_TICKET_CLIENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketClientQuery
     */
    public function filter($fields, $prefix = 'TicketClient'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketClient')
    {
        parent::build($query, $fields);

        $criteria = $query->where();
        $criteria->prefix($prefix);
        if( isset($fields['id_ticket_client']) && !empty($fields['id_ticket_client']) ){
            $criteria->add(TicketClient::ID_TICKET_CLIENT, $fields['id_ticket_client']);
        }
		if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(TicketClient::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(TicketClient::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['folio']) && !empty($fields['folio']) ){
       		$criteria->add(TicketClient::FOLIO, $fields['folio'],BaseQuery::LIKE);
        }
        if( isset($fields['account_number']) && !empty($fields['account_number']) ){
            $criteria->add(TicketClient::ACCOUNT_NUMBER, $fields['account_number']);
        }
        if( isset($fields['account']) && !empty($fields['account']) ){
        	$criteria->add(TicketClient::ACCOUNT_NUMBER, $fields['account'],BaseQuery::LIKE);
        }
        if( isset($fields['id_origin_branch']) && !empty($fields['id_origin_branch']) ){
            $criteria->add(TicketClient::ID_ORIGIN_BRANCH, $fields['id_origin_branch']);
        }
        if( isset($fields['id_reported_branch']) && !empty($fields['id_reported_branch']) ){
            $criteria->add(TicketClient::ID_REPORTED_BRANCH, $fields['id_reported_branch']);
        }
        if( isset($fields['id_product']) && !empty($fields['id_product']) ){
        	$criteria->add(TicketClient::ID_PRODUCT, $fields['id_product']);
        }
	        if( isset($fields['email']) && !empty($fields['email']) ){
        	$criteria->add(TicketClient::EMAIL, $fields['email']);
        }        
        if( isset($fields['folio_prev']) && !empty($fields['folio_prev']) ){
        	$criteria->add(TicketClient::FOLIO_PREV, $fields['folio_prev']);
        }
        if( isset($fields['clientNumber']) && !empty($fields['clientNumber']) ){
        	$criteria->add(TicketClient::CLIENT_NUMBER, $fields['clientNumber']);
        }
        if( isset($fields['client_number']) && !empty($fields['client_number']) ){
        	$criteria->add(TicketClient::CLIENT_NUMBER, $fields['client_number']);
        }        
        if( isset($fields['id_user_last_assign']) && !empty($fields['id_user_last_assign']) ){
        	$criteria->add(TicketClient::ID_USER_LAST_ASSIGN, $fields['id_user_last_assign']);
        }
        if( isset($fields['state_client']) && !empty($fields['state_client']) ){
        	$criteria->add(TicketClient::STATE_CLIENT, $fields['state_client']);
        }
        if( isset($fields['name_client']) && !empty($fields['name_client']) ){
        	$criteria->add(TicketClient::NAME_CLIENT, $fields['name_client'],BaseQuery::LIKE);
        }
        if( isset($fields['no_card']) && !empty($fields['no_card']) ){
        	$criteria->add(TicketClient::NO_CARD, $fields['no_card']);
        }
        if( isset($fields['employee']) && !empty($fields['employee']) ){
        	$criteria->add(TicketClient::EMPLOYEE, $fields['employee']);
        }
        if( isset($fields['card_type']) && !empty($fields['card_type']) ){
        	$criteria->add(TicketClient::CARD_TYPE, $fields['card_type']);
        }
        if( isset($fields['expiration_date']) && !empty($fields['expiration_date']) ){
        	$criteria->add(TicketClient::EXPIRATION_DATE, $fields['expiration_date']);
        }
        if( isset($fields['chanel']) && !empty($fields['chanel']) ){
        	$criteria->add(TicketClient::CHANEL, $fields['chanel']);
        }
        if( isset($fields['folio_condusef']) && !empty($fields['folio_condusef']) ){
        	$criteria->add(TicketClient::FOLIO_CONDUSEF, $fields['folio_condusef']);
        }        
        if( isset($fields['id_resolver']) && !empty($fields['id_resolver']) ){
        	$criteria->add(TicketClient::ID_RESOLVER, $fields['id_resolver']);
        }
        if( isset($fields['account_type']) && !empty($fields['account_type']) ){
        	$criteria->add(TicketClient::ACCOUNT_TYPE, $fields['account_type']);
        }
        if( isset($fields['telefono']) && !empty($fields['telefono']) ){
        	$criteria->add(TicketClient::TELEFONO, $fields['telefono']);
        }
        if( isset($fields['id_entidad']) && !empty($fields['id_entidad']) ){
        	$criteria->add(TicketClient::ID_ENTIDAD, $fields['id_entidad']);
        }
        if( isset($fields['complaint']) && !empty($fields['complaint']) ){
        	$criteria->add(TicketClient::COMPLAINT, $fields['complaint']);
        }        
        $criteria->endPrefix();
    }
    
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ProductsQuery
     */
    public function innerJoinProducts($alias = 'TicketClient', $aliasForeignTable = 'Products')
    {
    	$this->innerJoinOn(Products::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_product'), array($aliasForeignTable, 'id_product'));
    	return $this;
    }
    

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ReasonsQuery
     */
    public function innerJoinReasons($alias = 'TicketClient', $aliasForeignTable = 'Reasons')
    {
    	$this->innerJoinOn(Products::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_reason'), array($aliasForeignTable, 'id_reason'));
    	return $this;
    }
    
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ReasonsQuery
     */
    public function innerJoinReasons2($alias = 'TicketClient', $aliasForeignTable = 'Reasons')
    {
    	$this->innerJoinOn(\Application\Model\Bean\Reasons::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_reason'), array($aliasForeignTable, 'id_reason'));
    	return $this;
    }
    
    public function innerJoinChannel2($alias = 'BaseTicket', $aliasForeignTable = 'Channel')
    {
    	$this->innerJoinOn(\Application\Model\Bean\Channel::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_channel'), array($aliasForeignTable, 'id_channel'));
    	return $this;
    }
    
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientQuery
     */
    public function innerJoinCategory($alias = 'TicketClient', $aliasForeignTable = 'ClientCategory')
    {
        $this->innerJoinOn(ClientCategory::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));

        return $this;
    }
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientQuery
     */
    public function innerJoinBaseTicket($alias = 'TicketClient', $aliasForeignTable = 'BaseTicket')
    {
    	$this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));
    
    	return $this;
    }
    

}