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
use Application\Model\Bean\RequiredDocument;
use Application\Model\Factory\RequiredDocumentFactory;
use Application\Model\Collection\RequiredDocumentCollection;
use Application\Model\Exception\RequiredDocumentException;
use Application\Model\Bean\Bean;
use Application\Query\RequiredDocumentQuery;
use Query\Query;

/**
 *
 * RequiredDocumentCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\RequiredDocument getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\RequiredDocumentCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class RequiredDocumentCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un RequiredDocument a la base de datos
     * @param RequiredDocument $requiredDocument Objeto RequiredDocument
     */
    public function create($requiredDocument)
    {
        $this->validateBean($requiredDocument);
        try
        {
            $data = $requiredDocument->toArrayFor(
                array('id_client_category', 'id_document', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(RequiredDocument::TABLENAME, $data);
            $requiredDocument->setIdRequiredDocument($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocument can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un RequiredDocument en la base de datos
     * @param RequiredDocument $requiredDocument Objeto RequiredDocument
     */
    public function update($requiredDocument)
    {
        $this->validateBean($requiredDocument);
        try
        {
            $data = $requiredDocument->toArrayFor(
                array('id_client_category', 'id_document', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(RequiredDocument::TABLENAME, $data, "id_required_document = '{$requiredDocument->getIdRequiredDocument()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocument can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un RequiredDocument a partir de su Id
     * @param int $idRequiredDocument
     */
    public function deleteById($idRequiredDocument)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_required_document = ?', $idRequiredDocument));
            $this->getDb()->delete(RequiredDocument::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredDocument can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\RequiredDocumentCollection
     */
    protected function makeCollection(){
        return new RequiredDocumentCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\RequiredDocument
     */
    protected function makeBean($resultset){
        return RequiredDocumentFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param RequiredDocumentQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof RequiredDocumentQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate RequiredDocument
     * @param RequiredDocument $requiredDocument
     * @throws Exception
     */
    protected function validateBean($requiredDocument = null){
        if( !($requiredDocument instanceof RequiredDocument) ){
            $this->throwException("passed parameter isn't a RequiredDocument instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new RequiredDocumentException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new RequiredDocumentException($message);
        }
    }

 }