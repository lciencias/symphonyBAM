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
use Application\Model\Bean\FileTmp;
use Application\Model\Factory\FileTmpFactory;
use Application\Model\Collection\FileTmpCollection;
use Application\Model\Exception\FileTmpException;
use Application\Model\Bean\Bean;
use Application\Query\FileTmpQuery;
use Query\Query;

/**
 *
 * FileCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\FileTmp getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\FileTmpCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class FileTmpCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un File a la base de datos
     * @param File $file Objeto File
     */
    public function create($fileTmp)
    {
        $this->validateBean($fileTmp);
        try
        {
            $data = $fileTmp->toArrayFor(
                array('uri', 'original_name', 'id_transaction', 'amount_deposit', 'date_deposit', 'type_deposit','id_session')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(FileTmp::TABLENAME, $data);
            $fileTmp->setIdFile($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The File can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un File en la base de datos
     * @param File $file Objeto File
     */
    public function update($fileTmp)
    {
        $this->validateBean($fileTmp);
        try
        {
            $data = $fileTmp->toArrayFor(
                array('uri', 'original_name', 'id_transaction', 'amount_deposit', 'date_deposit', 'type_deposit','id_session' )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(FileTmp::TABLENAME, $data, "id_file = '{$fileTmp->getIdFile()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The File can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un FileTmp a partir de su Id
     * @param int $idFile
     */
    public function deleteById($idFile)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_file = ?', $idFile));
            $this->getDb()->delete(FileTmp::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The File can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\FileTmpCollection
     */
    protected function makeCollection(){
        return new FileTmpCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\FileTmp
     */
    protected function makeBean($resultset){
        return FileTmpFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param FileQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof FileTmpQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate File
     * @param File $file
     * @throws Exception
     */
    protected function validateBean($fileTmp = null){
        if( !($fileTmp instanceof FileTmp) ){
            $this->throwException("passed parameter isn't a FileTmp instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new FileTmpException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new FileTmpException($message);
        }
    }
 }