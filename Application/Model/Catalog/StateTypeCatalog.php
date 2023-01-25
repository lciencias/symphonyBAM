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
use Application\Model\Bean\StateType;
use Application\Model\Factory\StateTypeFactory;
use Application\Model\Collection\StateTypeCollection;
use Application\Model\Exception\StateTypeException;
use Application\Model\Bean\Bean;
use Application\Query\StateTypeQuery;
use Query\Query;

/**
 *
 * StateTypeCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\StateType getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\StateTypeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class StateTypeCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un StateType a la base de datos
     * @param StateType $stateType Objeto StateType
     */
    public function create($stateType)
    {
        $this->validateBean($stateType);
        try
        {
            $data = $stateType->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(StateType::TABLENAME, $data);
            $stateType->setIdStateType($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The StateType can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un StateType en la base de datos
     * @param StateType $stateType Objeto StateType
     */
    public function update($stateType)
    {
        $this->validateBean($stateType);
        try
        {
            $data = $stateType->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(StateType::TABLENAME, $data, "id_state_type = '{$stateType->getIdStateType()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The StateType can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un StateType a partir de su Id
     * @param int $idStateType
     */
    public function deleteById($idStateType)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_state_type = ?', $idStateType));
            $this->getDb()->delete(StateType::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The StateType can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\StateTypeCollection
     */
    protected function makeCollection(){
        return new StateTypeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\StateType
     */
    protected function makeBean($resultset){
        return StateTypeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param StateTypeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof StateTypeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate StateType
     * @param StateType $stateType
     * @throws Exception
     */
    protected function validateBean($stateType = null){
        if( !($stateType instanceof StateType) ){
            $this->throwException("passed parameter isn't a StateType instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new StateTypeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new StateTypeException($message);
        }
    }

 }