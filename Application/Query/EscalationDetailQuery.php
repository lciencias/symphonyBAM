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
use Application\Model\Catalog\EscalationDetailCatalog;
use Application\Model\Bean\EscalationDetail;

use Application\Query\BaseQuery;

/**
 * Application\Query\EscalationDetailQuery
 *
 * @method \Application\Query\EscalationDetailQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EscalationDetailQuery useMemoryCache()
 * @method \Application\Query\EscalationDetailQuery useFileCache()
 * @method \Application\Model\Collection\EscalationDetailCollection find()
 * @method \Application\Model\Bean\EscalationDetail findOne()
 * @method \Application\Model\Bean\EscalationDetail findOneOrElse() findOneOrElse(EscalationDetail $alternative)
 * @method \Application\Model\Bean\EscalationDetail findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\EscalationDetail findByPK() findByPK($pk)
 * @method \Application\Model\Bean\EscalationDetail findByPKOrElse() findByPKOrElse($pk, EscalationDetail $alternative)
 * @method \Application\Model\Bean\EscalationDetail findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EscalationDetailQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EscalationDetailQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationDetailQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationDetailQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EscalationDetailQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EscalationDetailQuery removeJoins()
 * @method \Application\Query\EscalationDetailQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EscalationDetailQuery from() from($table, $alias = null)
 * @method \Application\Query\EscalationDetailQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EscalationDetailQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EscalationDetailQuery bind() bind($parameters)
 * @method \Application\Query\EscalationDetailQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EscalationDetailQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EscalationDetailQuery setLimit() setLimit($limit)
 * @method \Application\Query\EscalationDetailQuery setOffset() setOffset($offset)
 * @method \Application\Query\EscalationDetailQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EscalationDetailQuery distinct()
 * @method \Application\Query\EscalationDetailQuery select()
 * @method \Application\Query\EscalationDetailQuery addColumns() addColumns($columns)
 * @method \Application\Query\EscalationDetailQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EscalationDetailQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EscalationDetailQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EscalationDetailQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EscalationDetailQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EscalationDetailQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EscalationDetailQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EscalationDetailQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\EscalationDetailCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EscalationDetailCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(EscalationDetail::TABLENAME, "EscalationDetail");

        $defaultColumn = array("EscalationDetail.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\EscalationDetailQuery
     */
    public function pk($value){
        $this->filter(array(
            EscalationDetail::ID_ESCALATION_DETAILS => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(EscalationDetail::ID_ESCALATION_DETAILS, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EscalationDetailQuery
     */
    public function filter($fields, $prefix = 'EscalationDetail'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'EscalationDetail')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_escalation_details']) && !empty($fields['id_escalation_details']) ){
            $criteria->add(EscalationDetail::ID_ESCALATION_DETAILS, $fields['id_escalation_details']);
        }
        if( isset($fields['id_escalation']) && !empty($fields['id_escalation']) ){
            $criteria->add(EscalationDetail::ID_ESCALATION, $fields['id_escalation']);
        }
        if( isset($fields['percentage']) && !empty($fields['percentage']) ){
            $criteria->add(EscalationDetail::PERCENTAGE, $fields['percentage']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(EscalationDetail::TYPE, $fields['type']);
        }
        if( isset($fields['value']) && !empty($fields['value']) ){
            $criteria->add(EscalationDetail::VALUE, $fields['value']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EscalationDetailQuery
     */
    public function innerJoinEscalation($alias = 'EscalationDetail', $aliasForeignTable = 'Escalation')
    {
        $this->innerJoinOn(\Application\Model\Bean\Escalation::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_escalation'), array($aliasForeignTable, 'id_escalation'));

        return $this;
    }


}