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
use Application\Model\Bean\Branch;
use Application\Model\Factory\BranchFactory;
use Application\Model\Collection\BranchCollection;
use Application\Model\Exception\BranchException;
use Application\Model\Bean\Bean;
use Application\Query\BranchQuery;
use Query\Query;

/**
 *
 * BranchCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Branch getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\BranchCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class BranchCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Branch a la base de datos
     * @param Branch $branch Objeto Branch
     */
    public function create($branch)
    {
        $this->validateBean($branch);
        try
        {
            $data = $branch->toArrayFor(
                array('id_country_state', 'name', 'status', 'id_bam', 'address', 'scheduled', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Branch::TABLENAME, $data);
            $branch->setIdBranch($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Branch can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Branch en la base de datos
     * @param Branch $branch Objeto Branch
     */
    public function update($branch)
    {
        $this->validateBean($branch);
        try
        {
            $data = $branch->toArrayFor(
                array('id_country_state', 'name', 'status', 'id_bam', 'address', 'scheduled', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Branch::TABLENAME, $data, "id_branch = '{$branch->getIdBranch()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Branch can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Branch a partir de su Id
     * @param int $idBranch
     */
    public function deleteById($idBranch)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_branch = ?', $idBranch));
            $this->getDb()->delete(Branch::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Branch can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\BranchCollection
     */
    protected function makeCollection(){
        return new BranchCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Branch
     */
    protected function makeBean($resultset){
        return BranchFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param BranchQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof BranchQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Branch
     * @param Branch $branch
     * @throws Exception
     */
    protected function validateBean($branch = null){
        if( !($branch instanceof Branch) ){
            $this->throwException("passed parameter isn't a Branch instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new BranchException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new BranchException($message);
        }
    }

 }