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
use Application\Model\Bean\Attachment;
use Application\Model\Factory\AttachmentFactory;
use Application\Model\Collection\AttachmentCollection;
use Application\Model\Exception\AttachmentException;
use Application\Model\Bean\Bean;
use Application\Query\AttachmentQuery;
use Query\Query;

/**
 *
 * AttachmentCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Attachment getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AttachmentCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AttachmentCatalog extends FileCatalog{

    /**
     * Metodo para agregar un Attachment a la base de datos
     * @param Attachment $attachment Objeto Attachment
     */
    public function create($attachment)
    {
        $this->validateBean($attachment);
        try
        {
            if( !$attachment->getIdFile() ){
              parent::create($attachment);
            }

            $data = $attachment->toArrayFor(
                array('id_base_ticket', 'id_file', 'id_user', 'created_at', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Attachment::TABLENAME, $data);
            $attachment->setIdAttachment($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Attachment can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Attachment en la base de datos
     * @param Attachment $attachment Objeto Attachment
     */
    public function update($attachment)
    {
        $this->validateBean($attachment);
        try
        {
            $data = $attachment->toArrayFor(
                array('id_base_ticket', 'id_file', 'id_user', 'created_at', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Attachment::TABLENAME, $data, "id_attachment = '{$attachment->getIdAttachment()}'");
            parent::update($attachment);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Attachment can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Attachment a partir de su Id
     * @param int $idAttachment
     */
    public function deleteById($idAttachment)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_attachment = ?', $idAttachment));
            $this->getDb()->delete(Attachment::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Attachment can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AttachmentCollection
     */
    protected function makeCollection(){
        return new AttachmentCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Attachment
     */
    protected function makeBean($resultset){
        return AttachmentFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AttachmentQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AttachmentQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Attachment
     * @param Attachment $attachment
     * @throws Exception
     */
    protected function validateBean($attachment = null){
        if( !($attachment instanceof Attachment) ){
            $this->throwException("passed parameter isn't a Attachment instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AttachmentException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AttachmentException($message);
        }
    }

 }