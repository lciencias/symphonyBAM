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
use Application\Model\Bean\CompanyLog;
use Application\Model\Factory\CompanyLogFactory;
use Application\Model\Collection\CompanyLogCollection;
use Application\Model\Exception\CompanyLogException;
use Application\Model\Bean\Bean;
use Application\Query\CompanyLogQuery;
use Query\Query;

/**
 *
 * CompanyLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\CompanyLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CompanyLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CompanyLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un CompanyLog a la base de datos
     * @param CompanyLog $companyLog Objeto CompanyLog
     */
    public function create($companyLog)
    {
        $this->validateBean($companyLog);
        try
        {
            $data = $companyLog->toArrayFor(
                array('id_company', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(CompanyLog::TABLENAME, $data);
            $companyLog->setIdCompanyLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The CompanyLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un CompanyLog en la base de datos
     * @param CompanyLog $companyLog Objeto CompanyLog
     */
    public function update($companyLog)
    {
        $this->validateBean($companyLog);
        try
        {
            $data = $companyLog->toArrayFor(
                array('id_company', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(CompanyLog::TABLENAME, $data, "id_company_log = '{$companyLog->getIdCompanyLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The CompanyLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un CompanyLog a partir de su Id
     * @param int $idCompanyLog
     */
    public function deleteById($idCompanyLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_company_log = ?', $idCompanyLog));
            $this->getDb()->delete(CompanyLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The CompanyLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CompanyLogCollection
     */
    protected function makeCollection(){
        return new CompanyLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\CompanyLog
     */
    protected function makeBean($resultset){
        return CompanyLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CompanyLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CompanyLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate CompanyLog
     * @param CompanyLog $companyLog
     * @throws Exception
     */
    protected function validateBean($companyLog = null){
        if( !($companyLog instanceof CompanyLog) ){
            $this->throwException("passed parameter isn't a CompanyLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CompanyLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CompanyLogException($message);
        }
    }

 }