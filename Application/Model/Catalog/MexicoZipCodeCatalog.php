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
use Application\Model\Bean\MexicoZipCode;
use Application\Model\Factory\MexicoZipCodeFactory;
use Application\Model\Collection\MexicoZipCodeCollection;
use Application\Model\Exception\MexicoZipCodeException;
use Application\Model\Bean\Bean;
use Application\Query\MexicoZipCodeQuery;
use Query\Query;

/**
 *
 * MexicoZipCodeCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\MexicoZipCode getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\MexicoZipCodeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class MexicoZipCodeCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un MexicoZipCode a la base de datos
     * @param MexicoZipCode $mexicoZipCode Objeto MexicoZipCode
     */
    public function create($mexicoZipCode)
    {
        $this->validateBean($mexicoZipCode);
        try
        {
            $data = $mexicoZipCode->toArrayFor(
                array('zip_code', 'settlement', 'settlement_type', 'district', 'state', 'city', 'd_cp', 'id_mexico_state', 'office_code', 'zc_code', 'settlement_type_code', 'district_code', 'id_settlement_zip_code', 'zone', 'city_code', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(MexicoZipCode::TABLENAME, $data);
            $mexicoZipCode->setIdZipCode($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The MexicoZipCode can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un MexicoZipCode en la base de datos
     * @param MexicoZipCode $mexicoZipCode Objeto MexicoZipCode
     */
    public function update($mexicoZipCode)
    {
        $this->validateBean($mexicoZipCode);
        try
        {
            $data = $mexicoZipCode->toArrayFor(
                array('zip_code', 'settlement', 'settlement_type', 'district', 'state', 'city', 'd_cp', 'id_mexico_state', 'office_code', 'zc_code', 'settlement_type_code', 'district_code', 'id_settlement_zip_code', 'zone', 'city_code', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(MexicoZipCode::TABLENAME, $data, "id_zip_code = '{$mexicoZipCode->getIdZipCode()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The MexicoZipCode can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un MexicoZipCode a partir de su Id
     * @param int $idZipCode
     */
    public function deleteById($idZipCode)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_zip_code = ?', $idZipCode));
            $this->getDb()->delete(MexicoZipCode::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The MexicoZipCode can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\MexicoZipCodeCollection
     */
    protected function makeCollection(){
        return new MexicoZipCodeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\MexicoZipCode
     */
    protected function makeBean($resultset){
        return MexicoZipCodeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param MexicoZipCodeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof MexicoZipCodeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate MexicoZipCode
     * @param MexicoZipCode $mexicoZipCode
     * @throws Exception
     */
    protected function validateBean($mexicoZipCode = null){
        if( !($mexicoZipCode instanceof MexicoZipCode) ){
            $this->throwException("passed parameter isn't a MexicoZipCode instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new MexicoZipCodeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new MexicoZipCodeException($message);
        }
    }

 }