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
use Application\Model\Bean\TemplateEmailLog;
use Application\Model\Factory\TemplateEmailLogFactory;
use Application\Model\Collection\TemplateEmailLogCollection;
use Application\Model\Exception\TemplateEmailLogException;
use Application\Model\Bean\Bean;
use Application\Query\TemplateEmailLogQuery;
use Query\Query;

/**
 *
 * TemplateEmailLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TemplateEmailLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\TemplateEmailLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class TemplateEmailLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un TemplateEmailLog a la base de datos
     * @param TemplateEmailLog $templateEmailLog Objeto TemplateEmailLog
     */
    public function create($templateEmailLog)
    {
        $this->validateBean($templateEmailLog);
        try
        {
            $data = $templateEmailLog->toArrayFor(
                array('id_template_email', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(TemplateEmailLog::TABLENAME, $data);
            $templateEmailLog->setIdTemplateEmailLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmailLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un TemplateEmailLog en la base de datos
     * @param TemplateEmailLog $templateEmailLog Objeto TemplateEmailLog
     */
    public function update($templateEmailLog)
    {
        $this->validateBean($templateEmailLog);
        try
        {
            $data = $templateEmailLog->toArrayFor(
                array('id_template_email', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(TemplateEmailLog::TABLENAME, $data, "id_template_email_log = '{$templateEmailLog->getIdTemplateEmailLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmailLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un TemplateEmailLog a partir de su Id
     * @param int $idTemplateEmailLog
     */
    public function deleteById($idTemplateEmailLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_template_email_log = ?', $idTemplateEmailLog));
            $this->getDb()->delete(TemplateEmailLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The TemplateEmailLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\TemplateEmailLogCollection
     */
    protected function makeCollection(){
        return new TemplateEmailLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    protected function makeBean($resultset){
        return TemplateEmailLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param TemplateEmailLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof TemplateEmailLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate TemplateEmailLog
     * @param TemplateEmailLog $templateEmailLog
     * @throws Exception
     */
    protected function validateBean($templateEmailLog = null){
        if( !($templateEmailLog instanceof TemplateEmailLog) ){
            $this->throwException("passed parameter isn't a TemplateEmailLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new TemplateEmailLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new TemplateEmailLogException($message);
        }
    }

 }