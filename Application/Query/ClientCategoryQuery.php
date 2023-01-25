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

use Application\Model\Bean\TicketType;

use Application\Model\Bean\Escalation;

use Application\Model\Bean\Group;

use Application\Model\Bean\ServiceLevel;

use Query\Query;
use Application\Model\Catalog\ClientCategoryCatalog;
use Application\Model\Bean\ClientCategory;

use Application\Query\BaseQuery;
use Application\Model\Bean\ClientCategoriesProducts;

/**
 * Application\Query\ClientCategoryQuery
 *
 * @method \Application\Query\ClientCategoryQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientCategoryQuery useMemoryCache()
 * @method \Application\Query\ClientCategoryQuery useFileCache()
 * @method \Application\Model\Collection\ClientCategoryCollection find()
 * @method \Application\Model\Bean\ClientCategory findOne()
 * @method \Application\Model\Bean\ClientCategory findOneOrElse() findOneOrElse(ClientCategory $alternative)
 * @method \Application\Model\Bean\ClientCategory findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientCategory findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientCategory findByPKOrElse() findByPKOrElse($pk, ClientCategory $alternative)
 * @method \Application\Model\Bean\ClientCategory findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientCategoryQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientCategoryQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientCategoryQuery removeJoins()
 * @method \Application\Query\ClientCategoryQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientCategoryQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientCategoryQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientCategoryQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientCategoryQuery bind() bind($parameters)
 * @method \Application\Query\ClientCategoryQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientCategoryQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientCategoryQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientCategoryQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientCategoryQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientCategoryQuery distinct()
 * @method \Application\Query\ClientCategoryQuery select()
 * @method \Application\Query\ClientCategoryQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientCategoryQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientCategoryQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientCategoryQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientCategoryQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientCategoryQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientCategoryQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientCategoryQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientCategoryQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ClientCategoryCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ClientCategoryCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ClientCategory::TABLENAME, "ClientCategory");

        $defaultColumn = array("ClientCategory.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ClientCategoryQuery
     */
    public function pk($value){
        $this->filter(array(
            ClientCategory::ID_CLIENT_CATEGORY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ClientCategory::ID_CLIENT_CATEGORY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ClientCategoryQuery
     */
    public function filter($fields, $prefix = 'ClientCategory'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ClientCategory')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(ClientCategory::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }
        if( isset($fields['id_ticket_type']) && !empty($fields['id_ticket_type']) ){
            $criteria->add(ClientCategory::ID_TICKET_TYPE, $fields['id_ticket_type']);
        }
        if( isset($fields['id_group']) && !empty($fields['id_group']) ){
            $criteria->add(ClientCategory::ID_GROUP, $fields['id_group']);
        }
        if( isset($fields['id_escalation']) && !empty($fields['id_escalation']) ){
            $criteria->add(ClientCategory::ID_ESCALATION, $fields['id_escalation']);
        }
        if( isset($fields['id_service_level']) && !empty($fields['id_service_level']) ){
            $criteria->add(ClientCategory::ID_SERVICE_LEVEL, $fields['id_service_level']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(ClientCategory::NAME, $fields['name']);
        }
        if( isset($fields['id_parent']) && !empty($fields['id_parent']) ){
            $criteria->add(ClientCategory::ID_PARENT, $fields['id_parent']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(ClientCategory::STATUS, $fields['status']);
        }
        if( isset($fields['is_leaf']) && !empty($fields['is_leaf']) ){
            $criteria->add(ClientCategory::IS_LEAF, $fields['is_leaf']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ClientCategory::NOTE, $fields['note']);
        }
        if( isset($fields['partialities']) && !empty($fields['partialities']) ){
            $criteria->add(ClientCategory::PARTIALITIES, $fields['partialities']);
        }        
        if( isset($fields['financial_movement']) && !empty($fields['financial_movement']) ){
        	$criteria->add(ClientCategory::FINANCIAL_MOVEMENT, $fields['financial_movement']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
        	$criteria->add(ClientCategory::TYPE, $fields['type']);
        }
        if( isset($fields['movments']) && !empty($fields['movments']) ){
        	$criteria->add(ClientCategory::MOVMENTS, $fields['movments']);
        }     
        if( isset($fields['product']) && !empty($fields['product']) ){
        	$criteria->add(ClientCategory::PRODUCT, $fields['product']);
        }     
        if( isset($fields['motive']) && !empty($fields['motive']) ){
        	$criteria->add(ClientCategory::MOTIVE, $fields['motive']);
        }     
        if( isset($fields['chanel']) && !empty($fields['chanel']) ){
        	$criteria->add(ClientCategory::CHANNEL, $fields['chanel']);
        }     
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryQuery
     */
    public function innerJoinServiceLevel($alias = 'ClientCategory', $aliasForeignTable = 'ServiceLevel')
    {
        $this->innerJoinOn(ServiceLevel::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_service_level'), array($aliasForeignTable, 'id_service_level'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryQuery
     */
    public function innerJoinGroup($alias = 'ClientCategory', $aliasForeignTable = 'Group')
    {
        $this->innerJoinOn(Group::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_group'), array($aliasForeignTable, 'id_group'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryQuery
     */
    public function innerJoinEscalation($alias = 'ClientCategory', $aliasForeignTable = 'Escalation')
    {
        $this->innerJoinOn(Escalation::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_escalation'), array($aliasForeignTable, 'id_escalation'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryQuery
     */
    public function innerJoinTicketType($alias = 'ClientCategory', $aliasForeignTable = 'TicketType')
    {
        $this->innerJoinOn(TicketType::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket_type'), array($aliasForeignTable, 'id_ticket_type'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryQuery
     */
    public function innerJoinClientCategoriesProducts($alias = 'ClientCategory', $aliasForeignTable = 'ClientCategoriesProducts')
    {
    	$this->innerJoinOn(ClientCategoriesProducts::TABLENAME, $aliasForeignTable)
    	->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));
    	return $this;
    }
    
    /**
     * 
     * @return \Application\Query\ClientCategoryQuery
     */
	public function actives(){
		$this->whereAdd(ClientCategory::STATUS, ClientCategory::$Status['Active']);
		return $this;
	}
	/**
	 *
	 * @return \Application\Query\ClientCategoryQuery
	 */
	public function isNotLeaf(){
		$this->whereAdd(ClientCategory::IS_LEAF, 0);
		return $this;
	}
	/**
	 *
	 * @return \Application\Query\ClientCategoryQuery
	 */
	public function isLeaf(){
		$this->whereAdd(ClientCategory::IS_LEAF, 1);
		return $this;
	}
// 	public function hasParent(){
// 		$this->whereAdd(ClientCategory::ID_PARENT,0, '');
// 		return $this;
// 	}
}