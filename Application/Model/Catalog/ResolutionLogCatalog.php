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
use Application\Model\Bean\ResolutionLog;
use Application\Model\Factory\ResolutionLogFactory;
use Application\Model\Collection\ResolutionLogCollection;
use Application\Model\Exception\ResolutionLogException;
use Application\Model\Bean\Bean;
use Application\Query\ResolutionLogQuery;
use Query\Query;

/**
 *
 * ResolutionLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ResolutionLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ResolutionLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ResolutionLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ResolutionLog a la base de datos
     * @param ResolutionLog $resolutionLog Objeto ResolutionLog
     */
    public function create($resolutionLog)
    {
        $this->validateBean($resolutionLog);
        try
        {
            $data = $resolutionLog->toArrayFor(
                array('id_resolution', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ResolutionLog::TABLENAME, $data);
            $resolutionLog->setIdResolutionLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ResolutionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ResolutionLog en la base de datos
     * @param ResolutionLog $resolutionLog Objeto ResolutionLog
     */
    public function update($resolutionLog)
    {
        $this->validateBean($resolutionLog);
        try
        {
            $data = $resolutionLog->toArrayFor(
                array('id_resolution', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ResolutionLog::TABLENAME, $data, "id_resolution_log = '{$resolutionLog->getIdResolutionLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ResolutionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ResolutionLog a partir de su Id
     * @param int $idResolutionLog
     */
    public function deleteById($idResolutionLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_resolution_log = ?', $idResolutionLog));
            $this->getDb()->delete(ResolutionLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ResolutionLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ResolutionLogCollection
     */
    protected function makeCollection(){
        return new ResolutionLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ResolutionLog
     */
    protected function makeBean($resultset){
        return ResolutionLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ResolutionLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ResolutionLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ResolutionLog
     * @param ResolutionLog $resolutionLog
     * @throws Exception
     */
    protected function validateBean($resolutionLog = null){
        if( !($resolutionLog instanceof ResolutionLog) ){
            $this->throwException("passed parameter isn't a ResolutionLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ResolutionLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ResolutionLogException($message);
        }
    }

 }