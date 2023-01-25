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
use Application\Model\Bean\TicketClientDocument;
use Application\Model\Factory\TicketClientDocumentFactory;
use Application\Model\Collection\TicketClientDocumentCollection;
use Application\Model\Exception\TicketClientDocumentException;
use Application\Model\Bean\Bean;
use Application\Query\TicketClientDocumentQuery;
use Query\Query;

/**
 *
 * TicketClientDocumentCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\TicketClientDocument getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketClientDocumentCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketClientDocumentCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TicketClientDocument a la base de datos
     * @param TicketClientDocument $ticketClientDocument Objeto TicketClientDocument
     */
    public function create($ticketClientDocument)
    {
        $this->validateBean($ticketClientDocument);
        try
        {
            $data = $ticketClientDocument->toArrayFor(
                array('id_document', 'id_ticket_client', 'id_file', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TicketClientDocument::TABLENAME, $data);
            $ticketClientDocument->setIdTicketClientDocument($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientDocument can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketClientDocument en la base de datos
     * @param TicketClientDocument $ticketClientDocument Objeto TicketClientDocument
     */
    public function update($ticketClientDocument)
    {
        $this->validateBean($ticketClientDocument);
        try
        {
            $data = $ticketClientDocument->toArrayFor(
                array('id_document', 'id_ticket_client', 'id_file', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketClientDocument::TABLENAME, $data, "id_ticket_client_document = '{$ticketClientDocument->getIdTicketClientDocument()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientDocument can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketClientDocument a partir de su Id
     * @param int $idTicketClientDocument
     */
    public function deleteById($idTicketClientDocument)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_client_document = ?', $idTicketClientDocument));
            $this->getDb()->delete(TicketClientDocument::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientDocument can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketClientDocumentCollection
     */
    protected function makeCollection(){
        return new TicketClientDocumentCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketClientDocument
     */
    protected function makeBean($resultset){
        return TicketClientDocumentFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketClientDocumentQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketClientDocumentQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketClientDocument
     * @param TicketClientDocument $ticketClientDocument
     * @throws Exception
     */
    protected function validateBean($ticketClientDocument = null){
        if( !($ticketClientDocument instanceof TicketClientDocument) ){
            $this->throwException("passed parameter isn't a TicketClientDocument instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketClientDocumentException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketClientDocumentException($message);
        }
    }

 }