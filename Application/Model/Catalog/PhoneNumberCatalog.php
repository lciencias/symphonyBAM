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
use Application\Model\Bean\PhoneNumber;
use Application\Model\Factory\PhoneNumberFactory;
use Application\Model\Collection\PhoneNumberCollection;
use Application\Model\Exception\PhoneNumberException;
use Application\Model\Bean\Bean;
use Application\Query\PhoneNumberQuery;
use Query\Query;

/**
 *
 * PhoneNumberCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PhoneNumber getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PhoneNumberCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PhoneNumberCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un PhoneNumber a la base de datos
     * @param PhoneNumber $phoneNumber Objeto PhoneNumber
     */
    public function create($phoneNumber)
    {
        $this->validateBean($phoneNumber);
        try
        {
            $data = $phoneNumber->toArrayFor(
                array('number', 'area_code', 'extension', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(PhoneNumber::TABLENAME, $data);
            $phoneNumber->setIdPhoneNumber($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The PhoneNumber can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un PhoneNumber en la base de datos
     * @param PhoneNumber $phoneNumber Objeto PhoneNumber
     */
    public function update($phoneNumber)
    {
        $this->validateBean($phoneNumber);
        try
        {
            $data = $phoneNumber->toArrayFor(
                array('number', 'area_code', 'extension', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(PhoneNumber::TABLENAME, $data, "id_phone_number = '{$phoneNumber->getIdPhoneNumber()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The PhoneNumber can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un PhoneNumber a partir de su Id
     * @param int $idPhoneNumber
     */
    public function deleteById($idPhoneNumber)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_phone_number = ?', $idPhoneNumber));
            $this->getDb()->delete(PhoneNumber::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The PhoneNumber can't be deleted\n", $e);
        }
    }


    /**
     * Link a PhoneNumber to Person
     * @param int $idPhoneNumber
     * @param int $idPerson
     * @param int $type
     */
    public function linkToPerson($idPhoneNumber, $idPerson, $type)
    {
        try
        {
            $this->unlinkFromPerson($idPhoneNumber, $idPerson);
            $data = array(
                'id_phone_number' => $idPhoneNumber,
                'id_person' => $idPerson,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_phone_numbers', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link PhoneNumber to Person", $e);
        }
    }

    /**
     * Unlink a PhoneNumber from Person
     * @param int $idPhoneNumber
     * @param int $idPerson
     */
    public function unlinkFromPerson($idPhoneNumber, $idPerson)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_phone_number = ?', $idPhoneNumber),
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            $this->getDb()->delete('pcs_common_persons_phone_numbers', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink PhoneNumber to Person", $e);
        }
    }

    /**
     * Unlink all Person relations
     * @param int $idPhoneNumber
     */
    public function unlinkAllPerson($idPhoneNumber, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_phone_number = ?', $idPhoneNumber),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_phone_numbers', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink PhoneNumber to Person", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PhoneNumberCollection
     */
    protected function makeCollection(){
        return new PhoneNumberCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\PhoneNumber
     */
    protected function makeBean($resultset){
        return PhoneNumberFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PhoneNumberQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PhoneNumberQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate PhoneNumber
     * @param PhoneNumber $phoneNumber
     * @throws Exception
     */
    protected function validateBean($phoneNumber = null){
        if( !($phoneNumber instanceof PhoneNumber) ){
            $this->throwException("passed parameter isn't a PhoneNumber instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PhoneNumberException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PhoneNumberException($message);
        }
    }

 }