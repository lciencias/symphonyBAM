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
use Application\Model\Bean\ImpactLog;
use Application\Model\Factory\ImpactLogFactory;
use Application\Model\Collection\ImpactLogCollection;
use Application\Model\Exception\ImpactLogException;
use Application\Model\Bean\Bean;
use Application\Query\ImpactLogQuery;
use Query\Query;

/**
 *
 * ImpactLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ImpactLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ImpactLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ImpactLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ImpactLog a la base de datos
     * @param ImpactLog $impactLog Objeto ImpactLog
     */
    public function create($impactLog)
    {
        $this->validateBean($impactLog);
        try
        {
            $data = $impactLog->toArrayFor(
                array('id_impact', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ImpactLog::TABLENAME, $data);
            $impactLog->setIdImpactLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ImpactLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ImpactLog en la base de datos
     * @param ImpactLog $impactLog Objeto ImpactLog
     */
    public function update($impactLog)
    {
        $this->validateBean($impactLog);
        try
        {
            $data = $impactLog->toArrayFor(
                array('id_impact', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ImpactLog::TABLENAME, $data, "id_impact_log = '{$impactLog->getIdImpactLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ImpactLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ImpactLog a partir de su Id
     * @param int $idImpactLog
     */
    public function deleteById($idImpactLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_impact_log = ?', $idImpactLog));
            $this->getDb()->delete(ImpactLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ImpactLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ImpactLogCollection
     */
    protected function makeCollection(){
        return new ImpactLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ImpactLog
     */
    protected function makeBean($resultset){
        return ImpactLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ImpactLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ImpactLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ImpactLog
     * @param ImpactLog $impactLog
     * @throws Exception
     */
    protected function validateBean($impactLog = null){
        if( !($impactLog instanceof ImpactLog) ){
            $this->throwException("passed parameter isn't a ImpactLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ImpactLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ImpactLogException($message);
        }
    }

 }