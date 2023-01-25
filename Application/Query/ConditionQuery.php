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
use Application\Model\Catalog\ConditionCatalog;
use Application\Model\Bean\Condition;

use Application\Query\BaseQuery;

/**
 * Application\Query\ConditionQuery
 *
 * @method \Application\Query\ConditionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ConditionQuery useMemoryCache()
 * @method \Application\Query\ConditionQuery useFileCache()
 * @method \Application\Model\Collection\ConditionCollection find()
 * @method \Application\Model\Bean\Condition findOne()
 * @method \Application\Model\Bean\Condition findOneOrElse() findOneOrElse(Condition $alternative)
 * @method \Application\Model\Bean\Condition findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Condition findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Condition findByPKOrElse() findByPKOrElse($pk, Condition $alternative)
 * @method \Application\Model\Bean\Condition findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ConditionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ConditionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ConditionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ConditionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ConditionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ConditionQuery removeJoins()
 * @method \Application\Query\ConditionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ConditionQuery from() from($table, $alias = null)
 * @method \Application\Query\ConditionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ConditionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ConditionQuery bind() bind($parameters)
 * @method \Application\Query\ConditionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ConditionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ConditionQuery setLimit() setLimit($limit)
 * @method \Application\Query\ConditionQuery setOffset() setOffset($offset)
 * @method \Application\Query\ConditionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ConditionQuery distinct()
 * @method \Application\Query\ConditionQuery select()
 * @method \Application\Query\ConditionQuery addColumns() addColumns($columns)
 * @method \Application\Query\ConditionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ConditionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ConditionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ConditionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ConditionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ConditionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ConditionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ConditionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ConditionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ConditionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Condition::TABLENAME, "Condition");

        $defaultColumn = array("Condition.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ConditionQuery
     */
    public function pk($value){
        $this->filter(array(
            Condition::ID_AUTOMATA_CONDITION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Condition::ID_AUTOMATA_CONDITION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ConditionQuery
     */
    public function filter($fields, $prefix = 'Condition'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Condition')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_automata_condition']) && !empty($fields['id_automata_condition']) ){
            $criteria->add(Condition::ID_AUTOMATA_CONDITION, $fields['id_automata_condition']);
        }
        if( isset($fields['id_element']) && !empty($fields['id_element']) ){
            $criteria->add(Condition::ID_ELEMENT, $fields['id_element']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Condition::NAME, $fields['name']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ConditionQuery
     */
    public function innerJoinElement($alias = 'Condition', $aliasForeignTable = 'Element')
    {
        $this->innerJoinOn(\Application\Model\Bean\Element::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_element'), array($aliasForeignTable, 'id_element'));

        return $this;
    }


}