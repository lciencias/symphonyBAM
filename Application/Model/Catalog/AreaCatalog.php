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
use Application\Model\Bean\Area;
use Application\Model\Factory\AreaFactory;
use Application\Model\Collection\AreaCollection;
use Application\Model\Exception\AreaException;
use Application\Model\Bean\Bean;
use Application\Query\AreaQuery;
use Query\Query;

/**
 *
 * AreaCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Area getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AreaCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AreaCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Area a la base de datos
     * @param Area $area Objeto Area
     */
    public function create($area)
    {
        $this->validateBean($area);
        try
        {
            $data = $area->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Area::TABLENAME, $data);
            $area->setIdArea($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Area can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Area en la base de datos
     * @param Area $area Objeto Area
     */
    public function update($area)
    {
        $this->validateBean($area);
        try
        {
            $data = $area->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Area::TABLENAME, $data, "id_area = '{$area->getIdArea()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Area can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Area a partir de su Id
     * @param int $idArea
     */
    public function deleteById($idArea)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_area = ?', $idArea));
            $this->getDb()->delete(Area::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Area can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AreaCollection
     */
    protected function makeCollection(){
        return new AreaCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Area
     */
    protected function makeBean($resultset){
        return AreaFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AreaQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AreaQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Area
     * @param Area $area
     * @throws Exception
     */
    protected function validateBean($area = null){
        if( !($area instanceof Area) ){
            $this->throwException("passed parameter isn't a Area instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AreaException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AreaException($message);
        }
    }

 }