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
use Application\Model\Catalog\StateCatalog;
use Application\Model\Bean\State;

use Application\Query\BaseQuery;

/**
 * Application\Query\StateQuery
 *
 * @method \Application\Query\StateQuery pk() pk(int $primaryKey)
 * @method \Application\Query\StateQuery useMemoryCache()
 * @method \Application\Query\StateQuery useFileCache()
 * @method \Application\Model\Collection\StateCollection find()
 * @method \Application\Model\Bean\State findOne()
 * @method \Application\Model\Bean\State findOneOrElse() findOneOrElse(State $alternative)
 * @method \Application\Model\Bean\State findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\State findByPK() findByPK($pk)
 * @method \Application\Model\Bean\State findByPKOrElse() findByPKOrElse($pk, State $alternative)
 * @method \Application\Model\Bean\State findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\StateQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\StateQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\StateQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\StateQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\StateQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\StateQuery removeJoins()
 * @method \Application\Query\StateQuery removeJoin() removeJoin($table)
 * @method \Application\Query\StateQuery from() from($table, $alias = null)
 * @method \Application\Query\StateQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\StateQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\StateQuery bind() bind($parameters)
 * @method \Application\Query\StateQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\StateQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\StateQuery setLimit() setLimit($limit)
 * @method \Application\Query\StateQuery setOffset() setOffset($offset)
 * @method \Application\Query\StateQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\StateQuery distinct()
 * @method \Application\Query\StateQuery select()
 * @method \Application\Query\StateQuery addColumns() addColumns($columns)
 * @method \Application\Query\StateQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\StateQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\StateQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\StateQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\StateQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\StateQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\StateQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class StateQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\StateCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('StateCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(State::TABLENAME, "State");

        $defaultColumn = array("State.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\StateQuery
     */
    public function pk($value){
        $this->filter(array(
            State::ID_AUTOMATA_STATE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(State::ID_AUTOMATA_STATE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\StateQuery
     */
    public function filter($fields, $prefix = 'State'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'State')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_automata_state']) && !empty($fields['id_automata_state']) ){
            $criteria->add(State::ID_AUTOMATA_STATE, $fields['id_automata_state']);
        }
        if( isset($fields['id_element']) && !empty($fields['id_element']) ){
            $criteria->add(State::ID_ELEMENT, $fields['id_element']);
        }
        if( isset($fields['id_state_type']) && !empty($fields['id_state_type']) ){
            $criteria->add(State::ID_STATE_TYPE, $fields['id_state_type']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(State::NAME, $fields['name']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\StateQuery
     */
    public function innerJoinElement($alias = 'State', $aliasForeignTable = 'Element')
    {
        $this->innerJoinOn(\Application\Model\Bean\Element::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_element'), array($aliasForeignTable, 'id_element'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\StateQuery
     */
    public function innerJoinStateType($alias = 'State', $aliasForeignTable = 'StateType')
    {
        $this->innerJoinOn(\Application\Model\Bean\StateType::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_state_type'), array($aliasForeignTable, 'id_state_type'));

        return $this;
    }


}