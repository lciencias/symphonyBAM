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
use Application\Model\Bean\Workweek;
use Application\Model\Factory\WorkweekFactory;
use Application\Model\Collection\WorkweekCollection;
use Application\Model\Exception\WorkweekException;
use Application\Model\Bean\Bean;
use Application\Query\WorkweekQuery;
use Query\Query;

/**
 *
 * WorkweekCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Workweek getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\WorkweekCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class WorkweekCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Workweek a la base de datos
     * @param Workweek $workweek Objeto Workweek
     */
    public function create($workweek)
    {
        $this->validateBean($workweek);
        try
        {
            $data = $workweek->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Workweek::TABLENAME, $data);
            $workweek->setIdWorkweek($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workweek can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Workweek en la base de datos
     * @param Workweek $workweek Objeto Workweek
     */
    public function update($workweek)
    {
        $this->validateBean($workweek);
        try
        {
            $data = $workweek->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Workweek::TABLENAME, $data, "id_workweek = '{$workweek->getIdWorkweek()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workweek can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Workweek a partir de su Id
     * @param int $idWorkweek
     */
    public function deleteById($idWorkweek)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_workweek = ?', $idWorkweek));
            $this->getDb()->delete(Workweek::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Workweek can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\WorkweekCollection
     */
    protected function makeCollection(){
        return new WorkweekCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Workweek
     */
    protected function makeBean($resultset){
        return WorkweekFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param WorkweekQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof WorkweekQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Workweek
     * @param Workweek $workweek
     * @throws Exception
     */
    protected function validateBean($workweek = null){
        if( !($workweek instanceof Workweek) ){
            $this->throwException("passed parameter isn't a Workweek instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new WorkweekException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new WorkweekException($message);
        }
    }

 }