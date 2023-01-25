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
use Application\Model\Bean\Field;
use Application\Model\Factory\FieldFactory;
use Application\Model\Collection\FieldCollection;
use Application\Model\Exception\FieldException;
use Application\Model\Bean\Bean;
use Application\Query\FieldQuery;
use Query\Query;

/**
 *
 * FieldCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Field getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\FieldCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class FieldCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Field a la base de datos
     * @param Field $field Objeto Field
     */
    public function create($field)
    {
        $this->validateBean($field);
        try
        {
            $data = $field->toArrayFor(
                array('name', 'reg_ex', 'type', 'status', 'sample', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Field::TABLENAME, $data);
            $field->setIdField($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Field can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Field en la base de datos
     * @param Field $field Objeto Field
     */
    public function update($field)
    {
        $this->validateBean($field);
        try
        {
            $data = $field->toArrayFor(
                array('name', 'reg_ex', 'type', 'status', 'sample', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Field::TABLENAME, $data, "id_field = '{$field->getIdField()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Field can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Field a partir de su Id
     * @param int $idField
     */
    public function deleteById($idField)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_field = ?', $idField));
            $this->getDb()->delete(Field::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Field can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\FieldCollection
     */
    protected function makeCollection(){
        return new FieldCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Field
     */
    protected function makeBean($resultset){
        return FieldFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param FieldQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof FieldQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Field
     * @param Field $field
     * @throws Exception
     */
    protected function validateBean($field = null){
        if( !($field instanceof Field) ){
            $this->throwException("passed parameter isn't a Field instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new FieldException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new FieldException($message);
        }
    }

 }