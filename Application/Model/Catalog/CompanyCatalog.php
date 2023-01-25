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
use Application\Model\Bean\Company;
use Application\Model\Factory\CompanyFactory;
use Application\Model\Collection\CompanyCollection;
use Application\Model\Exception\CompanyException;
use Application\Model\Bean\Bean;
use Application\Query\CompanyQuery;
use Query\Query;

/**
 *
 * CompanyCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Company getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CompanyCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CompanyCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Company a la base de datos
     * @param Company $company Objeto Company
     */
    public function create($company)
    {
        $this->validateBean($company);
        try
        {
            $data = $company->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Company::TABLENAME, $data);
            $company->setIdCompany($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Company can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Company en la base de datos
     * @param Company $company Objeto Company
     */
    public function update($company)
    {
        $this->validateBean($company);
        try
        {
            $data = $company->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Company::TABLENAME, $data, "id_company = '{$company->getIdCompany()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Company can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Company a partir de su Id
     * @param int $idCompany
     */
    public function deleteById($idCompany)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_company = ?', $idCompany));
            $this->getDb()->delete(Company::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Company can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CompanyCollection
     */
    protected function makeCollection(){
        return new CompanyCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Company
     */
    protected function makeBean($resultset){
        return CompanyFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CompanyQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CompanyQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Company
     * @param Company $company
     * @throws Exception
     */
    protected function validateBean($company = null){
        if( !($company instanceof Company) ){
            $this->throwException("passed parameter isn't a Company instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CompanyException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CompanyException($message);
        }
    }

 }