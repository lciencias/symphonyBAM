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
use Application\Model\Bean\Address;
use Application\Model\Factory\AddressFactory;
use Application\Model\Collection\AddressCollection;
use Application\Model\Exception\AddressException;
use Application\Model\Bean\Bean;
use Application\Query\AddressQuery;
use Query\Query;

/**
 *
 * AddressCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Address getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AddressCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AddressCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Address a la base de datos
     * @param Address $address Objeto Address
     */
    public function create($address)
    {
        $this->validateBean($address);
        try
        {
            $data = $address->toArrayFor(
                array('zip_code', 'street', 'settlement', 'district', 'city', 'state', 'country', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Address::TABLENAME, $data);
            $address->setIdAddress($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Address can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Address en la base de datos
     * @param Address $address Objeto Address
     */
    public function update($address)
    {
        $this->validateBean($address);
        try
        {
            $data = $address->toArrayFor(
                array('zip_code', 'street', 'settlement', 'district', 'city', 'state', 'country', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Address::TABLENAME, $data, "id_address = '{$address->getIdAddress()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Address can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Address a partir de su Id
     * @param int $idAddress
     */
    public function deleteById($idAddress)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_address = ?', $idAddress));
            $this->getDb()->delete(Address::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Address can't be deleted\n", $e);
        }
    }


    /**
     * Link a Address to Person
     * @param int $idAddress
     * @param int $idPerson
     * @param int $type
     */
    public function linkToPerson($idAddress, $idPerson, $type)
    {
        try
        {
            $this->unlinkFromPerson($idAddress, $idPerson);
            $data = array(
                'id_address' => $idAddress,
                'id_person' => $idPerson,
                'type' => $type,
            );
            $this->getDb()->insert('pcs_common_persons_addresses', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Address to Person", $e);
        }
    }

    /**
     * Unlink a Address from Person
     * @param int $idAddress
     * @param int $idPerson
     */
    public function unlinkFromPerson($idAddress, $idPerson)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_address = ?', $idAddress),
                $this->getDb()->quoteInto('id_person = ?', $idPerson),
            );
            $this->getDb()->delete('pcs_common_persons_addresses', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Address to Person", $e);
        }
    }

    /**
     * Unlink all Person relations
     * @param int $idAddress
     */
    public function unlinkAllPerson($idAddress, $type = null)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_address = ?', $idAddress),
            );
            if( null != $type ) $where[] = $this->getDb()->quoteInto('type = ?', $type);
            $this->getDb()->delete('pcs_common_persons_addresses', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Address to Person", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AddressCollection
     */
    protected function makeCollection(){
        return new AddressCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Address
     */
    protected function makeBean($resultset){
        return AddressFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AddressQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AddressQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Address
     * @param Address $address
     * @throws Exception
     */
    protected function validateBean($address = null){
        if( !($address instanceof Address) ){
            $this->throwException("passed parameter isn't a Address instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AddressException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AddressException($message);
        }
    }

 }