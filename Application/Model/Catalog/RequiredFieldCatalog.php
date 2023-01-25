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
use Application\Model\Bean\RequiredField;
use Application\Model\Factory\RequiredFieldFactory;
use Application\Model\Collection\RequiredFieldCollection;
use Application\Model\Exception\RequiredFieldException;
use Application\Model\Bean\Bean;
use Application\Query\RequiredFieldQuery;
use Query\Query;

/**
 *
 * RequiredFieldCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\RequiredField getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\RequiredFieldCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class RequiredFieldCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un RequiredField a la base de datos
     * @param RequiredField $requiredField Objeto RequiredField
     */
    public function create($requiredField)
    {
        $this->validateBean($requiredField);
        try
        {
            $data = $requiredField->toArrayFor(
                array('id_client_category', 'id_field', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(RequiredField::TABLENAME, $data);
            $requiredField->setIdRequiredField($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredField can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un RequiredField en la base de datos
     * @param RequiredField $requiredField Objeto RequiredField
     */
    public function update($requiredField)
    {
        $this->validateBean($requiredField);
        try
        {
            $data = $requiredField->toArrayFor(
                array('id_client_category', 'id_field', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(RequiredField::TABLENAME, $data, "id_required_field = '{$requiredField->getIdRequiredField()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredField can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un RequiredField a partir de su Id
     * @param int $idRequiredField
     */
    public function deleteById($idRequiredField)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_required_field = ?', $idRequiredField));
            $this->getDb()->delete(RequiredField::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The RequiredField can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\RequiredFieldCollection
     */
    protected function makeCollection(){
        return new RequiredFieldCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\RequiredField
     */
    protected function makeBean($resultset){
        return RequiredFieldFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param RequiredFieldQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof RequiredFieldQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate RequiredField
     * @param RequiredField $requiredField
     * @throws Exception
     */
    protected function validateBean($requiredField = null){
        if( !($requiredField instanceof RequiredField) ){
            $this->throwException("passed parameter isn't a RequiredField instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new RequiredFieldException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new RequiredFieldException($message);
        }
    }

 }