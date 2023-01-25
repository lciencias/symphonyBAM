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

use Application\Model\Bean\File;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\Document;

use Query\Query;
use Application\Model\Catalog\TicketClientDocumentCatalog;
use Application\Model\Bean\TicketClientDocument;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketClientDocumentQuery
 *
 * @method \Application\Query\TicketClientDocumentQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketClientDocumentQuery useMemoryCache()
 * @method \Application\Query\TicketClientDocumentQuery useFileCache()
 * @method \Application\Model\Collection\TicketClientDocumentCollection find()
 * @method \Application\Model\Bean\TicketClientDocument findOne()
 * @method \Application\Model\Bean\TicketClientDocument findOneOrElse() findOneOrElse(TicketClientDocument $alternative)
 * @method \Application\Model\Bean\TicketClientDocument findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketClientDocument findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketClientDocument findByPKOrElse() findByPKOrElse($pk, TicketClientDocument $alternative)
 * @method \Application\Model\Bean\TicketClientDocument findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketClientDocumentQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery removeJoins()
 * @method \Application\Query\TicketClientDocumentQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketClientDocumentQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketClientDocumentQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketClientDocumentQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketClientDocumentQuery bind() bind($parameters)
 * @method \Application\Query\TicketClientDocumentQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketClientDocumentQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketClientDocumentQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketClientDocumentQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketClientDocumentQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketClientDocumentQuery distinct()
 * @method \Application\Query\TicketClientDocumentQuery select()
 * @method \Application\Query\TicketClientDocumentQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketClientDocumentQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketClientDocumentQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketClientDocumentQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketClientDocumentQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketClientDocumentQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketClientDocumentQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketClientDocumentQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketClientDocumentQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketClientDocumentCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketClientDocumentCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketClientDocument::TABLENAME, "TicketClientDocument");

        $defaultColumn = array("TicketClientDocument.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketClientDocumentQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketClientDocument::ID_TICKET_CLIENT_DOCUMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketClientDocument::ID_TICKET_CLIENT_DOCUMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketClientDocumentQuery
     */
    public function filter($fields, $prefix = 'TicketClientDocument'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketClientDocument')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_client_document']) && !empty($fields['id_ticket_client_document']) ){
            $criteria->add(TicketClientDocument::ID_TICKET_CLIENT_DOCUMENT, $fields['id_ticket_client_document']);
        }
        if( isset($fields['id_document']) && !empty($fields['id_document']) ){
            $criteria->add(TicketClientDocument::ID_DOCUMENT, $fields['id_document']);
        }
        if( isset($fields['id_ticket_client']) && !empty($fields['id_ticket_client']) ){
            $criteria->add(TicketClientDocument::ID_TICKET_CLIENT, $fields['id_ticket_client']);
        }
        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
            $criteria->add(TicketClientDocument::ID_FILE, $fields['id_file']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientDocumentQuery
     */
    public function innerJoinDocument($alias = 'TicketClientDocument', $aliasForeignTable = 'Document')
    {
        $this->innerJoinOn(Document::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_document'), array($aliasForeignTable, 'id_document'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientDocumentQuery
     */
    public function innerJoinTicketClient($alias = 'TicketClientDocument', $aliasForeignTable = 'TicketClient')
    {
        $this->innerJoinOn(TicketClient::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket_client'), array($aliasForeignTable, 'id_ticket_client'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientDocumentQuery
     */
    public function innerJoinFile($alias = 'TicketClientDocument', $aliasForeignTable = 'File')
    {
        $this->innerJoinOn(File::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_file'), array($aliasForeignTable, 'id_file'));

        return $this;
    }


}