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
use Application\Model\Bean\TicketTypeLog;
use Application\Model\Factory\TicketTypeLogFactory;
use Application\Model\Collection\TicketTypeLogCollection;
use Application\Model\Exception\TicketTypeLogException;
use Application\Model\Bean\Bean;
use Application\Query\TicketTypeLogQuery;
use Query\Query;

/**
 *
 * TicketTypeLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketTypeLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketTypeLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketTypeLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TicketTypeLog a la base de datos
     * @param TicketTypeLog $ticketTypeLog Objeto TicketTypeLog
     */
    public function create($ticketTypeLog)
    {
        $this->validateBean($ticketTypeLog);
        try
        {
            $data = $ticketTypeLog->toArrayFor(
                array('id_ticket_type', 'id_user', 'date_log', 'event_log', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TicketTypeLog::TABLENAME, $data);
            $ticketTypeLog->setIdTicketTypeLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketTypeLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketTypeLog en la base de datos
     * @param TicketTypeLog $ticketTypeLog Objeto TicketTypeLog
     */
    public function update($ticketTypeLog)
    {
        $this->validateBean($ticketTypeLog);
        try
        {
            $data = $ticketTypeLog->toArrayFor(
                array('id_ticket_type', 'id_user', 'date_log', 'event_log', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketTypeLog::TABLENAME, $data, "id_ticket_type_log = '{$ticketTypeLog->getIdTicketTypeLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketTypeLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketTypeLog a partir de su Id
     * @param int $idTicketTypeLog
     */
    public function deleteById($idTicketTypeLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_type_log = ?', $idTicketTypeLog));
            $this->getDb()->delete(TicketTypeLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketTypeLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketTypeLogCollection
     */
    protected function makeCollection(){
        return new TicketTypeLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketTypeLog
     */
    protected function makeBean($resultset){
        return TicketTypeLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketTypeLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketTypeLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketTypeLog
     * @param TicketTypeLog $ticketTypeLog
     * @throws Exception
     */
    protected function validateBean($ticketTypeLog = null){
        if( !($ticketTypeLog instanceof TicketTypeLog) ){
            $this->throwException("passed parameter isn't a TicketTypeLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketTypeLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketTypeLogException($message);
        }
    }

 }