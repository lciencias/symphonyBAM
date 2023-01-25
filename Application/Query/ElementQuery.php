<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Catalog\ElementCatalog;
use Application\Model\Bean\Element;

use Application\Query\BaseQuery;

/**
 * Application\Query\ElementQuery
 *
 * @method \Application\Query\ElementQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ElementQuery useMemoryCache()
 * @method \Application\Query\ElementQuery useFileCache()
 * @method \Application\Model\Collection\ElementCollection find()
 * @method \Application\Model\Bean\Element findOne()
 * @method \Application\Model\Bean\Element findOneOrElse() findOneOrElse(Element $alternative)
 * @method \Application\Model\Bean\Element findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Element findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Element findByPKOrElse() findByPKOrElse($pk, Element $alternative)
 * @method \Application\Model\Bean\Element findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ElementQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ElementQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ElementQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ElementQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ElementQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ElementQuery removeJoins()
 * @method \Application\Query\ElementQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ElementQuery from() from($table, $alias = null)
 * @method \Application\Query\ElementQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ElementQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ElementQuery bind() bind($parameters)
 * @method \Application\Query\ElementQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ElementQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ElementQuery setLimit() setLimit($limit)
 * @method \Application\Query\ElementQuery setOffset() setOffset($offset)
 * @method \Application\Query\ElementQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ElementQuery distinct()
 * @method \Application\Query\ElementQuery select()
 * @method \Application\Query\ElementQuery addColumns() addColumns($columns)
 * @method \Application\Query\ElementQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ElementQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ElementQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ElementQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ElementQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ElementQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ElementQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ElementQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ElementCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ElementCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Element::TABLENAME, "Element");

        $defaultColumn = array("Element.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ElementQuery
     */
    public function pk($value){
        $this->filter(array(
            Element::ID_ELEMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Element::ID_ELEMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ElementQuery
     */
    public function filter($fields, $prefix = 'Element'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Element')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_element']) && !empty($fields['id_element']) ){
            $criteria->add(Element::ID_ELEMENT, $fields['id_element']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Element::NAME, $fields['name']);
        }

        $criteria->endPrefix();
    }


}