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
use Application\Model\Bean\BaseTicket;
use Application\Model\Factory\BaseTicketFactory;
use Application\Model\Collection\BaseTicketCollection;
use Application\Model\Exception\BaseTicketException;
use Application\Model\Bean\Bean;
use Application\Query\BaseTicketQuery;
use Query\Query;

/**
 *
 * BaseTicketCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\BaseTicket getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\BaseTicketCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class BaseTicketCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un BaseTicket a la base de datos
     * @param BaseTicket $baseTicket Objeto BaseTicket
     */
    public function create($baseTicket)
    {
        $this->validateBean($baseTicket);
        try
        {
            $data = $baseTicket->toArrayFor(
                array('id_channel', 'id_ticket_type', 'id_user', 'id_assignment', 'status', 'description', 'created', 'scheduled_date', 'is_stopped', 'type','registry', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(BaseTicket::TABLENAME, $data);
            $baseTicket->setIdBaseTicket($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The BaseTicket can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un BaseTicket en la base de datos
     * @param BaseTicket $baseTicket Objeto BaseTicket
     */
    public function update($baseTicket)
    {
        $this->validateBean($baseTicket);
        try
        {
            $data = $baseTicket->toArrayFor(
                array('id_channel', 'id_ticket_type', 'id_user', 'id_assignment', 'status', 'description', 'created', 'scheduled_date', 'is_stopped', 'type','registry', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(BaseTicket::TABLENAME, $data, "id_base_ticket = '{$baseTicket->getIdBaseTicket()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The BaseTicket can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un BaseTicket a partir de su Id
     * @param int $idBaseTicket
     */
    public function deleteById($idBaseTicket)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_base_ticket = ?', $idBaseTicket));
            $this->getDb()->delete(BaseTicket::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The BaseTicket can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\BaseTicketCollection
     */
    protected function makeCollection(){
        return new BaseTicketCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\BaseTicket
     */
    protected function makeBean($resultset){
        return BaseTicketFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param BaseTicketQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof BaseTicketQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate BaseTicket
     * @param BaseTicket $baseTicket
     * @throws Exception
     */
    protected function validateBean($baseTicket = null){
        if( !($baseTicket instanceof BaseTicket) ){
            $this->throwException("passed parameter isn't a BaseTicket instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new BaseTicketException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new BaseTicketException($message);
        }
    }

 }