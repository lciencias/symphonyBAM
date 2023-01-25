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
use Application\Model\Catalog\ClientResolutionCatalog;
use Application\Model\Bean\ClientResolution;

use Application\Query\BaseQuery;

/**
 * Application\Query\ClientResolutionQuery
 *
 * @method \Application\Query\ClientResolutionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientResolutionQuery useMemoryCache()
 * @method \Application\Query\ClientResolutionQuery useFileCache()
 * @method \Application\Model\Collection\ClientResolutionCollection find()
 * @method \Application\Model\Bean\ClientResolution findOne()
 * @method \Application\Model\Bean\ClientResolution findOneOrElse() findOneOrElse(ClientResolution $alternative)
 * @method \Application\Model\Bean\ClientResolution findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientResolution findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientResolution findByPKOrElse() findByPKOrElse($pk, ClientResolution $alternative)
 * @method \Application\Model\Bean\ClientResolution findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientResolutionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientResolutionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientResolutionQuery removeJoins()
 * @method \Application\Query\ClientResolutionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientResolutionQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientResolutionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientResolutionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientResolutionQuery bind() bind($parameters)
 * @method \Application\Query\ClientResolutionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientResolutionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientResolutionQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientResolutionQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientResolutionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientResolutionQuery distinct()
 * @method \Application\Query\ClientResolutionQuery select()
 * @method \Application\Query\ClientResolutionQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientResolutionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientResolutionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientResolutionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientResolutionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientResolutionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientResolutionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientResolutionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientResolutionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ClientResolutionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ClientResolutionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ClientResolution::TABLENAME, "ClientResolution");

        $defaultColumn = array("ClientResolution.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ClientResolutionQuery
     */
    public function pk($value){
        $this->filter(array(
            ClientResolution::ID_CLIENT_RESOLUTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ClientResolution::ID_CLIENT_RESOLUTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ClientResolutionQuery
     */
    public function filter($fields, $prefix = 'ClientResolution'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ClientResolution')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_client_resolution']) && !empty($fields['id_client_resolution']) ){
            $criteria->add(ClientResolution::ID_CLIENT_RESOLUTION, $fields['id_client_resolution']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(ClientResolution::NAME, $fields['name']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(ClientResolution::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(ClientResolution::STATUS, $fields['status']);
        }
        if( isset($fields['code']) && !empty($fields['code']) ){
        	$criteria->add(ClientResolution::CODE, $fields['code']);
        }
        
        $criteria->endPrefix();
    }
    /**
     * 
     * @return \Application\Query\ClientResolutionQuery
     */
	public function actives(){
		$this->whereAdd(ClientResolution::STATUS, ClientResolution::$Status['Active']);
		return $this;
	}
	/**
	 * @return \Application\Query\ClientResolutionQuery
	 */
	public function favorable(){
		$this->whereAdd(ClientResolution::TYPE, ClientResolution::$Type['Favorable']);
		return $this;
	}
	/**
	 * @return \Application\Query\ClientResolutionQuery
	 */
	public function unfavorable(){
		$this->whereAdd(ClientResolution::TYPE, ClientResolution::$Type['Unfavorable']);
		return $this;
	}

}