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
use Application\Model\Bean\Location;
use Application\Model\Factory\LocationFactory;
use Application\Model\Collection\LocationCollection;
use Application\Model\Exception\LocationException;
use Application\Model\Bean\Bean;
use Application\Query\LocationQuery;
use Query\Query;

/**
 *
 * LocationCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Location getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\LocationCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class LocationCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Location a la base de datos
     * @param Location $location Objeto Location
     */
    public function create($location)
    {
        $this->validateBean($location);
        try
        {
            $data = $location->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Location::TABLENAME, $data);
            $location->setIdLocation($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Location can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Location en la base de datos
     * @param Location $location Objeto Location
     */
    public function update($location)
    {
        $this->validateBean($location);
        try
        {
            $data = $location->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Location::TABLENAME, $data, "id_location = '{$location->getIdLocation()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Location can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Location a partir de su Id
     * @param int $idLocation
     */
    public function deleteById($idLocation)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_location = ?', $idLocation));
            $this->getDb()->delete(Location::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Location can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\LocationCollection
     */
    protected function makeCollection(){
        return new LocationCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Location
     */
    protected function makeBean($resultset){
        return LocationFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param LocationQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof LocationQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Location
     * @param Location $location
     * @throws Exception
     */
    protected function validateBean($location = null){
        if( !($location instanceof Location) ){
            $this->throwException("passed parameter isn't a Location instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new LocationException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new LocationException($message);
        }
    }

 }