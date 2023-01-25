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
use Application\Model\Bean\State;
use Application\Model\Factory\StateFactory;
use Application\Model\Collection\StateCollection;
use Application\Model\Exception\StateException;
use Application\Model\Bean\Bean;
use Application\Query\StateQuery;
use Query\Query;

/**
 *
 * StateCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\State getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\StateCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class StateCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un State a la base de datos
     * @param State $state Objeto State
     */
    public function create($state)
    {
        $this->validateBean($state);
        try
        {
            $data = $state->toArrayFor(
                array('id_element', 'id_state_type', 'name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(State::TABLENAME, $data);
            $state->setIdAutomataState($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The State can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un State en la base de datos
     * @param State $state Objeto State
     */
    public function update($state)
    {
        $this->validateBean($state);
        try
        {
            $data = $state->toArrayFor(
                array('id_element', 'id_state_type', 'name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(State::TABLENAME, $data, "id_automata_state = '{$state->getIdAutomataState()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The State can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un State a partir de su Id
     * @param int $idAutomataState
     */
    public function deleteById($idAutomataState)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_automata_state = ?', $idAutomataState));
            $this->getDb()->delete(State::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The State can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\StateCollection
     */
    protected function makeCollection(){
        return new StateCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\State
     */
    protected function makeBean($resultset){
        return StateFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param StateQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof StateQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate State
     * @param State $state
     * @throws Exception
     */
    protected function validateBean($state = null){
        if( !($state instanceof State) ){
            $this->throwException("passed parameter isn't a State instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new StateException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new StateException($message);
        }
    }

 }