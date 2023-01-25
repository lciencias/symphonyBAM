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
use Application\Model\Bean\Machine;
use Application\Model\Factory\MachineFactory;
use Application\Model\Collection\MachineCollection;
use Application\Model\Exception\MachineException;
use Application\Model\Bean\Bean;
use Application\Query\MachineQuery;
use Query\Query;

/**
 *
 * MachineCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Machine getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\MachineCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class MachineCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Machine a la base de datos
     * @param Machine $machine Objeto Machine
     */
    public function create($machine)
    {
        $this->validateBean($machine);
        try
        {
            $data = $machine->toArrayFor(
                array('id_element', 'id_automata_condition', 'id_automata_state', 'next_state', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Machine::TABLENAME, $data);
            $machine->setIdMachineTransition($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Machine can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Machine en la base de datos
     * @param Machine $machine Objeto Machine
     */
    public function update($machine)
    {
        $this->validateBean($machine);
        try
        {
            $data = $machine->toArrayFor(
                array('id_element', 'id_automata_condition', 'id_automata_state', 'next_state', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Machine::TABLENAME, $data, "id_machine_transition = '{$machine->getIdMachineTransition()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Machine can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Machine a partir de su Id
     * @param int $idMachineTransition
     */
    public function deleteById($idMachineTransition)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_machine_transition = ?', $idMachineTransition));
            $this->getDb()->delete(Machine::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Machine can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\MachineCollection
     */
    protected function makeCollection(){
        return new MachineCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Machine
     */
    protected function makeBean($resultset){
        return MachineFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param MachineQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof MachineQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Machine
     * @param Machine $machine
     * @throws Exception
     */
    protected function validateBean($machine = null){
        if( !($machine instanceof Machine) ){
            $this->throwException("passed parameter isn't a Machine instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new MachineException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new MachineException($message);
        }
    }

 }