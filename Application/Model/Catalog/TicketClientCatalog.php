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
use Application\Model\Bean\TicketClient;
use Application\Model\Factory\TicketClientFactory;
use Application\Model\Collection\TicketClientCollection;
use Application\Model\Exception\TicketClientException;
use Application\Model\Bean\Bean;
use Application\Query\TicketClientQuery;
use Query\Query;

/**
 *
 * TicketClientCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\TicketClient getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TicketClientCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TicketClientCatalog extends BaseTicketCatalog{

    /**
     * Metodo para agregar un TicketClient a la base de datos
     * @param TicketClient $ticketClient Objeto TicketClient
     */
    public function create($ticketClient)
    {
        $this->validateBean($ticketClient);
        try
        {
            if( !$ticketClient->getIdBaseTicket() ){
              parent::create($ticketClient);
            }

            $data = $ticketClient->toArrayFor(
                array('id_reported_branch', 'id_client_category', 'id_base_ticket', 'id_origin_branch', 'folio', 'account_number', 'id_product',  'email', 'folio_prev', 'client_number', 'id_user_last_assign', 'state_client', 'name_client', 'no_card', 'employee', 'card_type','expiration_date','chanel','folio_condusef','id_resolver','account_type', 'telefono', 'id_entidad', 'complaint',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TicketClient::TABLENAME, $data);
            $ticketClient->setIdTicketClient($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClient can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TicketClient en la base de datos
     * @param TicketClient $ticketClient Objeto TicketClient
     */
    public function update($ticketClient)
    {
        $this->validateBean($ticketClient);
        try
        {
            $data = $ticketClient->toArrayFor(
                array('id_reported_branch', 'id_client_category', 'id_base_ticket', 'id_origin_branch', 'folio', 'account_number', 'id_product',  'email', 'folio_prev', 'client_number', 'id_user_last_assign','state_client', 'name_client', 'no_card', 'employee', 'card_type','expiration_date','chanel','folio_condusef','id_resolver','account_type', 'telefono', 'id_entidad',  'complaint',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TicketClient::TABLENAME, $data, "id_ticket_client = '{$ticketClient->getIdTicketClient()}'");
            parent::update($ticketClient);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClient can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TicketClient a partir de su Id
     * @param int $idTicketClient
     */
    public function deleteById($idTicketClient)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_ticket_client = ?', $idTicketClient));
            $this->getDb()->delete(TicketClient::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TicketClient can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TicketClientCollection
     */
    protected function makeCollection(){
        return new TicketClientCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TicketClient
     */
    protected function makeBean($resultset){
        return TicketClientFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TicketClientQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TicketClientQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TicketClient
     * @param TicketClient $ticketClient
     * @throws Exception
     */
    protected function validateBean($ticketClient = null){
        if( !($ticketClient instanceof TicketClient) ){
            $this->throwException("passed parameter isn't a TicketClient instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TicketClientException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TicketClientException($message);
        }
    }

 }