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
use Application\Model\Bean\TemplateEmail;
use Application\Model\Factory\TemplateEmailFactory;
use Application\Model\Collection\TemplateEmailCollection;
use Application\Model\Exception\TemplateEmailException;
use Application\Model\Bean\Bean;
use Application\Query\TemplateEmailQuery;
use Query\Query;

/**
 *
 * TemplateEmailCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TemplateEmail getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TemplateEmailCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TemplateEmailCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TemplateEmail a la base de datos
     * @param TemplateEmail $templateEmail Objeto TemplateEmail
     */
    public function create($templateEmail)
    {
        $this->validateBean($templateEmail);
        try
        {
            $data = $templateEmail->toArrayFor(
                array('id_company', 'name', 'subject', 'body', 'event', 'status', 'to_employee', 'to_user', 'to_group', 'language', 'kind_of_ticket')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TemplateEmail::TABLENAME, $data);
            $templateEmail->setIdTemplateEmail($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmail can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TemplateEmail en la base de datos
     * @param TemplateEmail $templateEmail Objeto TemplateEmail
     */
    public function update($templateEmail)
    {
        $this->validateBean($templateEmail);
        try
        {
            $data = $templateEmail->toArrayFor(
                array('id_company', 'name', 'subject', 'body', 'event', 'status', 'to_employee', 'to_user', 'to_group', 'language', 'kind_of_ticket')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TemplateEmail::TABLENAME, $data, "id_template_email = '{$templateEmail->getIdTemplateEmail()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmail can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TemplateEmail a partir de su Id
     * @param int $idTemplateEmail
     */
    public function deleteById($idTemplateEmail)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_template_email = ?', $idTemplateEmail));
            $this->getDb()->delete(TemplateEmail::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmail can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TemplateEmailCollection
     */
    protected function makeCollection(){
        return new TemplateEmailCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TemplateEmail
     */
    protected function makeBean($resultset){
        return TemplateEmailFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TemplateEmailQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TemplateEmailQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TemplateEmail
     * @param TemplateEmail $templateEmail
     * @throws Exception
     */
    protected function validateBean($templateEmail = null){
        if( !($templateEmail instanceof TemplateEmail) ){
            $this->throwException("passed parameter isn't a TemplateEmail instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TemplateEmailException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TemplateEmailException($message);
        }
    }

 }