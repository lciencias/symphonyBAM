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

use Application\Storage\StorageFactory;

use Query\Query;
use Application\Model\Catalog\EscalationCatalog;
use Application\Model\Bean\Escalation;

use Application\Query\BaseQuery;

/**
 * Application\Query\EscalationQuery
 *
 * @method \Application\Query\EscalationQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EscalationQuery useMemoryCache()
 * @method \Application\Query\EscalationQuery useFileCache()
 * @method \Application\Model\Collection\EscalationCollection find()
 * @method \Application\Model\Bean\Escalation findOne()
 * @method \Application\Model\Bean\Escalation findOneOrElse() findOneOrElse(Escalation $alternative)
 * @method \Application\Model\Bean\Escalation findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Escalation findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Escalation findByPKOrElse() findByPKOrElse($pk, Escalation $alternative)
 * @method \Application\Model\Bean\Escalation findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EscalationQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EscalationQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EscalationQuery removeJoins()
 * @method \Application\Query\EscalationQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EscalationQuery from() from($table, $alias = null)
 * @method \Application\Query\EscalationQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EscalationQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EscalationQuery bind() bind($parameters)
 * @method \Application\Query\EscalationQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EscalationQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EscalationQuery setLimit() setLimit($limit)
 * @method \Application\Query\EscalationQuery setOffset() setOffset($offset)
 * @method \Application\Query\EscalationQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EscalationQuery distinct()
 * @method \Application\Query\EscalationQuery select()
 * @method \Application\Query\EscalationQuery addColumns() addColumns($columns)
 * @method \Application\Query\EscalationQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EscalationQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EscalationQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EscalationQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EscalationQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EscalationQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EscalationQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EscalationQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\EscalationCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EscalationCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Escalation::TABLENAME, "Escalation");

        $defaultColumn = array("Escalation.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\EscalationQuery
     */
    public function pk($value){
        $this->filter(array(
            Escalation::ID_ESCALATION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Escalation::ID_ESCALATION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EscalationQuery
     */
    public function filter($fields, $prefix = 'Escalation'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Escalation')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_escalation']) && !empty($fields['id_escalation']) ){
            $criteria->add(Escalation::ID_ESCALATION, $fields['id_escalation']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Escalation::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Escalation::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\EscalationQuery
     */
    public function actives(){
        return $this->filter(array(
            Escalation::STATUS => Escalation::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\EscalationQuery
     */
    public function inactives(){
        return $this->filter(array(
            Escalation::STATUS => Escalation::$Status['Inactive'],
        ));
    }


}