<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\ClientCategoryResolution;
use Application\Model\Factory\ClientCategoryResolutionFactory;
use Application\Model\Collection\ClientCategoryResolutionCollection;
use Application\Model\Exception\ClientCategoryResolutionException;
use Application\Model\Bean\Bean;
use Application\Query\ClientCategoryResolutionQuery;
use Query\Query;

/**
 *
 * ClientCategoryResolutionCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategoryResolution getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientCategoryResolutionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientCategoryResolution a la base de datos
     * @param ClientCategoryResolution $clientCategoryResolution Objeto ClientCategoryResolution
     */
    public function create($clientCategoryResolution)
    {
        $this->validateBean($clientCategoryResolution);
        try
        {
            $data = $clientCategoryResolution->toArrayFor(
                array('id_client_resolution', 'id_client_category', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ClientCategoryResolution::TABLENAME, $data);
            $clientCategoryResolution->setIdClientCategoryResolution($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryResolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ClientCategoryResolution en la base de datos
     * @param ClientCategoryResolution $clientCategoryResolution Objeto ClientCategoryResolution
     */
    public function update($clientCategoryResolution)
    {
        $this->validateBean($clientCategoryResolution);
        try
        {
            $data = $clientCategoryResolution->toArrayFor(
                array('id_client_resolution', 'id_client_category', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ClientCategoryResolution::TABLENAME, $data, "id_client_category_resolution = '{$clientCategoryResolution->getIdClientCategoryResolution()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryResolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ClientCategoryResolution a partir de su Id
     * @param int $idClientCategoryResolution
     */
    public function deleteById($idClientCategoryResolution)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_client_category_resolution = ?', $idClientCategoryResolution));
            $this->getDb()->delete(ClientCategoryResolution::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategoryResolution can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientCategoryResolutionCollection
     */
    protected function makeCollection(){
        return new ClientCategoryResolutionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientCategoryResolution
     */
    protected function makeBean($resultset){
        return ClientCategoryResolutionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientCategoryResolutionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientCategoryResolutionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientCategoryResolution
     * @param ClientCategoryResolution $clientCategoryResolution
     * @throws Exception
     */
    protected function validateBean($clientCategoryResolution = null){
        if( !($clientCategoryResolution instanceof ClientCategoryResolution) ){
            $this->throwException("passed parameter isn't a ClientCategoryResolution instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientCategoryResolutionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientCategoryResolutionException($message);
        }
    }

 }