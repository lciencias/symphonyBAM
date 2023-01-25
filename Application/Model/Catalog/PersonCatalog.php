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
use Application\Model\Bean\Person;
use Application\Model\Factory\PersonFactory;
use Application\Model\Collection\PersonCollection;
use Application\Model\Exception\PersonException;
use Application\Model\Bean\Bean;
use Application\Query\PersonQuery;
use Query\Query;

/**
 *
 * PersonCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Person getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PersonCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PersonCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Person a la base de datos
     * @param Person $person Objeto Person
     */
    public function create($person)
    {
        $this->validateBean($person);
        try
        {
            $data = $person->toArrayFor(
                array('name', 'last_name', 'middle_name', 'curp', 'language')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Person::TABLENAME, $data);
            $person->setIdPerson($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Person can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Person en la base de datos
     * @param Person $person Objeto Person
     */
    public function update($person)
    {
        $this->validateBean($person);
        try
        {
            $data = $person->toArrayFor(
                array('name', 'last_name', 'middle_name', 'curp', 'language')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Person::TABLENAME, $data, "id_person = '{$person->getIdPerson()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Person can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Person a partir de su Id
     * @param int $idPerson
     */
    public function deleteById($idPerson)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_person = ?', $idPerson));
            $this->getDb()->delete(Person::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Person can't be deleted\n", $e);
        }
    }


    /**
     * Link a Person to Address
     * @param int $idPerson
     * @param int $idAddress
     * @param int $type
     */
    public function linkToAddress($idPerson, $idAddress, $type)
    {
        try
        {
            $this->unlinkFromAddress($idPerson, $idAddress);
            $data = array(
                'id_person' => $idPerson,
                'id_address' => $idAddress,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_addresses', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Person to Address", $e);
        }
    }

    /**
     * Unlink a Person from Address
     * @param int $idPerson
     * @param int $idAddress
     */
    public function unlinkFromAddress($idPerson, $idAddress)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
                $this->getDb()->quoteInto('id_address = ?', $idAddress),
            );
            $this->getDb()->delete('pcs_common_persons_addresses', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to Address", $e);
        }
    }

    /**
     * Unlink all Address relations
     * @param int $idPerson
     */
    public function unlinkAllAddress($idPerson, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_addresses', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to Address", $e);
        }
    }

    /**
     * Link a Person to Email
     * @param int $idPerson
     * @param int $idEmail
     * @param int $type
     */
    public function linkToEmail($idPerson, $idEmail, $type)
    {
        try
        {
            $this->unlinkFromEmail($idPerson, $idEmail);
            $data = array(
                'id_person' => $idPerson,
                'id_email' => $idEmail,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_emails', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Person to Email", $e);
        }
    }

    /**
     * Unlink a Person from Email
     * @param int $idPerson
     * @param int $idEmail
     */
    public function unlinkFromEmail($idPerson, $idEmail)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
                $this->getDb()->quoteInto('id_email = ?', $idEmail),
            );
            $this->getDb()->delete('pcs_common_persons_emails', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to Email", $e);
        }
    }

    /**
     * Unlink all Email relations
     * @param int $idPerson
     */
    public function unlinkAllEmail($idPerson, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_emails', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to Email", $e);
        }
    }

    /**
     * Link a Person to PhoneNumber
     * @param int $idPerson
     * @param int $idPhoneNumber
     * @param int $type
     */
    public function linkToPhoneNumber($idPerson, $idPhoneNumber, $type)
    {
        try
        {
            $this->unlinkFromPhoneNumber($idPerson, $idPhoneNumber);
            $data = array(
                'id_person' => $idPerson,
                'id_phone_number' => $idPhoneNumber,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_phone_numbers', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Person to PhoneNumber", $e);
        }
    }

    /**
     * Unlink a Person from PhoneNumber
     * @param int $idPerson
     * @param int $idPhoneNumber
     */
    public function unlinkFromPhoneNumber($idPerson, $idPhoneNumber)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
                $this->getDb()->quoteInto('id_phone_number = ?', $idPhoneNumber),
            );
            $this->getDb()->delete('pcs_common_persons_phone_numbers', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to PhoneNumber", $e);
        }
    }

    /**
     * Unlink all PhoneNumber relations
     * @param int $idPerson
     */
    public function unlinkAllPhoneNumber($idPerson, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_phone_numbers', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Person to PhoneNumber", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PersonCollection
     */
    protected function makeCollection(){
        return new PersonCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Person
     */
    protected function makeBean($resultset){
        return PersonFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PersonQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PersonQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Person
     * @param Person $person
     * @throws Exception
     */
    protected function validateBean($person = null){
        if( !($person instanceof Person) ){
            $this->throwException("passed parameter isn't a Person instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PersonException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PersonException($message);
        }
    }

 }