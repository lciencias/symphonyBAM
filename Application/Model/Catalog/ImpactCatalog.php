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
use Application\Model\Bean\Impact;
use Application\Model\Factory\ImpactFactory;
use Application\Model\Collection\ImpactCollection;
use Application\Model\Exception\ImpactException;
use Application\Model\Bean\Bean;
use Application\Query\ImpactQuery;
use Query\Query;

/**
 *
 * ImpactCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Impact getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ImpactCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ImpactCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Impact a la base de datos
     * @param Impact $impact Objeto Impact
     */
    public function create($impact)
    {
        $this->validateBean($impact);
        try
        {
            $data = $impact->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Impact::TABLENAME, $data);
            $impact->setIdImpact($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Impact can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Impact en la base de datos
     * @param Impact $impact Objeto Impact
     */
    public function update($impact)
    {
        $this->validateBean($impact);
        try
        {
            $data = $impact->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Impact::TABLENAME, $data, "id_impact = '{$impact->getIdImpact()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Impact can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Impact a partir de su Id
     * @param int $idImpact
     */
    public function deleteById($idImpact)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_impact = ?', $idImpact));
            $this->getDb()->delete(Impact::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Impact can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ImpactCollection
     */
    protected function makeCollection(){
        return new ImpactCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Impact
     */
    protected function makeBean($resultset){
        return ImpactFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ImpactQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ImpactQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Impact
     * @param Impact $impact
     * @throws Exception
     */
    protected function validateBean($impact = null){
        if( !($impact instanceof Impact) ){
            $this->throwException("passed parameter isn't a Impact instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ImpactException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ImpactException($message);
        }
    }

 }