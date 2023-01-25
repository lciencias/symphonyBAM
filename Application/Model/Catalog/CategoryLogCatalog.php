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
use Application\Model\Bean\CategoryLog;
use Application\Model\Factory\CategoryLogFactory;
use Application\Model\Collection\CategoryLogCollection;
use Application\Model\Exception\CategoryLogException;
use Application\Model\Bean\Bean;
use Application\Query\CategoryLogQuery;
use Query\Query;

/**
 *
 * CategoryLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\CategoryLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CategoryLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CategoryLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un CategoryLog a la base de datos
     * @param CategoryLog $categoryLog Objeto CategoryLog
     */
    public function create($categoryLog)
    {
        $this->validateBean($categoryLog);
        try
        {
            $data = $categoryLog->toArrayFor(
                array('id_category', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(CategoryLog::TABLENAME, $data);
            $categoryLog->setIdCategoryLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The CategoryLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un CategoryLog en la base de datos
     * @param CategoryLog $categoryLog Objeto CategoryLog
     */
    public function update($categoryLog)
    {
        $this->validateBean($categoryLog);
        try
        {
            $data = $categoryLog->toArrayFor(
                array('id_category', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(CategoryLog::TABLENAME, $data, "id_category_log = '{$categoryLog->getIdCategoryLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The CategoryLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un CategoryLog a partir de su Id
     * @param int $idCategoryLog
     */
    public function deleteById($idCategoryLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_category_log = ?', $idCategoryLog));
            $this->getDb()->delete(CategoryLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The CategoryLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CategoryLogCollection
     */
    protected function makeCollection(){
        return new CategoryLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\CategoryLog
     */
    protected function makeBean($resultset){
        return CategoryLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CategoryLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CategoryLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate CategoryLog
     * @param CategoryLog $categoryLog
     * @throws Exception
     */
    protected function validateBean($categoryLog = null){
        if( !($categoryLog instanceof CategoryLog) ){
            $this->throwException("passed parameter isn't a CategoryLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CategoryLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CategoryLogException($message);
        }
    }

 }