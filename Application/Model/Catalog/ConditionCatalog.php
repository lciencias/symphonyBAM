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
use Application\Model\Bean\Condition;
use Application\Model\Factory\ConditionFactory;
use Application\Model\Collection\ConditionCollection;
use Application\Model\Exception\ConditionException;
use Application\Model\Bean\Bean;
use Application\Query\ConditionQuery;
use Query\Query;

/**
 *
 * ConditionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Condition getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ConditionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ConditionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Condition a la base de datos
     * @param Condition $condition Objeto Condition
     */
    public function create($condition)
    {
        $this->validateBean($condition);
        try
        {
            $data = $condition->toArrayFor(
                array('id_element', 'name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Condition::TABLENAME, $data);
            $condition->setIdAutomataCondition($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Condition can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Condition en la base de datos
     * @param Condition $condition Objeto Condition
     */
    public function update($condition)
    {
        $this->validateBean($condition);
        try
        {
            $data = $condition->toArrayFor(
                array('id_element', 'name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Condition::TABLENAME, $data, "id_automata_condition = '{$condition->getIdAutomataCondition()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Condition can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Condition a partir de su Id
     * @param int $idAutomataCondition
     */
    public function deleteById($idAutomataCondition)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_automata_condition = ?', $idAutomataCondition));
            $this->getDb()->delete(Condition::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Condition can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ConditionCollection
     */
    protected function makeCollection(){
        return new ConditionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Condition
     */
    protected function makeBean($resultset){
        return ConditionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ConditionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ConditionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Condition
     * @param Condition $condition
     * @throws Exception
     */
    protected function validateBean($condition = null){
        if( !($condition instanceof Condition) ){
            $this->throwException("passed parameter isn't a Condition instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ConditionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ConditionException($message);
        }
    }

 }