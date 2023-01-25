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
use Application\Model\Bean\ServiceLevel;
use Application\Model\Factory\ServiceLevelFactory;
use Application\Model\Collection\ServiceLevelCollection;
use Application\Model\Exception\ServiceLevelException;
use Application\Model\Bean\Bean;
use Application\Query\ServiceLevelQuery;
use Query\Query;

/**
 *
 * ServiceLevelCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ServiceLevel getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ServiceLevelCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ServiceLevelCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ServiceLevel a la base de datos
     * @param ServiceLevel $serviceLevel Objeto ServiceLevel
     */
    public function create($serviceLevel)
    {
        $this->validateBean($serviceLevel);
        try
        {
            $data = $serviceLevel->toArrayFor(
                array('name', 'resolution_time', 'response_time', 'note', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ServiceLevel::TABLENAME, $data);
            $serviceLevel->setIdServiceLevel($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevel can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ServiceLevel en la base de datos
     * @param ServiceLevel $serviceLevel Objeto ServiceLevel
     */
    public function update($serviceLevel)
    {
        $this->validateBean($serviceLevel);
        try
        {
            $data = $serviceLevel->toArrayFor(
                array('name', 'resolution_time', 'response_time', 'note', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ServiceLevel::TABLENAME, $data, "id_service_level = '{$serviceLevel->getIdServiceLevel()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevel can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ServiceLevel a partir de su Id
     * @param int $idServiceLevel
     */
    public function deleteById($idServiceLevel)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_service_level = ?', $idServiceLevel));
            $this->getDb()->delete(ServiceLevel::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ServiceLevel can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ServiceLevelCollection
     */
    protected function makeCollection(){
        return new ServiceLevelCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ServiceLevel
     */
    protected function makeBean($resultset){
        return ServiceLevelFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ServiceLevelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ServiceLevelQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ServiceLevel
     * @param ServiceLevel $serviceLevel
     * @throws Exception
     */
    protected function validateBean($serviceLevel = null){
        if( !($serviceLevel instanceof ServiceLevel) ){
            $this->throwException("passed parameter isn't a ServiceLevel instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ServiceLevelException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ServiceLevelException($message);
        }
    }

 }