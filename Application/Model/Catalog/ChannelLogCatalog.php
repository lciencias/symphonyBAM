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
use Application\Model\Bean\ChannelLog;
use Application\Model\Factory\ChannelLogFactory;
use Application\Model\Collection\ChannelLogCollection;
use Application\Model\Exception\ChannelLogException;
use Application\Model\Bean\Bean;
use Application\Query\ChannelLogQuery;
use Query\Query;

/**
 *
 * ChannelLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ChannelLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ChannelLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ChannelLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ChannelLog a la base de datos
     * @param ChannelLog $channelLog Objeto ChannelLog
     */
    public function create($channelLog)
    {
        $this->validateBean($channelLog);
        try
        {
            $data = $channelLog->toArrayFor(
                array('id_channel', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ChannelLog::TABLENAME, $data);
            $channelLog->setIdChannelsLogs($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ChannelLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ChannelLog en la base de datos
     * @param ChannelLog $channelLog Objeto ChannelLog
     */
    public function update($channelLog)
    {
        $this->validateBean($channelLog);
        try
        {
            $data = $channelLog->toArrayFor(
                array('id_channel', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ChannelLog::TABLENAME, $data, "id_channels_logs = '{$channelLog->getIdChannelsLogs()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ChannelLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ChannelLog a partir de su Id
     * @param int $idChannelsLogs
     */
    public function deleteById($idChannelsLogs)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_channels_logs = ?', $idChannelsLogs));
            $this->getDb()->delete(ChannelLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ChannelLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ChannelLogCollection
     */
    protected function makeCollection(){
        return new ChannelLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function makeBean($resultset){
        return ChannelLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ChannelLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ChannelLog
     * @param ChannelLog $channelLog
     * @throws Exception
     */
    protected function validateBean($channelLog = null){
        if( !($channelLog instanceof ChannelLog) ){
            $this->throwException("passed parameter isn't a ChannelLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ChannelLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ChannelLogException($message);
        }
    }

 }