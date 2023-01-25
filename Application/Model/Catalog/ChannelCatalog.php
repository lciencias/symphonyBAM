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
use Application\Model\Bean\Channel;
use Application\Model\Factory\ChannelFactory;
use Application\Model\Collection\ChannelCollection;
use Application\Model\Exception\ChannelException;
use Application\Model\Bean\Bean;
use Application\Query\ChannelQuery;
use Query\Query;

/**
 *
 * ChannelCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Channel getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ChannelCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ChannelCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Channel a la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function create($channel)
    {
        $this->validateBean($channel);
        try
        {
            $data = $channel->toArrayFor(
                array('name', 'status', 'canal_acl', 'canal_recl', 'reopen', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Channel::TABLENAME, $data);
            $channel->setIdChannel($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Channel can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Channel en la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function update($channel)
    {
        $this->validateBean($channel);
        try
        {
            $data = $channel->toArrayFor(
                array('name', 'status', 'canal_acl', 'canal_recl', 'reopen', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Channel::TABLENAME, $data, "id_channel = '{$channel->getIdChannel()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Channel can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Channel a partir de su Id
     * @param int $idChannel
     */
    public function deleteById($idChannel)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_channel = ?', $idChannel));
            $this->getDb()->delete(Channel::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Channel can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ChannelCollection
     */
    protected function makeCollection(){
        return new ChannelCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
        return ChannelFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ChannelQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Channel
     * @param Channel $channel
     * @throws Exception
     */
    protected function validateBean($channel = null){
        if( !($channel instanceof Channel) ){
            $this->throwException("passed parameter isn't a Channel instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ChannelException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ChannelException($message);
        }
    }

 }