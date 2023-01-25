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
use Application\Model\Bean\ClientAccount;
use Application\Model\Factory\ClientAccountFactory;
use Application\Model\Collection\ClientAccountCollection;
use Application\Model\Exception\ClientAccountException;
use Application\Model\Bean\Bean;
use Application\Query\ClientAccountQuery;
use Query\Query;

/**
 *
 * ClientAccountCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientAccount getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientAccountCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientAccountCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientAccount a la base de datos
     * @param ClientAccount $clientAccount Objeto ClientAccount
     */
    public function create($clientAccount)
    {
        
            $this->throwException("The ClientAccount can't be saved \n");
        
    }

    /**
     * Metodo para actualizar un ClientAccount en la base de datos
     * @param ClientAccount $clientAccount Objeto ClientAccount
     */
    public function update($clientAccount)
    {
       
            $this->throwException("The ClientAccount can't be saved \n");
       
    }

    /**
     * Metodo para eliminar un ClientAccount a partir de su Id
     * @param int $
     */
    public function deleteById($id)
    {
       
            $this->throwException("The ClientAccount can't be deleted\n");
       
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientAccountCollection
     */
    protected function makeCollection(){
        return new ClientAccountCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientAccount
     */
    protected function makeBean($resultset){
        return ClientAccountFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientAccountQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientAccountQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientAccount
     * @param ClientAccount $clientAccount
     * @throws Exception
     */
    protected function validateBean($clientAccount = null){
        if( !($clientAccount instanceof ClientAccount) ){
            $this->throwException("passed parameter isn't a ClientAccount instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientAccountException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientAccountException($message);
        }
    }

 }