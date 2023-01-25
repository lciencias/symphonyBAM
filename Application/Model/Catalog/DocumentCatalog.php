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
use Application\Model\Bean\Document;
use Application\Model\Factory\DocumentFactory;
use Application\Model\Collection\DocumentCollection;
use Application\Model\Exception\DocumentException;
use Application\Model\Bean\Bean;
use Application\Query\DocumentQuery;
use Query\Query;

/**
 *
 * DocumentCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Document getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\DocumentCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class DocumentCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Document a la base de datos
     * @param Document $document Objeto Document
     */
    public function create($document)
    {
        $this->validateBean($document);
        try
        {
            $data = $document->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Document::TABLENAME, $data);
            $document->setIdDocument($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Document can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Document en la base de datos
     * @param Document $document Objeto Document
     */
    public function update($document)
    {
        $this->validateBean($document);
        try
        {
            $data = $document->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Document::TABLENAME, $data, "id_document = '{$document->getIdDocument()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Document can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Document a partir de su Id
     * @param int $idDocument
     */
    public function deleteById($idDocument)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_document = ?', $idDocument));
            $this->getDb()->delete(Document::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Document can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\DocumentCollection
     */
    protected function makeCollection(){
        return new DocumentCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Document
     */
    protected function makeBean($resultset){
        return DocumentFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param DocumentQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof DocumentQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Document
     * @param Document $document
     * @throws Exception
     */
    protected function validateBean($document = null){
        if( !($document instanceof Document) ){
            $this->throwException("passed parameter isn't a Document instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new DocumentException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new DocumentException($message);
        }
    }

 }