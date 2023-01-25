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
use Application\Model\Bean\AccessRoleLog;
use Application\Model\Factory\AccessRoleLogFactory;
use Application\Model\Collection\AccessRoleLogCollection;
use Application\Model\Exception\AccessRoleLogException;
use Application\Model\Bean\Bean;
use Application\Query\AccessRoleLogQuery;
use Query\Query;

/**
 *
 * AccessRoleLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AccessRoleLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AccessRoleLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AccessRoleLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un AccessRoleLog a la base de datos
     * @param AccessRoleLog $accessRoleLog Objeto AccessRoleLog
     */
    public function create($accessRoleLog)
    {
        $this->validateBean($accessRoleLog);
        try
        {
            $data = $accessRoleLog->toArrayFor(
                array('id_access_role', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(AccessRoleLog::TABLENAME, $data);
            $accessRoleLog->setIdAccessRoleLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRoleLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un AccessRoleLog en la base de datos
     * @param AccessRoleLog $accessRoleLog Objeto AccessRoleLog
     */
    public function update($accessRoleLog)
    {
        $this->validateBean($accessRoleLog);
        try
        {
            $data = $accessRoleLog->toArrayFor(
                array('id_access_role', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(AccessRoleLog::TABLENAME, $data, "id_access_role_log = '{$accessRoleLog->getIdAccessRoleLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRoleLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un AccessRoleLog a partir de su Id
     * @param int $idAccessRoleLog
     */
    public function deleteById($idAccessRoleLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_access_role_log = ?', $idAccessRoleLog));
            $this->getDb()->delete(AccessRoleLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRoleLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AccessRoleLogCollection
     */
    protected function makeCollection(){
        return new AccessRoleLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\AccessRoleLog
     */
    protected function makeBean($resultset){
        return AccessRoleLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AccessRoleLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AccessRoleLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate AccessRoleLog
     * @param AccessRoleLog $accessRoleLog
     * @throws Exception
     */
    protected function validateBean($accessRoleLog = null){
        if( !($accessRoleLog instanceof AccessRoleLog) ){
            $this->throwException("passed parameter isn't a AccessRoleLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AccessRoleLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AccessRoleLogException($message);
        }
    }

 }