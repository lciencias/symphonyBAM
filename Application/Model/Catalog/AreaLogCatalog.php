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
use Application\Model\Bean\AreaLog;
use Application\Model\Factory\AreaLogFactory;
use Application\Model\Collection\AreaLogCollection;
use Application\Model\Exception\AreaLogException;
use Application\Model\Bean\Bean;
use Application\Query\AreaLogQuery;
use Query\Query;

/**
 *
 * AreaLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AreaLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AreaLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AreaLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un AreaLog a la base de datos
     * @param AreaLog $areaLog Objeto AreaLog
     */
    public function create($areaLog)
    {
        $this->validateBean($areaLog);
        try
        {
            $data = $areaLog->toArrayFor(
                array('id_user', 'id_area', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(AreaLog::TABLENAME, $data);
            $areaLog->setIdAreaLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The AreaLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un AreaLog en la base de datos
     * @param AreaLog $areaLog Objeto AreaLog
     */
    public function update($areaLog)
    {
        $this->validateBean($areaLog);
        try
        {
            $data = $areaLog->toArrayFor(
                array('id_user', 'id_area', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(AreaLog::TABLENAME, $data, "id_area_log = '{$areaLog->getIdAreaLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The AreaLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un AreaLog a partir de su Id
     * @param int $idAreaLog
     */
    public function deleteById($idAreaLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_area_log = ?', $idAreaLog));
            $this->getDb()->delete(AreaLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The AreaLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AreaLogCollection
     */
    protected function makeCollection(){
        return new AreaLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\AreaLog
     */
    protected function makeBean($resultset){
        return AreaLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AreaLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AreaLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate AreaLog
     * @param AreaLog $areaLog
     * @throws Exception
     */
    protected function validateBean($areaLog = null){
        if( !($areaLog instanceof AreaLog) ){
            $this->throwException("passed parameter isn't a AreaLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AreaLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AreaLogException($message);
        }
    }

 }