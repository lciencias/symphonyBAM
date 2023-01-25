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
use Application\Model\Bean\BranchLog;
use Application\Model\Factory\BranchLogFactory;
use Application\Model\Collection\BranchLogCollection;
use Application\Model\Exception\BranchLogException;
use Application\Model\Bean\Bean;
use Application\Query\BranchLogQuery;
use Query\Query;

/**
 *
 * BranchLogCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\BranchLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\BranchLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class BranchLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un BranchLog a la base de datos
     * @param BranchLog $branchLog Objeto BranchLog
     */
    public function create($branchLog)
    {
        $this->validateBean($branchLog);
        try
        {
            $data = $branchLog->toArrayFor(
                array('id_user', 'id_branch', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(BranchLog::TABLENAME, $data);
            $branchLog->setIdBranchLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The BranchLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un BranchLog en la base de datos
     * @param BranchLog $branchLog Objeto BranchLog
     */
    public function update($branchLog)
    {
        $this->validateBean($branchLog);
        try
        {
            $data = $branchLog->toArrayFor(
                array('id_user', 'id_branch', 'date_log', 'event_type', 'notes', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(BranchLog::TABLENAME, $data, "id_branch_log = '{$branchLog->getIdBranchLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The BranchLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un BranchLog a partir de su Id
     * @param int $idBranchLog
     */
    public function deleteById($idBranchLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_branch_log = ?', $idBranchLog));
            $this->getDb()->delete(BranchLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The BranchLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\BranchLogCollection
     */
    protected function makeCollection(){
        return new BranchLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\BranchLog
     */
    protected function makeBean($resultset){
        return BranchLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param BranchLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof BranchLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate BranchLog
     * @param BranchLog $branchLog
     * @throws Exception
     */
    protected function validateBean($branchLog = null){
        if( !($branchLog instanceof BranchLog) ){
            $this->throwException("passed parameter isn't a BranchLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new BranchLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new BranchLogException($message);
        }
    }

 }