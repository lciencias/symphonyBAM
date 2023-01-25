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
use Application\Model\Bean\FieldLog;
use Application\Model\Factory\FieldLogFactory;
use Application\Model\Collection\FieldLogCollection;
use Application\Model\Exception\FieldLogException;
use Application\Model\Bean\Bean;
use Application\Query\FieldLogQuery;
use Query\Query;

/**
 *
 * FieldLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\FieldLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\FieldLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class FieldLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un FieldLog a la base de datos
     * @param FieldLog $fieldLog Objeto FieldLog
     */
    public function create($fieldLog)
    {
        $this->validateBean($fieldLog);
        try
        {
            $data = $fieldLog->toArrayFor(
                array('id_field', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(FieldLog::TABLENAME, $data);
            $fieldLog->setIdFieldLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The FieldLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un FieldLog en la base de datos
     * @param FieldLog $fieldLog Objeto FieldLog
     */
    public function update($fieldLog)
    {
        $this->validateBean($fieldLog);
        try
        {
            $data = $fieldLog->toArrayFor(
                array('id_field', 'id_user', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(FieldLog::TABLENAME, $data, "id_field_log = '{$fieldLog->getIdFieldLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The FieldLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un FieldLog a partir de su Id
     * @param int $idFieldLog
     */
    public function deleteById($idFieldLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_field_log = ?', $idFieldLog));
            $this->getDb()->delete(FieldLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The FieldLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\FieldLogCollection
     */
    protected function makeCollection(){
        return new FieldLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\FieldLog
     */
    protected function makeBean($resultset){
        return FieldLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param FieldLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof FieldLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate FieldLog
     * @param FieldLog $fieldLog
     * @throws Exception
     */
    protected function validateBean($fieldLog = null){
        if( !($fieldLog instanceof FieldLog) ){
            $this->throwException("passed parameter isn't a FieldLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new FieldLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new FieldLogException($message);
        }
    }

 }