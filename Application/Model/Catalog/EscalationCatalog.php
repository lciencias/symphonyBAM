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
use Application\Model\Bean\Escalation;
use Application\Model\Factory\EscalationFactory;
use Application\Model\Collection\EscalationCollection;
use Application\Model\Exception\EscalationException;
use Application\Model\Bean\Bean;
use Application\Query\EscalationQuery;
use Query\Query;

/**
 *
 * EscalationCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Escalation getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EscalationCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EscalationCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Escalation a la base de datos
     * @param Escalation $escalation Objeto Escalation
     */
    public function create($escalation)
    {
        $this->validateBean($escalation);
        try
        {
            $data = $escalation->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Escalation::TABLENAME, $data);
            $escalation->setIdEscalation($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Escalation can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Escalation en la base de datos
     * @param Escalation $escalation Objeto Escalation
     */
    public function update($escalation)
    {
        $this->validateBean($escalation);
        try
        {
            $data = $escalation->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Escalation::TABLENAME, $data, "id_escalation = '{$escalation->getIdEscalation()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Escalation can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Escalation a partir de su Id
     * @param int $idEscalation
     */
    public function deleteById($idEscalation)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_escalation = ?', $idEscalation));
            $this->getDb()->delete(Escalation::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Escalation can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EscalationCollection
     */
    protected function makeCollection(){
        return new EscalationCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Escalation
     */
    protected function makeBean($resultset){
        return EscalationFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EscalationQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EscalationQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Escalation
     * @param Escalation $escalation
     * @throws Exception
     */
    protected function validateBean($escalation = null){
        if( !($escalation instanceof Escalation) ){
            $this->throwException("passed parameter isn't a Escalation instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EscalationException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EscalationException($message);
        }
    }

 }