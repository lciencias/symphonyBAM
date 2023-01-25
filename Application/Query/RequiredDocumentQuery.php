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

use Application\Model\Bean\Document;

use Application\Model\Bean\ClientCategory;

use Query\Query;
use Application\Model\Catalog\RequiredDocumentCatalog;
use Application\Model\Bean\RequiredDocument;

use Application\Query\BaseQuery;

/**
 * Application\Query\RequiredDocumentQuery
 *
 * @method \Application\Query\RequiredDocumentQuery pk() pk(int $primaryKey)
 * @method \Application\Query\RequiredDocumentQuery useMemoryCache()
 * @method \Application\Query\RequiredDocumentQuery useFileCache()
 * @method \Application\Model\Collection\RequiredDocumentCollection find()
 * @method \Application\Model\Bean\RequiredDocument findOne()
 * @method \Application\Model\Bean\RequiredDocument findOneOrElse() findOneOrElse(RequiredDocument $alternative)
 * @method \Application\Model\Bean\RequiredDocument findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\RequiredDocument findByPK() findByPK($pk)
 * @method \Application\Model\Bean\RequiredDocument findByPKOrElse() findByPKOrElse($pk, RequiredDocument $alternative)
 * @method \Application\Model\Bean\RequiredDocument findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\RequiredDocumentQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery removeJoins()
 * @method \Application\Query\RequiredDocumentQuery removeJoin() removeJoin($table)
 * @method \Application\Query\RequiredDocumentQuery from() from($table, $alias = null)
 * @method \Application\Query\RequiredDocumentQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\RequiredDocumentQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\RequiredDocumentQuery bind() bind($parameters)
 * @method \Application\Query\RequiredDocumentQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\RequiredDocumentQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\RequiredDocumentQuery setLimit() setLimit($limit)
 * @method \Application\Query\RequiredDocumentQuery setOffset() setOffset($offset)
 * @method \Application\Query\RequiredDocumentQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\RequiredDocumentQuery distinct()
 * @method \Application\Query\RequiredDocumentQuery select()
 * @method \Application\Query\RequiredDocumentQuery addColumns() addColumns($columns)
 * @method \Application\Query\RequiredDocumentQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\RequiredDocumentQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\RequiredDocumentQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\RequiredDocumentQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\RequiredDocumentQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\RequiredDocumentQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\RequiredDocumentQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class RequiredDocumentQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\RequiredDocumentCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('RequiredDocumentCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(RequiredDocument::TABLENAME, "RequiredDocument");

        $defaultColumn = array("RequiredDocument.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\RequiredDocumentQuery
     */
    public function pk($value){
        $this->filter(array(
            RequiredDocument::ID_REQUIRED_DOCUMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(RequiredDocument::ID_REQUIRED_DOCUMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\RequiredDocumentQuery
     */
    public function filter($fields, $prefix = 'RequiredDocument'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'RequiredDocument')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_required_document']) && !empty($fields['id_required_document']) ){
            $criteria->add(RequiredDocument::ID_REQUIRED_DOCUMENT, $fields['id_required_document']);
        }
        if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(RequiredDocument::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }
        if( isset($fields['id_document']) && !empty($fields['id_document']) ){
            $criteria->add(RequiredDocument::ID_DOCUMENT, $fields['id_document']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredDocumentQuery
     */
    public function innerJoinClientCategory($alias = 'RequiredDocument', $aliasForeignTable = 'ClientCategory')
    {
        $this->innerJoinOn(ClientCategory::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredDocumentQuery
     */
    public function innerJoinDocument($alias = 'RequiredDocument', $aliasForeignTable = 'Document')
    {
        $this->innerJoinOn(Document::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_document'), array($aliasForeignTable, 'id_document'));

        return $this;
    }


}