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
use Application\Model\Bean\Employee;
use Application\Model\Factory\EmployeeFactory;
use Application\Model\Collection\EmployeeCollection;
use Application\Model\Exception\EmployeeException;
use Application\Model\Bean\Bean;
use Application\Query\EmployeeQuery;
use Query\Query;

/**
 *
 * EmployeeCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Employee getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EmployeeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EmployeeCatalog extends PersonCatalog{

    /**
     * Metodo para agregar un Employee a la base de datos
     * @param Employee $employee Objeto Employee
     */
    public function create($employee)
    {
        $this->validateBean($employee);
        try
        {
            if( !$employee->getIdPerson() ){
              parent::create($employee);
            }

            $data = $employee->toArrayFor(
                array('id_person', 'id_area', 'id_location', 'id_position', 'status_employee', 'is_vip', 'id_company', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Employee::TABLENAME, $data);
            $employee->setIdEmployee($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Employee can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Employee en la base de datos
     * @param Employee $employee Objeto Employee
     */
    public function update($employee)
    {
        $this->validateBean($employee);
        try
        {
            $data = $employee->toArrayFor(
                array('id_person', 'id_area', 'id_location', 'id_position', 'status_employee', 'is_vip', 'id_company', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            parent::update($employee);
            $this->getDb()->update(Employee::TABLENAME, $data, "id_employee = '{$employee->getIdEmployee()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Employee can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Employee a partir de su Id
     * @param int $idEmployee
     */
    public function deleteById($idEmployee)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_employee = ?', $idEmployee));
            $this->getDb()->delete(Employee::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Employee can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EmployeeCollection
     */
    protected function makeCollection(){
        return new EmployeeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Employee
     */
    protected function makeBean($resultset){
        return EmployeeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EmployeeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EmployeeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Employee
     * @param Employee $employee
     * @throws Exception
     */
    protected function validateBean($employee = null){
        if( !($employee instanceof Employee) ){
            $this->throwException("passed parameter isn't a Employee instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EmployeeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EmployeeException($message);
        }
    }

 }