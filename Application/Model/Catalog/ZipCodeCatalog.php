<?php
/**
 * Bender
 *
 * Example Project created by Bender Code Generator
 *
 * @copyright Copyright (c) 2012 Bender (https://github.com/chentepixtol/Bender2)
 * @author    chente, $LastChangedBy$
 * @version   1
 */

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\ZipCode;
use Application\Model\Factory\ZipCodeFactory;
use Application\Model\Collection\ZipCodeCollection;
use Application\Model\Exception\ZipCodeException;
use Application\Model\Bean\Bean;
use Application\Query\ZipCodeQuery;
use Query\Query;

/**
 *
 * ZipCodeCatalog
 *
 * @package Application\Model\Catalog
 * @author chente
 * @method \Application\Model\Bean\ZipCode getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ZipCodeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ZipCodeCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un ZipCode a la base de datos
     * @param ZipCode $zipCode Objeto ZipCode
     */
    public function create($zipCode)
    {
        $this->validateBean($zipCode);
        try
        {
            $data = $zipCode->toArrayFor(
                array('zip_code', 'settlement', 'settlement_type', 'district', 'state', 'city', 'd_cp', 'id_mexico_state', 'office_code', 'zc_code', 'settlement_type_code', 'district_code', 'id_settlement_zip_code', 'zone', 'city_code', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(ZipCode::TABLENAME, $data);
            $zipCode->setIdZipCode($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The ZipCode can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un ZipCode en la base de datos
     * @param ZipCode $zipCode Objeto ZipCode
     */
    public function update($zipCode)
    {
        $this->validateBean($zipCode);
        try
        {
            $data = $zipCode->toArrayFor(
                array('zip_code','settlement','settlement_type','district','state','city','d_cp','id_mexico_state','office_code','zc_code','settlement_type_code','district_code','id_settlement_zip_code','zone','city_code',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(ZipCode::TABLENAME, $data, "id_zip_code = '{$zipCode->getIdZipCode()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The ZipCode can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un ZipCode a partir de su Id
     * @param int $idZipCode
     */
    public function deleteById($idZipCode)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_zip_code = ?', $idZipCode));
            $this->getDb()->delete(ZipCode::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The ZipCode can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ZipCodeCollection
     */
    protected function makeCollection(){
        return new ZipCodeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\ZipCode
     */
    protected function makeBean($resultset){
        return ZipCodeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ZipCodeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ZipCodeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate ZipCode
     * @param ZipCode $zipCode
     * @throws Exception
     */
    protected function validateBean($zipCode = null){
        if( !($zipCode instanceof ZipCode) ){
            $this->throwException("passed parameter isn't a ZipCode instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ZipCodeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ZipCodeException($message);
        }
    }

 }