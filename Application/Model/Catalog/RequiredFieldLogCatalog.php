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
use Application\Model\Bean\RequiredFieldLog;
use Application\Model\Factory\RequiredFieldLogFactory;
use Application\Model\Collection\RequiredFieldLogCollection;
use Application\Model\Exception\RequiredFieldLogException;
use Application\Model\Bean\Bean;
use Application\Query\RequiredFieldLogQuery;
use Query\Query;

/**
 *
 * RequiredFieldLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\RequiredFieldLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\RequiredFieldLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class RequiredFieldLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un RequiredFieldLog a la base de datos
     * @param RequiredFieldLog $requiredFieldLog Objeto RequiredFieldLog
     */
    public function create($requiredFieldLog)
    {
        $this->validateBean($requiredFieldLog);
        try
        {
            $data = $requiredFieldLog->toArrayFor(
                array('id_user', 'id_required_field', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(RequiredFieldLog::TABLENAME, $data);
            $requiredFieldLog->setIdRequiredFieldLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredFieldLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un RequiredFieldLog en la base de datos
     * @param RequiredFieldLog $requiredFieldLog Objeto RequiredFieldLog
     */
    public function update($requiredFieldLog)
    {
        $this->validateBean($requiredFieldLog);
        try
        {
            $data = $requiredFieldLog->toArrayFor(
                array('id_user', 'id_required_field', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(RequiredFieldLog::TABLENAME, $data, "id_required_field_log = '{$requiredFieldLog->getIdRequiredFieldLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredFieldLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un RequiredFieldLog a partir de su Id
     * @param int $idRequiredFieldLog
     */
    public function deleteById($idRequiredFieldLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_required_field_log = ?', $idRequiredFieldLog));
            $this->getDb()->delete(RequiredFieldLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredFieldLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\RequiredFieldLogCollection
     */
    protected function makeCollection(){
        return new RequiredFieldLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\RequiredFieldLog
     */
    protected function makeBean($resultset){
        return RequiredFieldLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param RequiredFieldLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof RequiredFieldLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate RequiredFieldLog
     * @param RequiredFieldLog $requiredFieldLog
     * @throws Exception
     */
    protected function validateBean($requiredFieldLog = null){
        if( !($requiredFieldLog instanceof RequiredFieldLog) ){
            $this->throwException("passed parameter isn't a RequiredFieldLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new RequiredFieldLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new RequiredFieldLogException($message);
        }
    }

 }