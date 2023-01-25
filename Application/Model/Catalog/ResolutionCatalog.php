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
use Application\Model\Bean\Resolution;
use Application\Model\Factory\ResolutionFactory;
use Application\Model\Collection\ResolutionCollection;
use Application\Model\Exception\ResolutionException;
use Application\Model\Bean\Bean;
use Application\Query\ResolutionQuery;
use Query\Query;

/**
 *
 * ResolutionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Resolution getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ResolutionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ResolutionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Resolution a la base de datos
     * @param Resolution $resolution Objeto Resolution
     */
    public function create($resolution)
    {
        $this->validateBean($resolution);
        try
        {
            $data = $resolution->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Resolution::TABLENAME, $data);
            $resolution->setIdResolution($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Resolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Resolution en la base de datos
     * @param Resolution $resolution Objeto Resolution
     */
    public function update($resolution)
    {
        $this->validateBean($resolution);
        try
        {
            $data = $resolution->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Resolution::TABLENAME, $data, "id_resolution = '{$resolution->getIdResolution()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Resolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Resolution a partir de su Id
     * @param int $idResolution
     */
    public function deleteById($idResolution)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_resolution = ?', $idResolution));
            $this->getDb()->delete(Resolution::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Resolution can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ResolutionCollection
     */
    protected function makeCollection(){
        return new ResolutionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Resolution
     */
    protected function makeBean($resultset){
        return ResolutionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ResolutionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ResolutionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Resolution
     * @param Resolution $resolution
     * @throws Exception
     */
    protected function validateBean($resolution = null){
        if( !($resolution instanceof Resolution) ){
            $this->throwException("passed parameter isn't a Resolution instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ResolutionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ResolutionException($message);
        }
    }

 }