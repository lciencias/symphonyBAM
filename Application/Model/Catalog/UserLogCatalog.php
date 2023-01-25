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
use Application\Model\Bean\UserLog;
use Application\Model\Factory\UserLogFactory;
use Application\Model\Collection\UserLogCollection;
use Application\Model\Exception\UserLogException;
use Application\Model\Bean\Bean;
use Application\Query\UserLogQuery;
use Query\Query;

/**
 *
 * UserLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\UserLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\UserLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class UserLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un UserLog a la base de datos
     * @param UserLog $userLog Objeto UserLog
     */
    public function create($userLog)
    {
        $this->validateBean($userLog);
        try
        {
            $data = $userLog->toArrayFor(
                array('id_user', 'event_type', 'ip', 'id_responsible', 'timestamp', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(UserLog::TABLENAME, $data);
            $userLog->setIdUserLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The UserLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un UserLog en la base de datos
     * @param UserLog $userLog Objeto UserLog
     */
    public function update($userLog)
    {
        $this->validateBean($userLog);
        try
        {
            $data = $userLog->toArrayFor(
                array('id_user', 'event_type', 'ip', 'id_responsible', 'timestamp', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(UserLog::TABLENAME, $data, "id_user_log = '{$userLog->getIdUserLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The UserLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un UserLog a partir de su Id
     * @param int $idUserLog
     */
    public function deleteById($idUserLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_user_log = ?', $idUserLog));
            $this->getDb()->delete(UserLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The UserLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\UserLogCollection
     */
    protected function makeCollection(){
        return new UserLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\UserLog
     */
    protected function makeBean($resultset){
        return UserLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param UserLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof UserLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate UserLog
     * @param UserLog $userLog
     * @throws Exception
     */
    protected function validateBean($userLog = null){
        if( !($userLog instanceof UserLog) ){
            $this->throwException("passed parameter isn't a UserLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new UserLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new UserLogException($message);
        }
    }

 }