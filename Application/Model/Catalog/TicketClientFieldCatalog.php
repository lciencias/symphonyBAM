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
use Application\Model\Bean\TicketClientField;
use Application\Model\Factory\TicketClientFieldFactory;
use Application\Model\Collection\TicketClientFieldCollection;
use Application\Model\Exception\TicketClientFieldException;
use Application\Model\Bean\Bean;
use Application\Query\TicketClientFieldQuery;
use Query\Query;

/**
 *
 * TicketClientFieldCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\TicketClientField getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketClientFieldCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketClientFieldCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TicketClientField a la base de datos
     * @param TicketClientField $ticketClientField Objeto TicketClientField
     */
    public function create($ticketClientField)
    {
        $this->validateBean($ticketClientField);
        try
        {
            $data = $ticketClientField->toArrayFor(
                array('id_ticket_client', 'id_field', 'value', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TicketClientField::TABLENAME, $data);
            $ticketClientField->setIdTicketClientField($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientField can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketClientField en la base de datos
     * @param TicketClientField $ticketClientField Objeto TicketClientField
     */
    public function update($ticketClientField)
    {
        $this->validateBean($ticketClientField);
        try
        {
            $data = $ticketClientField->toArrayFor(
                array('id_ticket_client', 'id_field', 'value', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketClientField::TABLENAME, $data, "id_ticket_client_field = '{$ticketClientField->getIdTicketClientField()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientField can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketClientField a partir de su Id
     * @param int $idTicketClientField
     */
    public function deleteById($idTicketClientField)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_client_field = ?', $idTicketClientField));
            $this->getDb()->delete(TicketClientField::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClientField can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketClientFieldCollection
     */
    protected function makeCollection(){
        return new TicketClientFieldCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketClientField
     */
    protected function makeBean($resultset){
        return TicketClientFieldFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketClientFieldQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketClientFieldQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketClientField
     * @param TicketClientField $ticketClientField
     * @throws Exception
     */
    protected function validateBean($ticketClientField = null){
        if( !($ticketClientField instanceof TicketClientField) ){
            $this->throwException("passed parameter isn't a TicketClientField instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketClientFieldException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketClientFieldException($message);
        }
    }

 }