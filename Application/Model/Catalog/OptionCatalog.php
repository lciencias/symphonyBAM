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
use Application\Model\Bean\Option;
use Application\Model\Factory\OptionFactory;
use Application\Model\Collection\OptionCollection;
use Application\Model\Exception\OptionException;
use Application\Model\Bean\Bean;
use Application\Query\OptionQuery;
use Query\Query;

/**
 *
 * OptionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Base\Option getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\OptionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class OptionCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Option a la base de datos
     * @param Option $option Objeto Option
     */
    public function create($option)
    {
        $this->validateBean($option);
        try
        {
            $data = $option->toArrayFor(
                array('name', 'value', 'type', 'regexp', 'detail', 'options', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Option::TABLENAME, $data);
            $option->setIdOption($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Option can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Option en la base de datos
     * @param Option $option Objeto Option
     */
    public function update($option)
    {
        $this->validateBean($option);
        try
        {
            $data = $option->toArrayFor(
                array('name', 'value', 'type', 'regexp', 'detail', 'options', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Option::TABLENAME, $data, "id_option = '{$option->getIdOption()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Option can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Option a partir de su Id
     * @param int $idOption
     */
    public function deleteById($idOption)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_option = ?', $idOption));
            $this->getDb()->delete(Option::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Option can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\OptionCollection
     */
    protected function makeCollection(){
        return new OptionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Base\Option
     */
    protected function makeBean($resultset){
        return OptionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param OptionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof OptionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Option
     * @param Option $option
     * @throws Exception
     */
    protected function validateBean($option = null){
        if( !($option instanceof Option) ){
            $this->throwException("passed parameter isn't a Option instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new OptionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new OptionException($message);
        }
    }

 }