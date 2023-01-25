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
use Application\Model\Bean\Prod;
use Application\Model\Factory\ProdFactory;
use Application\Model\Collection\ProdCollection;
use Application\Model\Exception\ProdException;
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
class ProdCatalog extends AbstractCatalog {

    
    public function create($product)
    {
        $this->validateBean($product);
        try
        {
            $data = $product->toArrayFor(
                array('name', 'no_tarjeta')
            );
            
            
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Prod::TABLENAME, $data);
            $product->setIdBam($this->getDb()->lastInsertId());
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
                 array('name', 'no_tarjeta')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Prod::TABLENAME, $data, "id_bam= '{$product->getIdBam()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Product can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un prod a partir de su Id
     * @param int $idProd
     */
    public function deleteById($idProd)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_bam = ?', $idProd));
            $this->getDb()->delete(Prod::TABLENAME, $where);
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
        return new ProdCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
        return ProdFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ProdQuery) ){
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
        if( !($product instanceof Prod) ){
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
            throw new ProdException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ProdException($message);
        }
    }


 }