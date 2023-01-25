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
use Application\Model\Bean\Assignment;
use Application\Model\Factory\AssignmentFactory;
use Application\Model\Collection\AssignmentCollection;
use Application\Model\Exception\AssignmentException;
use Application\Model\Bean\Bean;
use Application\Query\AssignmentQuery;
use Query\Query;

/**
 *
 * AssignmentCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Assignment getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AssignmentCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AssignmentCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Assignment a la base de datos
     * @param Assignment $assignment Objeto Assignment
     */
    public function create($assignment)
    {
        $this->validateBean($assignment);
        try
        {
            $data = $assignment->toArrayFor(
                array('id_base_ticket', 'id_user', 'id_resolution', 'assignment_date', 'resolution_date', 'note', 'id_file','recovery_amount', 'is_recovered_amount','id_resolution_file','status')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Assignment::TABLENAME, $data);
            $assignment->setIdAssignment($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Assignment can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Assignment en la base de datos
     * @param Assignment $assignment Objeto Assignment
     */
    public function update($assignment)
    {
        $this->validateBean($assignment);
        try
        {
            $data = $assignment->toArrayFor(
                array('id_base_ticket', 'id_user', 'id_resolution', 'assignment_date', 'resolution_date', 'note', 'id_file','recovery_amount', 'is_recovered_amount','id_resolution_file','status')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Assignment::TABLENAME, $data, "id_assignment = '{$assignment->getIdAssignment()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Assignment can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Assignment a partir de su Id
     * @param int $idAssignment
     */
    public function deleteById($idAssignment)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_assignment = ?', $idAssignment));
            $this->getDb()->delete(Assignment::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Assignment can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AssignmentCollection
     */
    protected function makeCollection(){
        return new AssignmentCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Assignment
     */
    protected function makeBean($resultset){
        return AssignmentFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AssignmentQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AssignmentQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Assignment
     * @param Assignment $assignment
     * @throws Exception
     */
    protected function validateBean($assignment = null){
        if( !($assignment instanceof Assignment) ){
            $this->throwException("passed parameter isn't a Assignment instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AssignmentException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AssignmentException($message);
        }
    }

 }