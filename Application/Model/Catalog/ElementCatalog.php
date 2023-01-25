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
use Application\Model\Bean\Element;
use Application\Model\Factory\ElementFactory;
use Application\Model\Collection\ElementCollection;
use Application\Model\Exception\ElementException;
use Application\Model\Bean\Bean;
use Application\Query\ElementQuery;
use Query\Query;

/**
 *
 * ElementCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Element getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ElementCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ElementCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Element a la base de datos
     * @param Element $element Objeto Element
     */
    public function create($element)
    {
        $this->validateBean($element);
        try
        {
            $data = $element->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Element::TABLENAME, $data);
            $element->setIdElement($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Element can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Element en la base de datos
     * @param Element $element Objeto Element
     */
    public function update($element)
    {
        $this->validateBean($element);
        try
        {
            $data = $element->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Element::TABLENAME, $data, "id_element = '{$element->getIdElement()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Element can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Element a partir de su Id
     * @param int $idElement
     */
    public function deleteById($idElement)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_element = ?', $idElement));
            $this->getDb()->delete(Element::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Element can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ElementCollection
     */
    protected function makeCollection(){
        return new ElementCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Element
     */
    protected function makeBean($resultset){
        return ElementFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ElementQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ElementQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Element
     * @param Element $element
     * @throws Exception
     */
    protected function validateBean($element = null){
        if( !($element instanceof Element) ){
            $this->throwException("passed parameter isn't a Element instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ElementException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ElementException($message);
        }
    }

 }