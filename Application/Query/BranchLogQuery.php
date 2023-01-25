<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;


use Application\Model\Bean\Branch;

use Query\Query;
use Application\Model\Catalog\BranchLogCatalog;
use Application\Model\Bean\BranchLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\BranchLogQuery
 *
 * @method \Application\Query\BranchLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\BranchLogQuery useMemoryCache()
 * @method \Application\Query\BranchLogQuery useFileCache()
 * @method \Application\Model\Collection\BranchLogCollection find()
 * @method \Application\Model\Bean\BranchLog findOne()
 * @method \Application\Model\Bean\BranchLog findOneOrElse() findOneOrElse(BranchLog $alternative)
 * @method \Application\Model\Bean\BranchLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\BranchLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\BranchLog findByPKOrElse() findByPKOrElse($pk, BranchLog $alternative)
 * @method \Application\Model\Bean\BranchLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\BranchLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\BranchLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\BranchLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\BranchLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\BranchLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\BranchLogQuery removeJoins()
 * @method \Application\Query\BranchLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\BranchLogQuery from() from($table, $alias = null)
 * @method \Application\Query\BranchLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\BranchLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\BranchLogQuery bind() bind($parameters)
 * @method \Application\Query\BranchLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\BranchLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\BranchLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\BranchLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\BranchLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\BranchLogQuery distinct()
 * @method \Application\Query\BranchLogQuery select()
 * @method \Application\Query\BranchLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\BranchLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\BranchLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\BranchLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\BranchLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\BranchLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\BranchLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\BranchLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class BranchLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\BranchLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('BranchLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(BranchLog::TABLENAME, "BranchLog");

        $defaultColumn = array("BranchLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\BranchLogQuery
     */
    public function pk($value){
        $this->filter(array(
            BranchLog::ID_BRANCH_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(BranchLog::ID_BRANCH_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\BranchLogQuery
     */
    public function filter($fields, $prefix = 'BranchLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'BranchLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_branch_log']) && !empty($fields['id_branch_log']) ){
            $criteria->add(BranchLog::ID_BRANCH_LOG, $fields['id_branch_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(BranchLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_branch']) && !empty($fields['id_branch']) ){
            $criteria->add(BranchLog::ID_BRANCH, $fields['id_branch']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(BranchLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(BranchLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(BranchLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BranchLogQuery
     */
    public function innerJoinUsers($alias = 'BranchLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BranchLogQuery
     */
    public function innerJoinBranches($alias = 'BranchLog', $aliasForeignTable = 'Branch')
    {
        $this->innerJoinOn(Branch::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_branch'), array($aliasForeignTable, 'id_branch'));

        return $this;
    }


}