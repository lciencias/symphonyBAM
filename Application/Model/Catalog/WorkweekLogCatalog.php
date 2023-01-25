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
use Application\Model\Bean\WorkweekLog;
use Application\Model\Factory\WorkweekLogFactory;
use Application\Model\Collection\WorkweekLogCollection;
use Application\Model\Exception\WorkweekLogException;
use Application\Model\Bean\Bean;
use Application\Query\WorkweekLogQuery;
use Query\Query;

/**
 *
 * WorkweekLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\WorkweekLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\WorkweekLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class WorkweekLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un WorkweekLog a la base de datos
     * @param WorkweekLog $workweekLog Objeto WorkweekLog
     */
    public function create($workweekLog)
    {
        $this->validateBean($workweekLog);
        try
        {
            $data = $workweekLog->toArrayFor(
                array('id_workweek', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(WorkweekLog::TABLENAME, $data);
            $workweekLog->setIdWorkweekLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The WorkweekLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un WorkweekLog en la base de datos
     * @param WorkweekLog $workweekLog Objeto WorkweekLog
     */
    public function update($workweekLog)
    {
        $this->validateBean($workweekLog);
        try
        {
            $data = $workweekLog->toArrayFor(
                array('id_workweek', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(WorkweekLog::TABLENAME, $data, "id_workweek_log = '{$workweekLog->getIdWorkweekLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The WorkweekLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un WorkweekLog a partir de su Id
     * @param int $idWorkweekLog
     */
    public function deleteById($idWorkweekLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_workweek_log = ?', $idWorkweekLog));
            $this->getDb()->delete(WorkweekLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The WorkweekLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\WorkweekLogCollection
     */
    protected function makeCollection(){
        return new WorkweekLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\WorkweekLog
     */
    protected function makeBean($resultset){
        return WorkweekLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param WorkweekLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof WorkweekLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate WorkweekLog
     * @param WorkweekLog $workweekLog
     * @throws Exception
     */
    protected function validateBean($workweekLog = null){
        if( !($workweekLog instanceof WorkweekLog) ){
            $this->throwException("passed parameter isn't a WorkweekLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new WorkweekLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new WorkweekLogException($message);
        }
    }

 }