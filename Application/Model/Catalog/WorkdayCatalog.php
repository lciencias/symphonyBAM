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
use Application\Model\Bean\Workday;
use Application\Model\Factory\WorkdayFactory;
use Application\Model\Collection\WorkdayCollection;
use Application\Model\Exception\WorkdayException;
use Application\Model\Bean\Bean;
use Application\Query\WorkdayQuery;
use Query\Query;

/**
 *
 * WorkdayCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Workday getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\WorkdayCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class WorkdayCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Workday a la base de datos
     * @param Workday $workday Objeto Workday
     */
    public function create($workday)
    {
        $this->validateBean($workday);
        try
        {
            $data = $workday->toArrayFor(
                array('id_workweek', 'day_of_week', 'start_time', 'lunch_start_time', 'lunch_end_time', 'end_time', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Workday::TABLENAME, $data);
            $workday->setIdWorkday($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workday can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Workday en la base de datos
     * @param Workday $workday Objeto Workday
     */
    public function update($workday)
    {
        $this->validateBean($workday);
        try
        {
            $data = $workday->toArrayFor(
                array('id_workweek', 'day_of_week', 'start_time', 'lunch_start_time', 'lunch_end_time', 'end_time', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Workday::TABLENAME, $data, "id_workday = '{$workday->getIdWorkday()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workday can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Workday a partir de su Id
     * @param int $idWorkday
     */
    public function deleteById($idWorkday)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_workday = ?', $idWorkday));
            $this->getDb()->delete(Workday::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workday can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar un Workday a partir de su Id
     * @param int $idWorkday
     */
    public function deleteByIdWorkweek($idWorkweek, $day = null)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_workweek = ?', $idWorkweek));
            if( null != $day ){
                $where = array($this->getDb()->quoteInto('day_of_week = ?', $day));
            }
            $this->getDb()->delete(Workday::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workday can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\WorkdayCollection
     */
    protected function makeCollection(){
        return new WorkdayCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Workday
     */
    protected function makeBean($resultset){
        return WorkdayFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param WorkdayQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof WorkdayQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Workday
     * @param Workday $workday
     * @throws Exception
     */
    protected function validateBean($workday = null){
        if( !($workday instanceof Workday) ){
            $this->throwException("passed parameter isn't a Workday instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new WorkdayException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new WorkdayException($message);
        }
    }

 }