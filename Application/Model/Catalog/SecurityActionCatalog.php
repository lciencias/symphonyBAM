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
use Application\Model\Bean\SecurityAction;
use Application\Model\Factory\SecurityActionFactory;
use Application\Model\Collection\SecurityActionCollection;
use Application\Model\Exception\SecurityActionException;
use Application\Model\Bean\Bean;
use Application\Query\SecurityActionQuery;
use Query\Query;

/**
 *
 * SecurityActionCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\SecurityAction getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\SecurityActionCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class SecurityActionCatalog extends AbstractCatalog
{

    /**
     *
     * @param SecurityAction $securityAction
     */
    public function save($securityAction){
        $this->validateBean($securityAction);
        if( $securityAction->getIdAction() ){
            $this->update($securityAction);
        }else{
            $this->create($securityAction);
        }
    }

    /**
     * Metodo para agregar un SecurityAction a la base de datos
     * @param SecurityAction $securityAction Objeto SecurityAction
     */
    public function create($securityAction)
    {
        $this->validateBean($securityAction);
        try
        {
            $data = $securityAction->toArrayFor(
                array('id_controller', 'name', 'tag_module', 'tag_action')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(SecurityAction::TABLENAME, $data);
            $securityAction->setIdAction($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityAction can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un SecurityAction en la base de datos
     * @param SecurityAction $securityAction Objeto SecurityAction
     */
    public function update($securityAction)
    {
        $this->validateBean($securityAction);
        try
        {
            $data = $securityAction->toArrayFor(
                array('id_controller', 'name', 'tag_module', 'tag_action')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(SecurityAction::TABLENAME, $data, "id_action = '{$securityAction->getIdAction()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityAction can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un SecurityAction a partir de su Id
     * @param int $idAction
     */
    public function deleteById($idAction)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_action = ?', $idAction));
            $this->getDb()->delete(SecurityAction::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityAction can't be deleted\n", $e);
        }
    }


    /**
     * Link a SecurityAction to AccessRole
     * @param int $idSecurityAction
     * @param int $idAccessRole
     */
    public function linkToAccessRole($idSecurityAction, $idAccessRole)
    {
        try
        {
            $this->unlinkFromAccessRole($idSecurityAction, $idAccessRole);
            $data = array(
                'id_security_action' => $idSecurityAction,
                'id_access_role' => $idAccessRole,
            );
            $this->getDb()->insert('pcs_common_security_actions_access_roles', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link SecurityAction to AccessRole", $e);
        }
    }

    /**
     * Unlink a SecurityAction from AccessRole
     * @param int $idSecurityAction
     * @param int $idAccessRole
     */
    public function unlinkFromAccessRole($idSecurityAction, $idAccessRole)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_security_action = ?', $idSecurityAction),
                $this->getDb()->quoteInto('id_access_role = ?', $idAccessRole),
            );
            $this->getDb()->delete('pcs_common_security_actions_access_roles', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink SecurityAction to AccessRole", $e);
        }
    }

    /**
     * Unlink all AccessRole relations
     * @param int $idSecurityAction
     */
    public function unlinkAllAccessRole($idSecurityAction)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_security_action = ?', $idSecurityAction),
            );
            $this->getDb()->delete('pcs_common_security_actions_access_roles', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink SecurityAction to AccessRole", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\SecurityActionCollection
     */
    protected function makeCollection(){
        return new SecurityActionCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\SecurityAction
     */
    protected function makeBean($resultset){
        return SecurityActionFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param SecurityActionQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof SecurityActionQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate SecurityAction
     * @param SecurityAction $securityAction
     * @throws Exception
     */
    protected function validateBean($securityAction = null){
        if( !($securityAction instanceof SecurityAction) ){
            $this->throwException("passed parameter isn't a SecurityAction instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new SecurityActionException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new SecurityActionException($message);
        }
    }

 }