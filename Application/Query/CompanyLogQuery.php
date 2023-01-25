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
use Application\Model\Catalog\CompanyLogCatalog;
use Application\Model\Bean\CompanyLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\CompanyLogQuery
 *
 * @method \Application\Query\CompanyLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CompanyLogQuery useMemoryCache()
 * @method \Application\Query\CompanyLogQuery useFileCache()
 * @method \Application\Model\Collection\CompanyLogCollection find()
 * @method \Application\Model\Bean\CompanyLog findOne()
 * @method \Application\Model\Bean\CompanyLog findOneOrElse() findOneOrElse(CompanyLog $alternative)
 * @method \Application\Model\Bean\CompanyLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\CompanyLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\CompanyLog findByPKOrElse() findByPKOrElse($pk, CompanyLog $alternative)
 * @method \Application\Model\Bean\CompanyLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CompanyLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CompanyLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CompanyLogQuery removeJoins()
 * @method \Application\Query\CompanyLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CompanyLogQuery from() from($table, $alias = null)
 * @method \Application\Query\CompanyLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CompanyLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CompanyLogQuery bind() bind($parameters)
 * @method \Application\Query\CompanyLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CompanyLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CompanyLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\CompanyLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\CompanyLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CompanyLogQuery distinct()
 * @method \Application\Query\CompanyLogQuery select()
 * @method \Application\Query\CompanyLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\CompanyLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CompanyLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CompanyLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CompanyLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CompanyLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CompanyLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CompanyLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CompanyLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CompanyLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CompanyLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(CompanyLog::TABLENAME, "CompanyLog");

        $defaultColumn = array("CompanyLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\CompanyLogQuery
     */
    public function pk($value){
        $this->filter(array(
            CompanyLog::ID_COMPANY_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(CompanyLog::ID_COMPANY_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CompanyLogQuery
     */
    public function filter($fields, $prefix = 'CompanyLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'CompanyLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_company_log']) && !empty($fields['id_company_log']) ){
            $criteria->add(CompanyLog::ID_COMPANY_LOG, $fields['id_company_log']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(CompanyLog::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(CompanyLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(CompanyLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(CompanyLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(CompanyLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CompanyLogQuery
     */
    public function innerJoinCompany($alias = 'CompanyLog', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CompanyLogQuery
     */
    public function innerJoinUser($alias = 'CompanyLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}