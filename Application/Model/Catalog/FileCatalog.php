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
use Application\Model\Bean\File;
use Application\Model\Factory\FileFactory;
use Application\Model\Collection\FileCollection;
use Application\Model\Exception\FileException;
use Application\Model\Bean\Bean;
use Application\Query\FileQuery;
use Query\Query;

/**
 *
 * FileCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\File getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\FileCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class FileCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un File a la base de datos
     * @param File $file Objeto File
     */
    public function create($file)
    {
        $this->validateBean($file);
        try
        {
            $data = $file->toArrayFor(
                array('uri', 'original_name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(File::TABLENAME, $data);
            $file->setIdFile($this->getDb()->lastInsertId());
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
    public function update($file)
    {
        $this->validateBean($file);
        try
        {
            $data = $file->toArrayFor(
                array('uri', 'original_name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(File::TABLENAME, $data, "id_file = '{$file->getIdFile()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The File can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un File a partir de su Id
     * @param int $idFile
     */
    public function deleteById($idFile)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_file = ?', $idFile));
            $this->getDb()->delete(File::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The File can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\FileCollection
     */
    protected function makeCollection(){
        return new FileCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\File
     */
    protected function makeBean($resultset){
        return FileFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param FileQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof FileQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate File
     * @param File $file
     * @throws Exception
     */
    protected function validateBean($file = null){
        if( !($file instanceof File) ){
            $this->throwException("passed parameter isn't a File instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new FileException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new FileException($message);
        }
    }

 }