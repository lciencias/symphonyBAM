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
use Application\Model\Bean\LocationLog;
use Application\Model\Factory\LocationLogFactory;
use Application\Model\Collection\LocationLogCollection;
use Application\Model\Exception\LocationLogException;
use Application\Model\Bean\Bean;
use Application\Query\LocationLogQuery;
use Query\Query;

/**
 *
 * LocationLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\LocationLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\LocationLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class LocationLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un LocationLog a la base de datos
     * @param LocationLog $locationLog Objeto LocationLog
     */
    public function create($locationLog)
    {
        $this->validateBean($locationLog);
        try
        {
            $data = $locationLog->toArrayFor(
                array('id_location', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(LocationLog::TABLENAME, $data);
            $locationLog->setIdLocationLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The LocationLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un LocationLog en la base de datos
     * @param LocationLog $locationLog Objeto LocationLog
     */
    public function update($locationLog)
    {
        $this->validateBean($locationLog);
        try
        {
            $data = $locationLog->toArrayFor(
                array('id_location', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(LocationLog::TABLENAME, $data, "id_location_log = '{$locationLog->getIdLocationLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The LocationLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un LocationLog a partir de su Id
     * @param int $idLocationLog
     */
    public function deleteById($idLocationLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_location_log = ?', $idLocationLog));
            $this->getDb()->delete(LocationLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The LocationLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\LocationLogCollection
     */
    protected function makeCollection(){
        return new LocationLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\LocationLog
     */
    protected function makeBean($resultset){
        return LocationLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param LocationLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof LocationLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate LocationLog
     * @param LocationLog $locationLog
     * @throws Exception
     */
    protected function validateBean($locationLog = null){
        if( !($locationLog instanceof LocationLog) ){
            $this->throwException("passed parameter isn't a LocationLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new LocationLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new LocationLogException($message);
        }
    }

 }