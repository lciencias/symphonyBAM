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
use Application\Model\Bean\Reasons;
use Application\Model\Factory\ReasonsFactory;
use Application\Model\Collection\ReasonsCollection;
use Application\Model\Exception\ReasonsException;
use Application\Model\Bean\Bean;
use Application\Query\ReasonsQuery;
use Query\Query;

/**
 *
 * ReasonsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Reasons getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ReasonsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ReasonsCatalog extends AbstractCatalog {



    /**
     *
     * Validate Query
     * @param ReasonsQuery $query
     * @throws RoundException
     */
//    protected function validateQuery(Query $query)
//    {
//        if( !($query instanceof ReasonsQuery) ){
//            $this->throwException("No es un Query valido");
//        }
//    }
//    
//    /**
//     * @return \Application\Model\Metadata\ReasonsMetadata
//     */
//    protected static function getMetadata(){
//        return \Application\Model\Metadata\ReasonsMetadata::getInstance();
//    }
    /**
     * Metodo para agregar un Channel a la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function create($reason)
    {
        $this->validateBean($reason);
        try
        {
            $data = $reason->toArrayFor(
                array('name', 'status','partialities', 'financial_movement', 'type', 'subtype', 'movments',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Reasons::TABLENAME, $data);
            $reason->setIdReason($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Reason can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Channel en la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function update($reason)
    {
        $this->validateBean($reason);
        try
        {
            $data = $reason->toArrayFor(
                array('name', 'status','partialities', 'financial_movement', 'type', 'subtype', 'movments',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Reasons::TABLENAME, $data, "id_reason = '{$reason->getIdReason()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Reason can't be saved \n", $e);
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
            $where = array($this->getDb()->quoteInto('id_reason = ?', $idReason));
            $this->getDb()->delete(Reasons::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Reason can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ChannelCollection
     */
    protected function makeCollection(){
        return new ReasonsCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
        return ReasonsFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ReasonsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Channel
     * @param Channel $channel
     * @throws Exception
     */
    protected function validateBean($reason = null){
        if( !($reason instanceof Reasons) ){
            $this->throwException("passed parameter isn't a Reason instance");
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