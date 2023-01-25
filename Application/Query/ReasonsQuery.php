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
use Application\Model\Metadata\ReasonsMetadata;
use Application\Model\Bean\Reasons;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;


/**
 * Application\Query\ReasonsQuery
 *
 * @method \Application\Query\ReasonsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ReasonsQuery useMemoryCache()
 * @method \Application\Query\ReasonsQuery useFileCache()
 * @method \Application\Model\Collection\ReasonsCollection find()
 * @method \Application\Model\Bean\Reasons findOne()
 * @method \Application\Model\Bean\Reasons findOneOrElse() findOneOrElse(Reasons $alternative)
 * @method \Application\Model\Bean\Reasons findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Reasons findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Reasons findByPKOrElse() findByPKOrElse($pk, Reasons $alternative)
 * @method \Application\Model\Bean\Reasons findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ReasonsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ReasonsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ReasonsQuery removeJoins()
 * @method \Application\Query\ReasonsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ReasonsQuery from() from($table, $alias = null)
 * @method \Application\Query\ReasonsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ReasonsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ReasonsQuery bind() bind($parameters)
 * @method \Application\Query\ReasonsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ReasonsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ReasonsQuery setLimit() setLimit($limit)
 * @method \Application\Query\ReasonsQuery setOffset() setOffset($offset)
 * @method \Application\Query\ReasonsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ReasonsQuery distinct()
 * @method \Application\Query\ReasonsQuery select()
 * @method \Application\Query\ReasonsQuery pk() pk($id)
 * @method \Application\Query\ReasonsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ReasonsQuery addColumns() addColumns($columns)
 * @method \Application\Query\ReasonsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ReasonsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ReasonsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ReasonsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ReasonsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ReasonsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ReasonsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ReasonsQuery extends BaseQuery{

   /**
     *
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ReasonsCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Reasons::TABLENAME, "Reasons");

        $defaultColumn = array("Reasons.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelQuery
     */
    public function pk($value){
        $this->filter(array(
            Reasons::ID_REASON => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Reasons::ID_REASON, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelQuery
     */
    public function filter($fields, $prefix = 'Reasons'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Reasons')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_reason']) && !empty($fields['id_reason']) ){
            $criteria->add(Reasons::ID_REASON, $fields['id_reason']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Reasons::NAME, $fields['name'],  ReasonsQuery::LIKE);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Reasons::STATUS, $fields['status']);
        }
        if( isset($fields['partialities']) && !empty($fields['partialities']) ){
        	$criteria->add(Reasons::PARTIALITIES, $fields['partialities']);
        }        
        if( isset($fields['financial_movement']) && !empty($fields['financial_movement']) ){
        	$criteria->add(Reasons::FINANCIAL_MOVEMENT, $fields['financial_movement']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
        	$criteria->add(Reasons::TYPE, $fields['type']);
        }
        if( isset($fields['subtype']) && !empty($fields['subtype']) ){
        	$criteria->add(Reasons::SUBTYPE, $fields['subtype']);
        }
        if( isset($fields['movments']) && !empty($fields['movments']) ){
        	$criteria->add(Reasons::MOVMENTS, $fields['movments']);
        }        
        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ChannelQuery
     */
    public function actives(){
        return $this->filter(array(
            Reasons::STATUS => Reasons::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\ChannelQuery
     */
    public function inactives(){
        return $this->filter(array(
            Reasons::STATUS => Reasons::$Status['Inactive'],
        ));
    }
    
    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmailQuery
     */
    public function innerJoinProducts($alias = 'Reasons', $aliasForeignTable = 'Products')
    {
        $this->innerJoinOn('pcs_symphony_reasons_products', 'Reason2Product')
            ->equalFields(array($alias, 'id_reason'), array('Reason2Product', 'id_reason'));


        return $this;
    }




}