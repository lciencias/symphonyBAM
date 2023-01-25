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
use Application\Model\Catalog\DocumentLogCatalog;
use Application\Model\Bean\DocumentLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\DocumentLogQuery
 *
 * @method \Application\Query\DocumentLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\DocumentLogQuery useMemoryCache()
 * @method \Application\Query\DocumentLogQuery useFileCache()
 * @method \Application\Model\Collection\DocumentLogCollection find()
 * @method \Application\Model\Bean\DocumentLog findOne()
 * @method \Application\Model\Bean\DocumentLog findOneOrElse() findOneOrElse(DocumentLog $alternative)
 * @method \Application\Model\Bean\DocumentLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\DocumentLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\DocumentLog findByPKOrElse() findByPKOrElse($pk, DocumentLog $alternative)
 * @method \Application\Model\Bean\DocumentLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\DocumentLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\DocumentLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\DocumentLogQuery removeJoins()
 * @method \Application\Query\DocumentLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\DocumentLogQuery from() from($table, $alias = null)
 * @method \Application\Query\DocumentLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\DocumentLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\DocumentLogQuery bind() bind($parameters)
 * @method \Application\Query\DocumentLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\DocumentLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\DocumentLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\DocumentLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\DocumentLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\DocumentLogQuery distinct()
 * @method \Application\Query\DocumentLogQuery select()
 * @method \Application\Query\DocumentLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\DocumentLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\DocumentLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\DocumentLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\DocumentLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\DocumentLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\DocumentLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\DocumentLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class DocumentLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\DocumentLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('DocumentLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(DocumentLog::TABLENAME, "DocumentLog");

        $defaultColumn = array("DocumentLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\DocumentLogQuery
     */
    public function pk($value){
        $this->filter(array(
            DocumentLog::ID_DOCUMENT_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(DocumentLog::ID_DOCUMENT_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\DocumentLogQuery
     */
    public function filter($fields, $prefix = 'DocumentLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'DocumentLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_document_log']) && !empty($fields['id_document_log']) ){
            $criteria->add(DocumentLog::ID_DOCUMENT_LOG, $fields['id_document_log']);
        }
        if( isset($fields['id_document']) && !empty($fields['id_document']) ){
            $criteria->add(DocumentLog::ID_DOCUMENT, $fields['id_document']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(DocumentLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(DocumentLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(DocumentLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(DocumentLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }


}