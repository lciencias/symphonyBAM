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
use Application\Model\Bean\EmployeeLog;
use Application\Model\Factory\EmployeeLogFactory;
use Application\Model\Collection\EmployeeLogCollection;
use Application\Model\Exception\EmployeeLogException;
use Application\Model\Bean\Bean;
use Application\Query\EmployeeLogQuery;
use Query\Query;

/**
 *
 * EmployeeLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EmployeeLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EmployeeLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EmployeeLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un EmployeeLog a la base de datos
     * @param EmployeeLog $employeeLog Objeto EmployeeLog
     */
    public function create($employeeLog)
    {
        $this->validateBean($employeeLog);
        try
        {
            $data = $employeeLog->toArrayFor(
                array('id_employee', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(EmployeeLog::TABLENAME, $data);
            $employeeLog->setIdEmployeeLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The EmployeeLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un EmployeeLog en la base de datos
     * @param EmployeeLog $employeeLog Objeto EmployeeLog
     */
    public function update($employeeLog)
    {
        $this->validateBean($employeeLog);
        try
        {
            $data = $employeeLog->toArrayFor(
                array('id_employee', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(EmployeeLog::TABLENAME, $data, "id_employee_log = '{$employeeLog->getIdEmployeeLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The EmployeeLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un EmployeeLog a partir de su Id
     * @param int $idEmployeeLog
     */
    public function deleteById($idEmployeeLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_employee_log = ?', $idEmployeeLog));
            $this->getDb()->delete(EmployeeLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The EmployeeLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EmployeeLogCollection
     */
    protected function makeCollection(){
        return new EmployeeLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\EmployeeLog
     */
    protected function makeBean($resultset){
        return EmployeeLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EmployeeLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EmployeeLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate EmployeeLog
     * @param EmployeeLog $employeeLog
     * @throws Exception
     */
    protected function validateBean($employeeLog = null){
        if( !($employeeLog instanceof EmployeeLog) ){
            $this->throwException("passed parameter isn't a EmployeeLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EmployeeLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EmployeeLogException($message);
        }
    }

 }