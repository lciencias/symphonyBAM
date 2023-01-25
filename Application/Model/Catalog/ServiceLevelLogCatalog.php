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
use Application\Model\Bean\ServiceLevelLog;
use Application\Model\Factory\ServiceLevelLogFactory;
use Application\Model\Collection\ServiceLevelLogCollection;
use Application\Model\Exception\ServiceLevelLogException;
use Application\Model\Bean\Bean;
use Application\Query\ServiceLevelLogQuery;
use Query\Query;

/**
 *
 * ServiceLevelLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ServiceLevelLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ServiceLevelLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ServiceLevelLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ServiceLevelLog a la base de datos
     * @param ServiceLevelLog $serviceLevelLog Objeto ServiceLevelLog
     */
    public function create($serviceLevelLog)
    {
        $this->validateBean($serviceLevelLog);
        try
        {
            $data = $serviceLevelLog->toArrayFor(
                array('id_service_level', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ServiceLevelLog::TABLENAME, $data);
            $serviceLevelLog->setIdServiceLevelLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevelLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ServiceLevelLog en la base de datos
     * @param ServiceLevelLog $serviceLevelLog Objeto ServiceLevelLog
     */
    public function update($serviceLevelLog)
    {
        $this->validateBean($serviceLevelLog);
        try
        {
            $data = $serviceLevelLog->toArrayFor(
                array('id_service_level', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ServiceLevelLog::TABLENAME, $data, "id_service_level_log = '{$serviceLevelLog->getIdServiceLevelLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevelLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ServiceLevelLog a partir de su Id
     * @param int $idServiceLevelLog
     */
    public function deleteById($idServiceLevelLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_service_level_log = ?', $idServiceLevelLog));
            $this->getDb()->delete(ServiceLevelLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevelLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ServiceLevelLogCollection
     */
    protected function makeCollection(){
        return new ServiceLevelLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    protected function makeBean($resultset){
        return ServiceLevelLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ServiceLevelLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ServiceLevelLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ServiceLevelLog
     * @param ServiceLevelLog $serviceLevelLog
     * @throws Exception
     */
    protected function validateBean($serviceLevelLog = null){
        if( !($serviceLevelLog instanceof ServiceLevelLog) ){
            $this->throwException("passed parameter isn't a ServiceLevelLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ServiceLevelLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ServiceLevelLogException($message);
        }
    }

 }