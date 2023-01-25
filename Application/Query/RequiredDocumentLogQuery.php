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

use Application\Model\Bean\RequiredDocument;

use Application\Model\Bean\User;

use Query\Query;
use Application\Model\Catalog\RequiredDocumentLogCatalog;
use Application\Model\Bean\RequiredDocumentLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\RequiredDocumentLogQuery
 *
 * @method \Application\Query\RequiredDocumentLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\RequiredDocumentLogQuery useMemoryCache()
 * @method \Application\Query\RequiredDocumentLogQuery useFileCache()
 * @method \Application\Model\Collection\RequiredDocumentLogCollection find()
 * @method \Application\Model\Bean\RequiredDocumentLog findOne()
 * @method \Application\Model\Bean\RequiredDocumentLog findOneOrElse() findOneOrElse(RequiredDocumentLog $alternative)
 * @method \Application\Model\Bean\RequiredDocumentLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\RequiredDocumentLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\RequiredDocumentLog findByPKOrElse() findByPKOrElse($pk, RequiredDocumentLog $alternative)
 * @method \Application\Model\Bean\RequiredDocumentLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\RequiredDocumentLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery removeJoins()
 * @method \Application\Query\RequiredDocumentLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\RequiredDocumentLogQuery from() from($table, $alias = null)
 * @method \Application\Query\RequiredDocumentLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\RequiredDocumentLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\RequiredDocumentLogQuery bind() bind($parameters)
 * @method \Application\Query\RequiredDocumentLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\RequiredDocumentLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\RequiredDocumentLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\RequiredDocumentLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\RequiredDocumentLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\RequiredDocumentLogQuery distinct()
 * @method \Application\Query\RequiredDocumentLogQuery select()
 * @method \Application\Query\RequiredDocumentLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\RequiredDocumentLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\RequiredDocumentLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\RequiredDocumentLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\RequiredDocumentLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\RequiredDocumentLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\RequiredDocumentLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\RequiredDocumentLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class RequiredDocumentLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\RequiredDocumentLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('RequiredDocumentLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(RequiredDocumentLog::TABLENAME, "RequiredDocumentLog");

        $defaultColumn = array("RequiredDocumentLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\RequiredDocumentLogQuery
     */
    public function pk($value){
        $this->filter(array(
            RequiredDocumentLog::ID_REQUIRED_DOCUMENT_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(RequiredDocumentLog::ID_REQUIRED_DOCUMENT_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\RequiredDocumentLogQuery
     */
    public function filter($fields, $prefix = 'RequiredDocumentLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'RequiredDocumentLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_required_document_log']) && !empty($fields['id_required_document_log']) ){
            $criteria->add(RequiredDocumentLog::ID_REQUIRED_DOCUMENT_LOG, $fields['id_required_document_log']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(RequiredDocumentLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['id_required_document']) && !empty($fields['id_required_document']) ){
            $criteria->add(RequiredDocumentLog::ID_REQUIRED_DOCUMENT, $fields['id_required_document']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(RequiredDocumentLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(RequiredDocumentLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['notes']) && !empty($fields['notes']) ){
            $criteria->add(RequiredDocumentLog::NOTES, $fields['notes']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredDocumentLogQuery
     */
    public function innerJoin($alias = 'RequiredDocumentLog', $aliasForeignTable = '')
    {
        $this->innerJoinOn(User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredDocumentLogQuery
     */
    public function innerJoin($alias = 'RequiredDocumentLog', $aliasForeignTable = 'Document')
    {
        $this->innerJoinOn(RequiredDocument::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_required_document'), array($aliasForeignTable, 'id_required_document'));

        return $this;
    }


}