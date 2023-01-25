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
use Application\Model\Bean\RequiredDocumentLog;
use Application\Model\Factory\RequiredDocumentLogFactory;
use Application\Model\Collection\RequiredDocumentLogCollection;
use Application\Model\Exception\RequiredDocumentLogException;
use Application\Model\Bean\Bean;
use Application\Query\RequiredDocumentLogQuery;
use Query\Query;

/**
 *
 * RequiredDocumentLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\RequiredDocumentLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class RequiredDocumentLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un RequiredDocumentLog a la base de datos
     * @param RequiredDocumentLog $requiredDocumentLog Objeto RequiredDocumentLog
     */
    public function create($requiredDocumentLog)
    {
        $this->validateBean($requiredDocumentLog);
        try
        {
            $data = $requiredDocumentLog->toArrayFor(
                array('id_user', 'id_required_document', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(RequiredDocumentLog::TABLENAME, $data);
            $requiredDocumentLog->setIdRequiredDocumentLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocumentLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un RequiredDocumentLog en la base de datos
     * @param RequiredDocumentLog $requiredDocumentLog Objeto RequiredDocumentLog
     */
    public function update($requiredDocumentLog)
    {
        $this->validateBean($requiredDocumentLog);
        try
        {
            $data = $requiredDocumentLog->toArrayFor(
                array('id_user', 'id_required_document', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(RequiredDocumentLog::TABLENAME, $data, "id_required_document_log = '{$requiredDocumentLog->getIdRequiredDocumentLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocumentLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un RequiredDocumentLog a partir de su Id
     * @param int $idRequiredDocumentLog
     */
    public function deleteById($idRequiredDocumentLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_required_document_log = ?', $idRequiredDocumentLog));
            $this->getDb()->delete(RequiredDocumentLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocumentLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\RequiredDocumentLogCollection
     */
    protected function makeCollection(){
        return new RequiredDocumentLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\RequiredDocumentLog
     */
    protected function makeBean($resultset){
        return RequiredDocumentLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param RequiredDocumentLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof RequiredDocumentLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate RequiredDocumentLog
     * @param RequiredDocumentLog $requiredDocumentLog
     * @throws Exception
     */
    protected function validateBean($requiredDocumentLog = null){
        if( !($requiredDocumentLog instanceof RequiredDocumentLog) ){
            $this->throwException("passed parameter isn't a RequiredDocumentLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new RequiredDocumentLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new RequiredDocumentLogException($message);
        }
    }

 }