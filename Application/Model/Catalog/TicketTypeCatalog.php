<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\TicketType;
use Application\Model\Factory\TicketTypeFactory;
use Application\Model\Collection\TicketTypeCollection;
use Application\Model\Exception\TicketTypeException;
use Application\Model\Bean\Bean;
use Application\Query\TicketTypeQuery;
use Query\Query;

/**
 *
 * TicketTypeCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketType getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketTypeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketTypeCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TicketType a la base de datos
     * @param TicketType $ticketType Objeto TicketType
     */
    public function create($ticketType)
    {
        $this->validateBean($ticketType);
        try
        {
            $data = $ticketType->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TicketType::TABLENAME, $data);
            $ticketType->setIdTicketType($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketType can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketType en la base de datos
     * @param TicketType $ticketType Objeto TicketType
     */
    public function update($ticketType)
    {
        $this->validateBean($ticketType);
        try
        {
            $data = $ticketType->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketType::TABLENAME, $data, "id_ticket_type = '{$ticketType->getIdTicketType()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketType can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketType a partir de su Id
     * @param int $idTicketType
     */
    public function deleteById($idTicketType)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_type = ?', $idTicketType));
            $this->getDb()->delete(TicketType::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketType can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketTypeCollection
     */
    protected function makeCollection(){
        return new TicketTypeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketType
     */
    protected function makeBean($resultset){
        return TicketTypeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketTypeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketTypeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketType
     * @param TicketType $ticketType
     * @throws Exception
     */
    protected function validateBean($ticketType = null){
        if( !($ticketType instanceof TicketType) ){
            $this->throwException("passed parameter isn't a TicketType instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketTypeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketTypeException($message);
        }
    }

 }