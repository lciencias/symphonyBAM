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
use Application\Model\Bean\EscalationLog;
use Application\Model\Factory\EscalationLogFactory;
use Application\Model\Collection\EscalationLogCollection;
use Application\Model\Exception\EscalationLogException;
use Application\Model\Bean\Bean;
use Application\Query\EscalationLogQuery;
use Query\Query;

/**
 *
 * EscalationLogCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EscalationLog getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EscalationLogCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EscalationLogCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un EscalationLog a la base de datos
     * @param EscalationLog $escalationLog Objeto EscalationLog
     */
    public function create($escalationLog)
    {
        $this->validateBean($escalationLog);
        try
        {
            $data = $escalationLog->toArrayFor(
                array('id_escalation', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(EscalationLog::TABLENAME, $data);
            $escalationLog->setIdEscalationLog($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un EscalationLog en la base de datos
     * @param EscalationLog $escalationLog Objeto EscalationLog
     */
    public function update($escalationLog)
    {
        $this->validateBean($escalationLog);
        try
        {
            $data = $escalationLog->toArrayFor(
                array('id_escalation', 'id_user', 'date_log', 'event_type', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(EscalationLog::TABLENAME, $data, "id_escalation_log = '{$escalationLog->getIdEscalationLog()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationLog can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un EscalationLog a partir de su Id
     * @param int $idEscalationLog
     */
    public function deleteById($idEscalationLog)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_escalation_log = ?', $idEscalationLog));
            $this->getDb()->delete(EscalationLog::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationLog can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EscalationLogCollection
     */
    protected function makeCollection(){
        return new EscalationLogCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\EscalationLog
     */
    protected function makeBean($resultset){
        return EscalationLogFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EscalationLogQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EscalationLogQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate EscalationLog
     * @param EscalationLog $escalationLog
     * @throws Exception
     */
    protected function validateBean($escalationLog = null){
        if( !($escalationLog instanceof EscalationLog) ){
            $this->throwException("passed parameter isn't a EscalationLog instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EscalationLogException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EscalationLogException($message);
        }
    }

 }