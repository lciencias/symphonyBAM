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
use Application\Model\Bean\Priority;
use Application\Model\Factory\PriorityFactory;
use Application\Model\Collection\PriorityCollection;
use Application\Model\Exception\PriorityException;
use Application\Model\Bean\Bean;
use Application\Query\PriorityQuery;
use Query\Query;

/**
 *
 * PriorityCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Priority getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PriorityCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PriorityCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Priority a la base de datos
     * @param Priority $priority Objeto Priority
     */
    public function create($priority)
    {
        $this->validateBean($priority);
        try
        {
            $data = $priority->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Priority::TABLENAME, $data);
            $priority->setIdPriority($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Priority can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Priority en la base de datos
     * @param Priority $priority Objeto Priority
     */
    public function update($priority)
    {
        $this->validateBean($priority);
        try
        {
            $data = $priority->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Priority::TABLENAME, $data, "id_priority = '{$priority->getIdPriority()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Priority can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Priority a partir de su Id
     * @param int $idPriority
     */
    public function deleteById($idPriority)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_priority = ?', $idPriority));
            $this->getDb()->delete(Priority::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Priority can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PriorityCollection
     */
    protected function makeCollection(){
        return new PriorityCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Priority
     */
    protected function makeBean($resultset){
        return PriorityFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PriorityQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PriorityQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Priority
     * @param Priority $priority
     * @throws Exception
     */
    protected function validateBean($priority = null){
        if( !($priority instanceof Priority) ){
            $this->throwException("passed parameter isn't a Priority instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PriorityException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PriorityException($message);
        }
    }

 }