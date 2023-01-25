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
use Application\Model\Bean\Translate;
use Application\Model\Factory\TranslateFactory;
use Application\Model\Collection\TranslateCollection;
use Application\Model\Exception\TranslateException;
use Application\Model\Bean\Bean;
use Application\Query\TranslateQuery;
use Query\Query;

/**
 *
 * TranslateCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Translate getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TranslateCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TranslateCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Translate a la base de datos
     * @param Translate $translate Objeto Translate
     */
    public function create($translate)
    {
        $this->validateBean($translate);
        try
        {
            $data = $translate->toArrayFor(
                array('string', 'en', 'es', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Translate::TABLENAME, $data);
            $translate->setIdTranslate($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Translate can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Translate en la base de datos
     * @param Translate $translate Objeto Translate
     */
    public function update($translate)
    {
        $this->validateBean($translate);
        try
        {
            $data = $translate->toArrayFor(
                array('string', 'en', 'es', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Translate::TABLENAME, $data, "id_translate = '{$translate->getIdTranslate()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Translate can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Translate a partir de su Id
     * @param int $idTranslate
     */
    public function deleteById($idTranslate)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_translate = ?', $idTranslate));
            $this->getDb()->delete(Translate::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Translate can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar la tabla
     */
    public function deleteAll()
    {
        try{
            $this->getDb()->delete(Translate::TABLENAME, array());
        }
        catch(\Exception $e){
            $this->throwException("The Translate can't be deleted\n", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TranslateCollection
     */
    protected function makeCollection(){
        return new TranslateCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Translate
     */
    protected function makeBean($resultset){
        return TranslateFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TranslateQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TranslateQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Translate
     * @param Translate $translate
     * @throws Exception
     */
    protected function validateBean($translate = null){
        if( !($translate instanceof Translate) ){
            $this->throwException("passed parameter isn't a Translate instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TranslateException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TranslateException($message);
        }
    }

 }