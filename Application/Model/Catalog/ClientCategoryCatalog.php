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
use Application\Model\Bean\ClientCategory;
use Application\Model\Factory\ClientCategoryFactory;
use Application\Model\Collection\ClientCategoryCollection;
use Application\Model\Exception\ClientCategoryException;
use Application\Model\Bean\Bean;
use Application\Query\ClientCategoryQuery;
use Query\Query;

/**
 *
 * ClientCategoryCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategory getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ClientCategoryCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ClientCategoryCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ClientCategory a la base de datos
     * @param ClientCategory $clientCategory Objeto ClientCategory
     */
    public function create($clientCategory)
    {
        $this->validateBean($clientCategory);
        try
        {
            $data = $clientCategory->toArrayFor(
                array('id_ticket_type', 'id_group', 'id_escalation', 'id_service_level', 'name', 'id_parent', 'status', 'is_leaf', 'note','partialities', 'financial_movement', 'type', 'movments','product','motive','chanel', )
            );
            
            
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ClientCategory::TABLENAME, $data);
            $clientCategory->setIdClientCategory($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategory can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ClientCategory en la base de datos
     * @param ClientCategory $clientCategory Objeto ClientCategory
     */
    public function update($clientCategory)
    {
        $this->validateBean($clientCategory);
        try
        {
            $data = $clientCategory->toArrayFor(
                array('id_ticket_type', 'id_group', 'id_escalation', 'id_service_level', 'name', 'id_parent', 'status', 'is_leaf', 'note','partialities', 'financial_movement', 'type', 'movments', 'product','motive','chanel',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ClientCategory::TABLENAME, $data, "id_client_category = '{$clientCategory->getIdClientCategory()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategory can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ClientCategory a partir de su Id
     * @param int $idClientCategory
     */
    public function deleteById($idClientCategory)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_client_category = ?', $idClientCategory));
            $this->getDb()->delete(ClientCategory::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ClientCategory can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ClientCategoryCollection
     */
    protected function makeCollection(){
        return new ClientCategoryCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ClientCategory
     */
    protected function makeBean($resultset){
        return ClientCategoryFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ClientCategoryQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ClientCategoryQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ClientCategory
     * @param ClientCategory $clientCategory
     * @throws Exception
     */
    protected function validateBean($clientCategory = null){
        if( !($clientCategory instanceof ClientCategory) ){
            $this->throwException("passed parameter isn't a ClientCategory instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ClientCategoryException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ClientCategoryException($message);
        }
    }

 }