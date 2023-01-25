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
use Application\Model\Bean\ClientResolutionLog;
use Application\Model\Factory\ClientResolutionLogFactory;
use Application\Model\Collection\ClientResolutionLogCollection;
use Application\Model\Exception\ClientResolutionLogException;
use Application\Model\Bean\Bean;
use Application\Query\ClientResolutionLogQuery;
use Query\Query;

/**
 *
 * ClientResolutionLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientResolutionLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientResolutionLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientResolutionLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientResolutionLog a la base de datos
     * @param ClientResolutionLog $clientResolutionLog Objeto ClientResolutionLog
     */
    public function create($clientResolutionLog)
    {
        $this->validateBean($clientResolutionLog);
        try
        {
            $data = $clientResolutionLog->toArrayFor(
                array('id_client_resolution', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ClientResolutionLog::TABLENAME, $data);
            $clientResolutionLog->setIdClientResolutionLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolutionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ClientResolutionLog en la base de datos
     * @param ClientResolutionLog $clientResolutionLog Objeto ClientResolutionLog
     */
    public function update($clientResolutionLog)
    {
        $this->validateBean($clientResolutionLog);
        try
        {
            $data = $clientResolutionLog->toArrayFor(
                array('id_client_resolution', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ClientResolutionLog::TABLENAME, $data, "id_client_resolution_log = '{$clientResolutionLog->getIdClientResolutionLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolutionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ClientResolutionLog a partir de su Id
     * @param int $idClientResolutionLog
     */
    public function deleteById($idClientResolutionLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_client_resolution_log = ?', $idClientResolutionLog));
            $this->getDb()->delete(ClientResolutionLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolutionLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientResolutionLogCollection
     */
    protected function makeCollection(){
        return new ClientResolutionLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientResolutionLog
     */
    protected function makeBean($resultset){
        return ClientResolutionLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientResolutionLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientResolutionLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientResolutionLog
     * @param ClientResolutionLog $clientResolutionLog
     * @throws Exception
     */
    protected function validateBean($clientResolutionLog = null){
        if( !($clientResolutionLog instanceof ClientResolutionLog) ){
            $this->throwException("passed parameter isn't a ClientResolutionLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientResolutionLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientResolutionLogException($message);
        }
    }

 }