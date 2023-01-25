<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\CountryState;
use Application\Model\Factory\CountryStateFactory;
use Application\Model\Collection\CountryStateCollection;
use Application\Model\Exception\CountryStateException;
use Application\Model\Bean\Bean;
use Application\Query\CountryStateQuery;
use Query\Query;

/**
 *
 * CountryStateCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\CountryState getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CountryStateCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CountryStateCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un CountryState a la base de datos
     * @param CountryState $countryState Objeto CountryState
     */
    public function create($countryState)
    {
        $this->validateBean($countryState);
        try
        {
            $data = $countryState->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(CountryState::TABLENAME, $data);
            $countryState->setIdCountryState($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The CountryState can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un CountryState en la base de datos
     * @param CountryState $countryState Objeto CountryState
     */
    public function update($countryState)
    {
        $this->validateBean($countryState);
        try
        {
            $data = $countryState->toArrayFor(
                array('name', 'type', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(CountryState::TABLENAME, $data, "id_country_state = '{$countryState->getIdCountryState()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The CountryState can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un CountryState a partir de su Id
     * @param int $idCountryState
     */
    public function deleteById($idCountryState)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_country_state = ?', $idCountryState));
            $this->getDb()->delete(CountryState::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The CountryState can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CountryStateCollection
     */
    protected function makeCollection(){
        return new CountryStateCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\CountryState
     */
    protected function makeBean($resultset){
        return CountryStateFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CountryStateQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CountryStateQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate CountryState
     * @param CountryState $countryState
     * @throws Exception
     */
    protected function validateBean($countryState = null){
        if( !($countryState instanceof CountryState) ){
            $this->throwException("passed parameter isn't a CountryState instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CountryStateException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CountryStateException($message);
        }
    }

 }