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
use Application\Model\Bean\GroupLog;
use Application\Model\Factory\GroupLogFactory;
use Application\Model\Collection\GroupLogCollection;
use Application\Model\Exception\GroupLogException;
use Application\Model\Bean\Bean;
use Application\Query\GroupLogQuery;
use Query\Query;

/**
 *
 * GroupLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\GroupLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\GroupLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class GroupLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un GroupLog a la base de datos
     * @param GroupLog $groupLog Objeto GroupLog
     */
    public function create($groupLog)
    {
        $this->validateBean($groupLog);
        try
        {
            $data = $groupLog->toArrayFor(
                array('id_group', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(GroupLog::TABLENAME, $data);
            $groupLog->setIdGroupLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The GroupLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un GroupLog en la base de datos
     * @param GroupLog $groupLog Objeto GroupLog
     */
    public function update($groupLog)
    {
        $this->validateBean($groupLog);
        try
        {
            $data = $groupLog->toArrayFor(
                array('id_group', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(GroupLog::TABLENAME, $data, "id_group_log = '{$groupLog->getIdGroupLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The GroupLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un GroupLog a partir de su Id
     * @param int $idGroupLog
     */
    public function deleteById($idGroupLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_group_log = ?', $idGroupLog));
            $this->getDb()->delete(GroupLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The GroupLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\GroupLogCollection
     */
    protected function makeCollection(){
        return new GroupLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\GroupLog
     */
    protected function makeBean($resultset){
        return GroupLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param GroupLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof GroupLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate GroupLog
     * @param GroupLog $groupLog
     * @throws Exception
     */
    protected function validateBean($groupLog = null){
        if( !($groupLog instanceof GroupLog) ){
            $this->throwException("passed parameter isn't a GroupLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new GroupLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new GroupLogException($message);
        }
    }

 }