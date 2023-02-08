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
use Application\Model\Bean\Ticket;
use Application\Model\Factory\TicketFactory;
use Application\Model\Collection\TicketCollection;
use Application\Model\Exception\TicketException;
use Application\Model\Bean\Bean;
use Application\Query\TicketQuery;
use Query\Query;

/**
 *
 * TicketCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Ticket getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketCatalog extends BaseTicketCatalog{

    /**
     * Metodo para agregar un Ticket a la base de datos
     * @param Ticket $ticket Objeto Ticket
     */
    public function create($ticket)
    {
        $this->validateBean($ticket);
        try
        {
            if( !$ticket->getIdBaseTicket() ){
              parent::create($ticket);
            }

            $data = $ticket->toArrayFor(
                array('id_category', 'id_base_ticket', 'id_employee', 'id_company', 'id_priority', 'id_impact', 'email',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Ticket::TABLENAME, $data);
            $ticket->setIdTicket($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Ticket can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Ticket en la base de datos
     * @param Ticket $ticket Objeto Ticket
     */
    public function update($ticket)
    {
        $this->validateBean($ticket);
        try
        {
            $data = $ticket->toArrayFor(
                array('id_category', 'id_base_ticket', 'id_employee', 'id_company', 'id_priority', 'id_impact', 'email',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Ticket::TABLENAME, $data, "id_ticket = '{$ticket->getIdTicket()}'");
            parent::update($ticket);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Ticket can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Ticket a partir de su Id
     * @param int $idTicket
     */
    public function deleteById($idTicket)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket = ?', $idTicket));
            $this->getDb()->delete(Ticket::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Ticket can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketCollection
     */
    protected function makeCollection(){
        return new TicketCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Ticket
     */
    protected function makeBean($resultset){
        return TicketFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Ticket
     * @param Ticket $ticket
     * @throws Exception
     */
    protected function validateBean($ticket = null){
        if( !($ticket instanceof Ticket) ){
            $this->throwException("passed parameter isn't a Ticket instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketException($message);
        }
    }

 }