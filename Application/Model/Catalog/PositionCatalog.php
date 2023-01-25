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
use Application\Model\Bean\Position;
use Application\Model\Factory\PositionFactory;
use Application\Model\Collection\PositionCollection;
use Application\Model\Exception\PositionException;
use Application\Model\Bean\Bean;
use Application\Query\PositionQuery;
use Query\Query;

/**
 *
 * PositionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Position getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\PositionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class PositionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Position a la base de datos
     * @param Position $position Objeto Position
     */
    public function create($position)
    {
        $this->validateBean($position);
        try
        {
            $data = $position->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Position::TABLENAME, $data);
            $position->setIdPosition($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Position can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Position en la base de datos
     * @param Position $position Objeto Position
     */
    public function update($position)
    {
        $this->validateBean($position);
        try
        {
            $data = $position->toArrayFor(
                array('id_company', 'name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Position::TABLENAME, $data, "id_position = '{$position->getIdPosition()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Position can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Position a partir de su Id
     * @param int $idPosition
     */
    public function deleteById($idPosition)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_position = ?', $idPosition));
            $this->getDb()->delete(Position::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Position can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\PositionCollection
     */
    protected function makeCollection(){
        return new PositionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Position
     */
    protected function makeBean($resultset){
        return PositionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param PositionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof PositionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Position
     * @param Position $position
     * @throws Exception
     */
    protected function validateBean($position = null){
        if( !($position instanceof Position) ){
            $this->throwException("passed parameter isn't a Position instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new PositionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new PositionException($message);
        }
    }

 }