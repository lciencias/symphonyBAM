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

use Query\Query;
use Application\Model\Catalog\ClientResolutionLogCatalog;
use Application\Model\Bean\ClientResolutionLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\ClientResolutionLogQuery
 *
 * @method \Application\Query\ClientResolutionLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientResolutionLogQuery useMemoryCache()
 * @method \Application\Query\ClientResolutionLogQuery useFileCache()
 * @method \Application\Model\Collection\ClientResolutionLogCollection find()
 * @method \Application\Model\Bean\ClientResolutionLog findOne()
 * @method \Application\Model\Bean\ClientResolutionLog findOneOrElse() findOneOrElse(ClientResolutionLog $alternative)
 * @method \Application\Model\Bean\ClientResolutionLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientResolutionLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientResolutionLog findByPKOrElse() findByPKOrElse($pk, ClientResolutionLog $alternative)
 * @method \Application\Model\Bean\ClientResolutionLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientResolutionLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery removeJoins()
 * @method \Application\Query\ClientResolutionLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientResolutionLogQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientResolutionLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientResolutionLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientResolutionLogQuery bind() bind($parameters)
 * @method \Application\Query\ClientResolutionLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientResolutionLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientResolutionLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientResolutionLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientResolutionLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientResolutionLogQuery distinct()
 * @method \Application\Query\ClientResolutionLogQuery select()
 * @method \Application\Query\ClientResolutionLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientResolutionLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientResolutionLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientResolutionLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientResolutionLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientResolutionLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientResolutionLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientResolutionLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientResolutionLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ClientResolutionLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ClientResolutionLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ClientResolutionLog::TABLENAME, "ClientResolutionLog");

        $defaultColumn = array("ClientResolutionLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ClientResolutionLogQuery
     */
    public function pk($value){
        $this->filter(array(
            ClientResolutionLog::ID_CLIENT_RESOLUTION_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ClientResolutionLog::ID_CLIENT_RESOLUTION_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ClientResolutionLogQuery
     */
    public function filter($fields, $prefix = 'ClientResolutionLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ClientResolutionLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_client_resolution_log']) && !empty($fields['id_client_resolution_log']) ){
            $criteria->add(ClientResolutionLog::ID_CLIENT_RESOLUTION_LOG, $fields['id_client_resolution_log']);
        }
        if( isset($fields['id_client_resolution']) && !empty($fields['id_client_resolution']) ){
            $criteria->add(ClientResolutionLog::ID_CLIENT_RESOLUTION, $fields['id_client_resolution']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(ClientResolutionLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(ClientResolutionLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(ClientResolutionLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(ClientResolutionLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }


}