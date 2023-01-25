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

use Application\Model\Bean\RequiredField;

use Application\Model\Bean\User;

use Query\Query;
use Application\Model\Catalog\RequiredFieldLogCatalog;
use Application\Model\Bean\RequiredFieldLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\RequiredFieldLogQuery
 *
 * @method \Application\Query\RequiredFieldLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\RequiredFieldLogQuery useMemoryCache()
 * @method \Application\Query\RequiredFieldLogQuery useFileCache()
 * @method \Application\Model\Collection\RequiredFieldLogCollection find()
 * @method \Application\Model\Bean\RequiredFieldLog findOne()
 * @method \Application\Model\Bean\RequiredFieldLog findOneOrElse() findOneOrElse(RequiredFieldLog $alternative)
 * @method \Application\Model\Bean\RequiredFieldLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\RequiredFieldLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\RequiredFieldLog findByPKOrElse() findByPKOrElse($pk, RequiredFieldLog $alternative)
 * @method \Application\Model\Bean\RequiredFieldLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\RequiredFieldLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery removeJoins()
 * @method \Application\Query\RequiredFieldLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\RequiredFieldLogQuery from() from($table, $alias = null)
 * @method \Application\Query\RequiredFieldLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\RequiredFieldLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\RequiredFieldLogQuery bind() bind($parameters)
 * @method \Application\Query\RequiredFieldLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\RequiredFieldLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\RequiredFieldLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\RequiredFieldLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\RequiredFieldLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\RequiredFieldLogQuery distinct()
 * @method \Application\Query\RequiredFieldLogQuery select()
 * @method \Application\Query\RequiredFieldLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\RequiredFieldLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\RequiredFieldLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\RequiredFieldLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\RequiredFieldLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\RequiredFieldLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\RequiredFieldLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\RequiredFieldLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class RequiredFieldLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\RequiredFieldLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('RequiredFieldLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(RequiredFieldLog::TABLENAME, "RequiredFieldLog");

        $defaultColumn = array("RequiredFieldLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\RequiredFieldLogQuery
     */
    public function pk($value){
        $this->filter(array(
            RequiredFieldLog::ID_REQUIRED_FIELD_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(RequiredFieldLog::ID_REQUIRED_FIELD_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\RequiredFieldLogQuery
     */
    public function filter($fields, $prefix = 'RequiredFieldLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'RequiredFieldLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_required_field_log']) && !empty($fields['id_required_field_log']) ){
            $criteria->add(RequiredFieldLog::ID_REQUIRED_FIELD_LOG, $fields['id_required_field_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(RequiredFieldLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_required_field']) && !empty($fields['id_required_field']) ){
            $criteria->add(RequiredFieldLog::ID_REQUIRED_FIELD, $fields['id_required_field']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(RequiredFieldLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(RequiredFieldLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(RequiredFieldLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredFieldLogQuery
     */
    public function innerJoin($alias = 'RequiredFieldLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredFieldLogQuery
     */
    public function innerJoin($alias = 'RequiredFieldLog', $aliasForeignTable = 'RequiredField')
    {
        $this->innerJoinOn(RequiredField::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_required_field'), array($aliasForeignTable, 'id_required_field'));

        return $this;
    }


}