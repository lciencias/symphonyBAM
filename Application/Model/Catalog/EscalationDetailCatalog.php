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
use Application\Model\Bean\EscalationDetail;
use Application\Model\Factory\EscalationDetailFactory;
use Application\Model\Collection\EscalationDetailCollection;
use Application\Model\Exception\EscalationDetailException;
use Application\Model\Bean\Bean;
use Application\Query\EscalationDetailQuery;
use Query\Query;

/**
 *
 * EscalationDetailCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EscalationDetail getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\EscalationDetailCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class EscalationDetailCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un EscalationDetail a la base de datos
     * @param EscalationDetail $escalationDetail Objeto EscalationDetail
     */
    public function create($escalationDetail)
    {
        $this->validateBean($escalationDetail);
        try
        {
            $data = $escalationDetail->toArrayFor(
                array('id_escalation', 'percentage', 'type', 'value', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(EscalationDetail::TABLENAME, $data);
            $escalationDetail->setIdEscalationDetails($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationDetail can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un EscalationDetail en la base de datos
     * @param EscalationDetail $escalationDetail Objeto EscalationDetail
     */
    public function update($escalationDetail)
    {
        $this->validateBean($escalationDetail);
        try
        {
            $data = $escalationDetail->toArrayFor(
                array('id_escalation', 'percentage', 'type', 'value', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(EscalationDetail::TABLENAME, $data, "id_escalation_details = '{$escalationDetail->getIdEscalationDetails()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationDetail can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un EscalationDetail a partir de su Id
     * @param int $idEscalationDetails
     */
    public function deleteById($idEscalationDetails)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_escalation_details = ?', $idEscalationDetails));
            $this->getDb()->delete(EscalationDetail::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationDetail can't be deleted\n", $e);
        }
    }

    /**
     * Metodo para eliminar un EscalationDetail a partir de su Id
     * @param int $idEscalationDetails
     */
    public function deleteByIdEscalation($idEscalation)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_escalation = ?', $idEscalation));
            $this->getDb()->delete(EscalationDetail::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The EscalationDetail can't be deleted\n", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\EscalationDetailCollection
     */
    protected function makeCollection(){
        return new EscalationDetailCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\EscalationDetail
     */
    protected function makeBean($resultset){
        return EscalationDetailFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param EscalationDetailQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof EscalationDetailQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate EscalationDetail
     * @param EscalationDetail $escalationDetail
     * @throws Exception
     */
    protected function validateBean($escalationDetail = null){
        if( !($escalationDetail instanceof EscalationDetail) ){
            $this->throwException("passed parameter isn't a EscalationDetail instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new EscalationDetailException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new EscalationDetailException($message);
        }
    }

 }