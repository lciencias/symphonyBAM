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
use Application\Model\Catalog\DocumentCatalog;
use Application\Model\Bean\Document;

use Application\Query\BaseQuery;

/**
 * Application\Query\DocumentQuery
 *
 * @method \Application\Query\DocumentQuery pk() pk(int $primaryKey)
 * @method \Application\Query\DocumentQuery useMemoryCache()
 * @method \Application\Query\DocumentQuery useFileCache()
 * @method \Application\Model\Collection\DocumentCollection find()
 * @method \Application\Model\Bean\Document findOne()
 * @method \Application\Model\Bean\Document findOneOrElse() findOneOrElse(Document $alternative)
 * @method \Application\Model\Bean\Document findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Document findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Document findByPKOrElse() findByPKOrElse($pk, Document $alternative)
 * @method \Application\Model\Bean\Document findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\DocumentQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\DocumentQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\DocumentQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\DocumentQuery removeJoins()
 * @method \Application\Query\DocumentQuery removeJoin() removeJoin($table)
 * @method \Application\Query\DocumentQuery from() from($table, $alias = null)
 * @method \Application\Query\DocumentQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\DocumentQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\DocumentQuery bind() bind($parameters)
 * @method \Application\Query\DocumentQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\DocumentQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\DocumentQuery setLimit() setLimit($limit)
 * @method \Application\Query\DocumentQuery setOffset() setOffset($offset)
 * @method \Application\Query\DocumentQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\DocumentQuery distinct()
 * @method \Application\Query\DocumentQuery select()
 * @method \Application\Query\DocumentQuery addColumns() addColumns($columns)
 * @method \Application\Query\DocumentQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\DocumentQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\DocumentQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\DocumentQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\DocumentQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\DocumentQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\DocumentQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class DocumentQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\DocumentCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('DocumentCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Document::TABLENAME, "Document");

        $defaultColumn = array("Document.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\DocumentQuery
     */
    public function pk($value){
        $this->filter(array(
            Document::ID_DOCUMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Document::ID_DOCUMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\DocumentQuery
     */
    public function filter($fields, $prefix = 'Document'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Document')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_document']) && !empty($fields['id_document']) ){
            $criteria->add(Document::ID_DOCUMENT, $fields['id_document']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Document::NAME, $fields['name']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(Document::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Document::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\FieldQuery
     */
    public function actives(){
    	return $this->filter(array(
    			Document::STATUS => Document::$Status['Active'],
    	));
    }
}