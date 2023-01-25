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
use Application\Model\Bean\ClientData;
use Application\Model\Factory\ClientDataFactory;
use Application\Model\Collection\ClientDataCollection;
use Application\Model\Exception\ClientDataException;
use Application\Model\Bean\Bean;
use Application\Query\ClientDataQuery;
use Query\Query;

/**
 *
 * ClientDataCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientData getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientDataCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientDataCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientData a la base de datos
     * @param ClientData $clientData Objeto ClientData
     */
    public function create($clientData)
    {
    	 
    	$this->throwException("The ClientData can't be saved \n");

    }

    /**
     * Metodo para actualizar un ClientData en la base de datos
     * @param ClientData $clientData Objeto ClientData
     */
    public function update($clientData)
    {

    	$this->throwException("The ClientData can't be saved \n");

    }

    /**
     * Metodo para eliminar un ClientData a partir de su Id
     * @param int $
     */
    public function deleteById($id)
    {

    	$this->throwException("The ClientData can't be deleted\n");

    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientDataCollection
     */
    protected function makeCollection(){
        return new ClientDataCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientData
     */
    protected function makeBean($resultset){
        return ClientDataFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientDataQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientDataQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientData
     * @param ClientData $clientData
     * @throws Exception
     */
    protected function validateBean($clientData = null){
        if( !($clientData instanceof ClientData) ){
            $this->throwException("passed parameter isn't a ClientData instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientDataException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientDataException($message);
        }
    }

 }