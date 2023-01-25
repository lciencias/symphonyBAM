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
use Application\Model\Bean\PositionLog;
use Application\Model\Factory\PositionLogFactory;
use Application\Model\Collection\PositionLogCollection;
use Application\Model\Exception\PositionLogException;
use Application\Model\Bean\Bean;
use Application\Query\PositionLogQuery;
use Query\Query;

/**
 *
 * PositionLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PositionLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PositionLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PositionLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un PositionLog a la base de datos
     * @param PositionLog $positionLog Objeto PositionLog
     */
    public function create($positionLog)
    {
        $this->validateBean($positionLog);
        try
        {
            $data = $positionLog->toArrayFor(
                array('id_user', 'id_position', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(PositionLog::TABLENAME, $data);
            $positionLog->setIdPositionLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The PositionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un PositionLog en la base de datos
     * @param PositionLog $positionLog Objeto PositionLog
     */
    public function update($positionLog)
    {
        $this->validateBean($positionLog);
        try
        {
            $data = $positionLog->toArrayFor(
                array('id_user', 'id_position', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(PositionLog::TABLENAME, $data, "id_position_log = '{$positionLog->getIdPositionLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The PositionLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un PositionLog a partir de su Id
     * @param int $idPositionLog
     */
    public function deleteById($idPositionLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_position_log = ?', $idPositionLog));
            $this->getDb()->delete(PositionLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The PositionLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PositionLogCollection
     */
    protected function makeCollection(){
        return new PositionLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\PositionLog
     */
    protected function makeBean($resultset){
        return PositionLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PositionLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PositionLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate PositionLog
     * @param PositionLog $positionLog
     * @throws Exception
     */
    protected function validateBean($positionLog = null){
        if( !($positionLog instanceof PositionLog) ){
            $this->throwException("passed parameter isn't a PositionLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PositionLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PositionLogException($message);
        }
    }

 }