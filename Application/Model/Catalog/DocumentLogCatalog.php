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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\DocumentLog;
use Application\Model\Factory\DocumentLogFactory;
use Application\Model\Collection\DocumentLogCollection;
use Application\Model\Exception\DocumentLogException;
use Application\Model\Bean\Bean;
use Application\Query\DocumentLogQuery;
use Query\Query;

/**
 *
 * DocumentLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\DocumentLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\DocumentLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class DocumentLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un DocumentLog a la base de datos
     * @param DocumentLog $documentLog Objeto DocumentLog
     */
    public function create($documentLog)
    {
        $this->validateBean($documentLog);
        try
        {
            $data = $documentLog->toArrayFor(
                array('id_document', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(DocumentLog::TABLENAME, $data);
            $documentLog->setIdDocumentLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The DocumentLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un DocumentLog en la base de datos
     * @param DocumentLog $documentLog Objeto DocumentLog
     */
    public function update($documentLog)
    {
        $this->validateBean($documentLog);
        try
        {
            $data = $documentLog->toArrayFor(
                array('id_document', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(DocumentLog::TABLENAME, $data, "id_document_log = '{$documentLog->getIdDocumentLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The DocumentLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un DocumentLog a partir de su Id
     * @param int $idDocumentLog
     */
    public function deleteById($idDocumentLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_document_log = ?', $idDocumentLog));
            $this->getDb()->delete(DocumentLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The DocumentLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\DocumentLogCollection
     */
    protected function makeCollection(){
        return new DocumentLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\DocumentLog
     */
    protected function makeBean($resultset){
        return DocumentLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param DocumentLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof DocumentLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate DocumentLog
     * @param DocumentLog $documentLog
     * @throws Exception
     */
    protected function validateBean($documentLog = null){
        if( !($documentLog instanceof DocumentLog) ){
            $this->throwException("passed parameter isn't a DocumentLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new DocumentLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new DocumentLogException($message);
        }
    }

 }