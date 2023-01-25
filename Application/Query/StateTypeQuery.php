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
use Application\Model\Catalog\StateTypeCatalog;
use Application\Model\Bean\StateType;

use Application\Query\BaseQuery;

/**
 * Application\Query\StateTypeQuery
 *
 * @method \Application\Query\StateTypeQuery pk() pk(int $primaryKey)
 * @method \Application\Query\StateTypeQuery useMemoryCache()
 * @method \Application\Query\StateTypeQuery useFileCache()
 * @method \Application\Model\Collection\StateTypeCollection find()
 * @method \Application\Model\Bean\StateType findOne()
 * @method \Application\Model\Bean\StateType findOneOrElse() findOneOrElse(StateType $alternative)
 * @method \Application\Model\Bean\StateType findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\StateType findByPK() findByPK($pk)
 * @method \Application\Model\Bean\StateType findByPKOrElse() findByPKOrElse($pk, StateType $alternative)
 * @method \Application\Model\Bean\StateType findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\StateTypeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\StateTypeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\StateTypeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\StateTypeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\StateTypeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\StateTypeQuery removeJoins()
 * @method \Application\Query\StateTypeQuery removeJoin() removeJoin($table)
 * @method \Application\Query\StateTypeQuery from() from($table, $alias = null)
 * @method \Application\Query\StateTypeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\StateTypeQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\StateTypeQuery bind() bind($parameters)
 * @method \Application\Query\StateTypeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\StateTypeQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\StateTypeQuery setLimit() setLimit($limit)
 * @method \Application\Query\StateTypeQuery setOffset() setOffset($offset)
 * @method \Application\Query\StateTypeQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\StateTypeQuery distinct()
 * @method \Application\Query\StateTypeQuery select()
 * @method \Application\Query\StateTypeQuery addColumns() addColumns($columns)
 * @method \Application\Query\StateTypeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\StateTypeQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\StateTypeQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\StateTypeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\StateTypeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\StateTypeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\StateTypeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class StateTypeQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\StateTypeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('StateTypeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(StateType::TABLENAME, "StateType");

        $defaultColumn = array("StateType.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\StateTypeQuery
     */
    public function pk($value){
        $this->filter(array(
            StateType::ID_STATE_TYPE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(StateType::ID_STATE_TYPE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\StateTypeQuery
     */
    public function filter($fields, $prefix = 'StateType'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'StateType')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_state_type']) && !empty($fields['id_state_type']) ){
            $criteria->add(StateType::ID_STATE_TYPE, $fields['id_state_type']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(StateType::NAME, $fields['name']);
        }

        $criteria->endPrefix();
    }


}