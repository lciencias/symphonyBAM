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
use Application\Model\Bean\TicketLog;
use Application\Model\Factory\TicketLogFactory;
use Application\Model\Collection\TicketLogCollection;
use Application\Model\Exception\TicketLogException;
use Application\Model\Bean\Bean;
use Application\Query\TicketLogQuery;
use Query\Query;

/**
 *
 * TicketLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TicketLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketLogCatalog extends AbstractCatalog
{

    /**
     *
     * @param TicketLog $ticketLog
     */
    public function save($ticketLog)
    {
        $this->validateBean($ticketLog);
        if( $ticketLog->getIdTicketLog()){
            $this->update($ticketLog);
        }else{
            $this->create($ticketLog);
        }
    }

    /**
     * Metodo para agregar un TicketLog a la base de datos
     * @param TicketLog $ticketLog Objeto TicketLog
     */
    public function create($ticketLog)
    {
        $this->validateBean($ticketLog);
        try
        {
            $data = $ticketLog->toArrayFor(
                array('id_base_ticket', 'id_user', 'date_log', 'event_type', 'changed_from', 'changed_to', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
//             echo '<pre>';
//             print_r($data);
//             die;
            $this->getDb()->insert(TicketLog::TABLENAME, $data);
            $ticketLog->setIdTicketLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketLog en la base de datos
     * @param TicketLog $ticketLog Objeto TicketLog
     */
    public function update($ticketLog)
    {
        $this->validateBean($ticketLog);
        try
        {
            $data = $ticketLog->toArrayFor(
                array('id_base_ticket', 'id_user', 'date_log', 'event_type', 'changed_from', 'changed_to', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketLog::TABLENAME, $data, "id_ticket_log = '{$ticketLog->getIdTicketLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketLog a partir de su Id
     * @param int $idTicketLog
     */
    public function deleteById($idTicketLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_log = ?', $idTicketLog));
            $this->getDb()->delete(TicketLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketLogCollection
     */
    protected function makeCollection(){
        return new TicketLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketLog
     */
    protected function makeBean($resultset){
        return TicketLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketLog
     * @param TicketLog $ticketLog
     * @throws Exception
     */
    protected function validateBean($ticketLog = null){
        if( !($ticketLog instanceof TicketLog) ){
            $this->throwException("passed parameter isn't a TicketLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketLogException($message);
        }
    }

 }