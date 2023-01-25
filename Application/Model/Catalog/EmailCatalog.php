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
use Application\Model\Bean\Email;
use Application\Model\Factory\EmailFactory;
use Application\Model\Collection\EmailCollection;
use Application\Model\Exception\EmailException;
use Application\Model\Bean\Bean;
use Application\Query\EmailQuery;
use Query\Query;

/**
 *
 * EmailCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Email getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EmailCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EmailCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Email a la base de datos
     * @param Email $email Objeto Email
     */
    public function create($email)
    {
        $this->validateBean($email);
        try
        {
            $data = $email->toArrayFor(
                array('email', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Email::TABLENAME, $data);
            $email->setIdEmail($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Email can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Email en la base de datos
     * @param Email $email Objeto Email
     */
    public function update($email)
    {
        $this->validateBean($email);
        try
        {
            $data = $email->toArrayFor(
                array('email', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Email::TABLENAME, $data, "id_email = '{$email->getIdEmail()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Email can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Email a partir de su Id
     * @param int $idEmail
     */
    public function deleteById($idEmail)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_email = ?', $idEmail));
            $this->getDb()->delete(Email::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Email can't be deleted\n", $e);
        }
    }


    /**
     * Link a Email to Person
     * @param int $idEmail
     * @param int $idPerson
     * @param int $type
     */
    public function linkToPerson($idEmail, $idPerson, $type)
    {
        try
        {
            $this->unlinkFromPerson($idEmail, $idPerson);
            $data = array(
                'id_email' => $idEmail,
                'id_person' => $idPerson,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_emails', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Email to Person", $e);
        }
    }

    /**
     * Unlink a Email from Person
     * @param int $idEmail
     * @param int $idPerson
     */
    public function unlinkFromPerson($idEmail, $idPerson)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_email = ?', $idEmail),
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            $this->getDb()->delete('pcs_common_persons_emails', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Email to Person", $e);
        }
    }

    /**
     * Unlink all Person relations
     * @param int $idEmail
     */
    public function unlinkAllPerson($idEmail, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_email = ?', $idEmail),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_emails', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Email to Person", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EmailCollection
     */
    protected function makeCollection(){
        return new EmailCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Email
     */
    protected function makeBean($resultset){
        return EmailFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EmailQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EmailQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Email
     * @param Email $email
     * @throws Exception
     */
    protected function validateBean($email = null){
        if( !($email instanceof Email) ){
            $this->throwException("passed parameter isn't a Email instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EmailException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EmailException($message);
        }
    }

 }