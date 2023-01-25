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
use Application\Model\Metadata\ReasonProductsMetadata;
use Application\Model\Bean\ReasonProducts;

use Application\Query\BaseQuery;

/**
 * Application\Query\ReasonProductsQuery
 *
 * @method \Application\Query\ReasonProductsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ReasonProductsQuery useMemoryCache()
 * @method \Application\Query\ReasonProductsQuery useFileCache()
 * @method \Application\Model\Collection\ReasonProductsCollection find()
 * @method \Application\Model\Bean\ReasonProducts findOne()
 * @method \Application\Model\Bean\ReasonProducts findOneOrElse() findOneOrElse(ReasonProducts $alternative)
 * @method \Application\Model\Bean\ReasonProducts findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ReasonProducts findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ReasonProducts findByPKOrElse() findByPKOrElse($pk, ReasonProducts $alternative)
 * @method \Application\Model\Bean\ReasonProducts findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ReasonProductsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ReasonProductsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonProductsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonProductsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ReasonProductsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ReasonProductsQuery removeJoins()
 * @method \Application\Query\ReasonProductsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ReasonProductsQuery from() from($table, $alias = null)
 * @method \Application\Query\ReasonProductsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ReasonProductsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ReasonProductsQuery bind() bind($parameters)
 * @method \Application\Query\ReasonProductsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ReasonProductsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ReasonProductsQuery setLimit() setLimit($limit)
 * @method \Application\Query\ReasonProductsQuery setOffset() setOffset($offset)
 * @method \Application\Query\ReasonProductsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ReasonProductsQuery distinct()
 * @method \Application\Query\ReasonProductsQuery select()
 * @method \Application\Query\ReasonProductsQuery pk() pk($id)
 * @method \Application\Query\ReasonProductsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\ReasonProductsQuery addColumns() addColumns($columns)
 * @method \Application\Query\ReasonProductsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ReasonProductsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ReasonProductsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ReasonProductsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ReasonProductsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ReasonProductsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ReasonProductsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ReasonProductsQuery extends BaseQuery{

    /**
     * @return \Application\Model\Metadata\ReasonProductsMetadata
     */
    protected static function getMetadata(){
        return ReasonProductsMetadata::getInstance();
    }



    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ReasonProductsQuery
     */
    public function innerJoinReasons($alias = 'ReasonProducts', $aliasForeignTable = 'Reasons')
    {
        $this->innerJoinOn(\Application\Model\Bean\Reasons::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_reason'), array($aliasForeignTable, 'id_reason'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ReasonProductsQuery
     */
    public function innerJoinProducts($alias = 'ReasonProducts', $aliasForeignTable = 'Products')
    {
        $this->innerJoinOn(\Application\Model\Bean\Products::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_product'), array($aliasForeignTable, 'id_product'));

        return $this;
    }


}