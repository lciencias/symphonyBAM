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
use Application\Model\Bean\ClientCategoryLog;
use Application\Model\Factory\ClientCategoryLogFactory;
use Application\Model\Collection\ClientCategoryLogCollection;
use Application\Model\Exception\ClientCategoryLogException;
use Application\Model\Bean\Bean;
use Application\Query\ClientCategoryLogQuery;
use Query\Query;

/**
 *
 * ClientCategoryLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategoryLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientCategoryLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientCategoryLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientCategoryLog a la base de datos
     * @param ClientCategoryLog $clientCategoryLog Objeto ClientCategoryLog
     */
    public function create($clientCategoryLog)
    {
        $this->validateBean($clientCategoryLog);
        try
        {
            $data = $clientCategoryLog->toArrayFor(
                array('id_user', 'id_client_category', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ClientCategoryLog::TABLENAME, $data);
            $clientCategoryLog->setIdCategoryLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ClientCategoryLog en la base de datos
     * @param ClientCategoryLog $clientCategoryLog Objeto ClientCategoryLog
     */
    public function update($clientCategoryLog)
    {
        $this->validateBean($clientCategoryLog);
        try
        {
            $data = $clientCategoryLog->toArrayFor(
                array('id_user', 'id_client_category', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ClientCategoryLog::TABLENAME, $data, "id_category_log = '{$clientCategoryLog->getIdCategoryLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ClientCategoryLog a partir de su Id
     * @param int $idCategoryLog
     */
    public function deleteById($idCategoryLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_category_log = ?', $idCategoryLog));
            $this->getDb()->delete(ClientCategoryLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientCategoryLogCollection
     */
    protected function makeCollection(){
        return new ClientCategoryLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    protected function makeBean($resultset){
        return ClientCategoryLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientCategoryLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientCategoryLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientCategoryLog
     * @param ClientCategoryLog $clientCategoryLog
     * @throws Exception
     */
    protected function validateBean($clientCategoryLog = null){
        if( !($clientCategoryLog instanceof ClientCategoryLog) ){
            $this->throwException("passed parameter isn't a ClientCategoryLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientCategoryLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientCategoryLogException($message);
        }
    }

 }