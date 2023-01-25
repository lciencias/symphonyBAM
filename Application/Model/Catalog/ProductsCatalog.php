<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\Products;
use Application\Model\Factory\ProductsFactory;
use Application\Model\Collection\ProductsCollection;
use Application\Model\Exception\ProductsException;
use Application\Model\Bean\Bean;
use Application\Query\ProductsQuery;
use Query\Query;

/**
 *
 * ProductsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Products getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ProductsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ProductsCatalog extends AbstractCatalog {



    /**
     *
     * Validate Query
     * @param ProductsQuery $query
     * @throws RoundException
     */
//    protected function validateQuery(Query $query)
//    {
//        if( !($query instanceof ProductsQuery) ){
//            $this->throwException("No es un Query valido");
//        }
//    }
//    
//    /**
//     * @return \Application\Model\Metadata\ProductsMetadata
//     */
//    protected static function getMetadata(){
//        return \Application\Model\Metadata\ProductsMetadata::getInstance();
//    }
    
    public function create($product)
    {
        $this->validateBean($product);
        try
        {
            $data = $product->toArrayFor(
                array('name', 'status', 'id_product_bam', 'description', 'requirements', 'commissions','status','especial')
            );
            
            
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Products::TABLENAME, $data);
            $product->setIdProduct($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Product can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Channel en la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function update($product)
    {
        $this->validateBean($product);
        try
        {
            $data = $product->toArrayFor(
                 array('name', 'status', 'id_product_bam', 'description', 'requirements', 'commissions','status','especial')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Products::TABLENAME, $data, "id_product = '{$product->getIdProduct()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Product can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Channel a partir de su Id
     * @param int $idChannel
     */
    public function deleteById($idReason)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_product = ?', $idReason));
            $this->getDb()->delete(Products::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Product can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ChannelCollection
     */
    protected function makeCollection(){
        return new ProductsCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
        return ProductsFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ProductsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Channel
     * @param Channel $channel
     * @throws Exception
     */
    protected function validateBean($product = null){
        if( !($product instanceof Products) ){
            $this->throwException("passed parameter isn't a Product instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ReasonsException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ReasonsException($message);
        }
    }


 }