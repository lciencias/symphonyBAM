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

use Application\Model\Bean\User;

use Query\Query;
use Application\Model\Catalog\ClientCategoryLogCatalog;
use Application\Model\Bean\ClientCategoryLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ClientCategoryLogQuery
 *
 * @method \Application\Query\ClientCategoryLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientCategoryLogQuery useMemoryCache()
 * @method \Application\Query\ClientCategoryLogQuery useFileCache()
 * @method \Application\Model\Collection\ClientCategoryLogCollection find()
 * @method \Application\Model\Bean\ClientCategoryLog findOne()
 * @method \Application\Model\Bean\ClientCategoryLog findOneOrElse() findOneOrElse(ClientCategoryLog $alternative)
 * @method \Application\Model\Bean\ClientCategoryLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientCategoryLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientCategoryLog findByPKOrElse() findByPKOrElse($pk, ClientCategoryLog $alternative)
 * @method \Application\Model\Bean\ClientCategoryLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientCategoryLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery removeJoins()
 * @method \Application\Query\ClientCategoryLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientCategoryLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientCategoryLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientCategoryLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientCategoryLogQuery bind() bind($parameters)
 * @method \Application\Query\ClientCategoryLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientCategoryLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientCategoryLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientCategoryLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientCategoryLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientCategoryLogQuery distinct()
 * @method \Application\Query\ClientCategoryLogQuery select()
 * @method \Application\Query\ClientCategoryLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientCategoryLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientCategoryLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientCategoryLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientCategoryLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientCategoryLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientCategoryLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientCategoryLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientCategoryLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ClientCategoryLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ClientCategoryLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ClientCategoryLog::TABLENAME, "ClientCategoryLog");

        $defaultColumn = array("ClientCategoryLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ClientCategoryLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ClientCategoryLog::ID_CATEGORY_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ClientCategoryLog::ID_CATEGORY_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ClientCategoryLogQuery
     */
    public function filter($fields, $prefix = 'ClientCategoryLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ClientCategoryLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_category_log']) && !empty($fields['id_category_log']) ){
            $criteria->add(ClientCategoryLog::ID_CATEGORY_LOG, $fields['id_category_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ClientCategoryLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(ClientCategoryLog::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ClientCategoryLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(ClientCategoryLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(ClientCategoryLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryLogQuery
     */
    public function innerJoin($alias = 'ClientCategoryLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryLogQuery
     */
    public function innerJoinClientCategory($alias = 'ClientCategoryLog', $aliasForeignTable = 'ClientCategory')
    {
        $this->innerJoinOn(\Application\Model\Bean\ClientCategory::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));

        return $this;
    }


}