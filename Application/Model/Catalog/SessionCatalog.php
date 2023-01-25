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
use Application\Model\Bean\Session;
use Application\Model\Factory\SessionFactory;
use Application\Model\Collection\SessionCollection;
use Application\Model\Exception\SessionException;
use Application\Model\Bean\Bean;
use Application\Query\SessionQuery;
use Query\Query;

/**
 *
 * SessionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Session getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\SessionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class SessionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Session a la base de datos
     * @param Session $session Objeto Session
     */
    public function create($session)
    {
        $this->validateBean($session);
        try
        {
            $data = $session->toArrayFor(
                array('id_user', 'hash', 'last_request', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Session::TABLENAME, $data);
            $session->setIdSession($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Session en la base de datos
     * @param Session $session Objeto Session
     */
    public function update($session)
    {
        $this->validateBean($session);
        try
        {
            $data = $session->toArrayFor(
                array('id_user', 'hash', 'last_request', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Session::TABLENAME, $data, "id_session = '{$session->getIdSession()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Session a partir de su Id
     * @param int $idSession
     */
    public function deleteById($idSession)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_session = ?', $idSession));
            $this->getDb()->delete(Session::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar un Session a partir de su Id
     * @param int $idSession
     */
    public function deleteByUserId($idUser)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_user = ?', $idUser));
            $this->getDb()->delete(Session::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar un Session a partir de su Id
     * @param int $idSession
     */
    public function deleteByHash($hash)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('hash = ?', $hash));
            $this->getDb()->delete(Session::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar un Session a partir de su Id
     * @param int $idSession
     */
    public function deleteByLastRequest($lastRequest)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('last_request <= ?', $lastRequest));
            $this->getDb()->delete(Session::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Session can't be deleted\n", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\SessionCollection
     */
    protected function makeCollection(){
        return new SessionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Session
     */
    protected function makeBean($resultset){
        return SessionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param SessionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof SessionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Session
     * @param Session $session
     * @throws Exception
     */
    protected function validateBean($session = null){
        if( !($session instanceof Session) ){
            $this->throwException("passed parameter isn't a Session instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new SessionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new SessionException($message);
        }
    }

 }