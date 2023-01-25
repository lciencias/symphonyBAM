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
use Application\Model\Bean\Prod;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;


/**
 * Application\Query\ProductsQuery
 *
 * @method \Application\Query\ProductsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ProductsQuery useMemoryCache()
 * @method \Application\Query\ProductsQuery useFileCache()
 * @method \Application\Model\Collection\ProductsCollection find()
 * @method \Application\Model\Bean\Products findOne()
 * @method \Application\Model\Bean\Products findOneOrElse() findOneOrElse(Products $alternative)
 * @method \Application\Model\Bean\Products findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Products findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Products findByPKOrElse() findByPKOrElse($pk, Products $alternative)
 * @method \Application\Model\Bean\Products findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ProductsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ProductsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ProductsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ProductsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ProductsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ProductsQuery removeJoins()
 * @method \Application\Query\ProductsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ProductsQuery from() from($table, $alias = null)
 * @method \Application\Query\ProductsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ProductsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ProductsQuery bind() bind($parameters)
 * @method \Application\Query\ProductsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ProductsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ProductsQuery setLimit() setLimit($limit)
 * @method \Application\Query\ProductsQuery setOffset() setOffset($offset)
 * @method \Application\Query\ProductsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ProductsQuery distinct()
 * @method \Application\Query\ProductsQuery select()
 * @method \Application\Query\ProductsQuery pk() pk($id)
 * @method \Application\Query\ProductsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ProductsQuery addColumns() addColumns($columns)
 * @method \Application\Query\ProductsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ProductsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ProductsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ProductsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ProductsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ProductsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ProductsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ProductsQuery extends BaseQuery{

    
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ProdCatalog');
    }
    
    /**
     * @return \Application\Model\Metadata\ProductsMetadata
     */
    /*protected static function getMetadata(){
        return ProductsMetadata::getInstance();
    }*/

    
    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Products::TABLENAME, "Prod");

        $defaultColumn = array("Prod.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelQuery
     */
    public function pk($value){
        $this->filter(array(
            Prod::ID_BAM => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Prod::ID_BAM, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelQuery
     */
    public function filter($fields, $prefix = 'Prod'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Prod')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_bam']) && !empty($fields['id_bam']) ){
            $criteria->add(Prod::ID_BAM, $fields['id_bam']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Prod::NAME, trim($fields['name']),  ProdQuery::LIKE);
        }
        if( isset($fields['no_tarjeta']) && !empty($fields['no_tarjeta']) ){
            $criteria->add(Prod::NO_TARJETA, $fields['no_tarjeta']);
        }
        $criteria->endPrefix();
    }
}