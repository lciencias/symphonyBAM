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
use Application\Model\Bean\ClientResolution;
use Application\Model\Factory\ClientResolutionFactory;
use Application\Model\Collection\ClientResolutionCollection;
use Application\Model\Exception\ClientResolutionException;
use Application\Model\Bean\Bean;
use Application\Query\ClientResolutionQuery;
use Query\Query;

/**
 *
 * ClientResolutionCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientResolution getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientResolutionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientResolutionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientResolution a la base de datos
     * @param ClientResolution $clientResolution Objeto ClientResolution
     */
    public function create($clientResolution)
    {
        $this->validateBean($clientResolution);
        try
        {
            $data = $clientResolution->toArrayFor(
                array('name', 'type', 'status', 'code', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ClientResolution::TABLENAME, $data);
            $clientResolution->setIdClientResolution($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ClientResolution en la base de datos
     * @param ClientResolution $clientResolution Objeto ClientResolution
     */
    public function update($clientResolution)
    {
        $this->validateBean($clientResolution);
        try
        {
            $data = $clientResolution->toArrayFor(
                array('name', 'type', 'status', 'code',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ClientResolution::TABLENAME, $data, "id_client_resolution = '{$clientResolution->getIdClientResolution()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolution can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ClientResolution a partir de su Id
     * @param int $idClientResolution
     */
    public function deleteById($idClientResolution)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_client_resolution = ?', $idClientResolution));
            $this->getDb()->delete(ClientResolution::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientResolution can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientResolutionCollection
     */
    protected function makeCollection(){
        return new ClientResolutionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientResolution
     */
    protected function makeBean($resultset){
        return ClientResolutionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientResolutionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientResolutionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientResolution
     * @param ClientResolution $clientResolution
     * @throws Exception
     */
    protected function validateBean($clientResolution = null){
        if( !($clientResolution instanceof ClientResolution) ){
            $this->throwException("passed parameter isn't a ClientResolution instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientResolutionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientResolutionException($message);
        }
    }

 }