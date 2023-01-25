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
use Application\Model\Bean\PriorityLog;
use Application\Model\Factory\PriorityLogFactory;
use Application\Model\Collection\PriorityLogCollection;
use Application\Model\Exception\PriorityLogException;
use Application\Model\Bean\Bean;
use Application\Query\PriorityLogQuery;
use Query\Query;

/**
 *
 * PriorityLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PriorityLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PriorityLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PriorityLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un PriorityLog a la base de datos
     * @param PriorityLog $priorityLog Objeto PriorityLog
     */
    public function create($priorityLog)
    {
        $this->validateBean($priorityLog);
        try
        {
            $data = $priorityLog->toArrayFor(
                array('id_priority', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(PriorityLog::TABLENAME, $data);
            $priorityLog->setIdPriorityLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The PriorityLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un PriorityLog en la base de datos
     * @param PriorityLog $priorityLog Objeto PriorityLog
     */
    public function update($priorityLog)
    {
        $this->validateBean($priorityLog);
        try
        {
            $data = $priorityLog->toArrayFor(
                array('id_priority', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(PriorityLog::TABLENAME, $data, "id_priority_log = '{$priorityLog->getIdPriorityLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The PriorityLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un PriorityLog a partir de su Id
     * @param int $idPriorityLog
     */
    public function deleteById($idPriorityLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_priority_log = ?', $idPriorityLog));
            $this->getDb()->delete(PriorityLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The PriorityLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PriorityLogCollection
     */
    protected function makeCollection(){
        return new PriorityLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\PriorityLog
     */
    protected function makeBean($resultset){
        return PriorityLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PriorityLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PriorityLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate PriorityLog
     * @param PriorityLog $priorityLog
     * @throws Exception
     */
    protected function validateBean($priorityLog = null){
        if( !($priorityLog instanceof PriorityLog) ){
            $this->throwException("passed parameter isn't a PriorityLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PriorityLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PriorityLogException($message);
        }
    }

 }