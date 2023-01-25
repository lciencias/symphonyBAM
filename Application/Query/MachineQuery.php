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
use Application\Model\Catalog\MachineCatalog;
use Application\Model\Bean\Machine;

use Application\Query\BaseQuery;

/**
 * Application\Query\MachineQuery
 *
 * @method \Application\Query\MachineQuery pk() pk(int $primaryKey)
 * @method \Application\Query\MachineQuery useMemoryCache()
 * @method \Application\Query\MachineQuery useFileCache()
 * @method \Application\Model\Collection\MachineCollection find()
 * @method \Application\Model\Bean\Machine findOne()
 * @method \Application\Model\Bean\Machine findOneOrElse() findOneOrElse(Machine $alternative)
 * @method \Application\Model\Bean\Machine findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Machine findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Machine findByPKOrElse() findByPKOrElse($pk, Machine $alternative)
 * @method \Application\Model\Bean\Machine findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\MachineQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\MachineQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\MachineQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\MachineQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\MachineQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\MachineQuery removeJoins()
 * @method \Application\Query\MachineQuery removeJoin() removeJoin($table)
 * @method \Application\Query\MachineQuery from() from($table, $alias = null)
 * @method \Application\Query\MachineQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\MachineQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\MachineQuery bind() bind($parameters)
 * @method \Application\Query\MachineQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\MachineQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\MachineQuery setLimit() setLimit($limit)
 * @method \Application\Query\MachineQuery setOffset() setOffset($offset)
 * @method \Application\Query\MachineQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\MachineQuery distinct()
 * @method \Application\Query\MachineQuery select()
 * @method \Application\Query\MachineQuery addColumns() addColumns($columns)
 * @method \Application\Query\MachineQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\MachineQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\MachineQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\MachineQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\MachineQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\MachineQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\MachineQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class MachineQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\MachineCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('MachineCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Machine::TABLENAME, "Machine");

        $defaultColumn = array("Machine.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\MachineQuery
     */
    public function pk($value){
        $this->filter(array(
            Machine::ID_MACHINE_TRANSITION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Machine::ID_MACHINE_TRANSITION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\MachineQuery
     */
    public function filter($fields, $prefix = 'Machine'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Machine')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_machine_transition']) && !empty($fields['id_machine_transition']) ){
            $criteria->add(Machine::ID_MACHINE_TRANSITION, $fields['id_machine_transition']);
        }
        if( isset($fields['id_element']) && !empty($fields['id_element']) ){
            $criteria->add(Machine::ID_ELEMENT, $fields['id_element']);
        }
        if( isset($fields['id_automata_condition']) && !empty($fields['id_automata_condition']) ){
            $criteria->add(Machine::ID_AUTOMATA_CONDITION, $fields['id_automata_condition']);
        }
        if( isset($fields['id_automata_state']) && !empty($fields['id_automata_state']) ){
            $criteria->add(Machine::ID_AUTOMATA_STATE, $fields['id_automata_state']);
        }
        if( isset($fields['next_state']) && !empty($fields['next_state']) ){
            $criteria->add(Machine::NEXT_STATE, $fields['next_state']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MachineQuery
     */
    public function innerJoinElement($alias = 'Machine', $aliasForeignTable = 'Element')
    {
        $this->innerJoinOn(\Application\Model\Bean\Element::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_element'), array($aliasForeignTable, 'id_element'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MachineQuery
     */
    public function innerJoinCondition($alias = 'Machine', $aliasForeignTable = 'Condition')
    {
        $this->innerJoinOn(\Application\Model\Bean\Condition::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_automata_condition'), array($aliasForeignTable, 'id_automata_condition'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MachineQuery
     */
    public function innerJoinState($alias = 'Machine', $aliasForeignTable = 'State')
    {
        $this->innerJoinOn(\Application\Model\Bean\State::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_automata_state'), array($aliasForeignTable, 'id_automata_state'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MachineQuery
     */
    public function innerJoinNextState($alias = 'Machine', $aliasForeignTable = 'State')
    {
        $this->innerJoinOn(\Application\Model\Bean\State::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'next_state'), array($aliasForeignTable, 'id_automata_state'));

        return $this;
    }


}