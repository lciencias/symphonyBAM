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
use Application\Model\Bean\AccessRole;
use Application\Model\Factory\AccessRoleFactory;
use Application\Model\Collection\AccessRoleCollection;
use Application\Model\Exception\AccessRoleException;
use Application\Model\Bean\Bean;
use Application\Query\AccessRoleQuery;
use Query\Query;

/**
 *
 * AccessRoleCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\AccessRole getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\AccessRoleCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class AccessRoleCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un AccessRole a la base de datos
     * @param AccessRole $accessRole Objeto AccessRole
     */
    public function create($accessRole)
    {
        $this->validateBean($accessRole);
        try
        {
            $data = $accessRole->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(AccessRole::TABLENAME, $data);
            $accessRole->setIdAccessRole($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRole can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un AccessRole en la base de datos
     * @param AccessRole $accessRole Objeto AccessRole
     */
    public function update($accessRole)
    {
        $this->validateBean($accessRole);
        try
        {
            $data = $accessRole->toArrayFor(
                array('name', 'status', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(AccessRole::TABLENAME, $data, "id_access_role = '{$accessRole->getIdAccessRole()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRole can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un AccessRole a partir de su Id
     * @param int $idAccessRole
     */
    public function deleteById($idAccessRole)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_access_role = ?', $idAccessRole));
            $this->getDb()->delete(AccessRole::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The AccessRole can't be deleted\n", $e);
        }
    }


    /**
     * Link a AccessRole to SecurityAction
     * @param int $idAccessRole
     * @param int $idSecurityAction
     */
    public function linkToSecurityAction($idAccessRole, $idSecurityAction)
    {
        try
        {
            $this->unlinkFromSecurityAction($idAccessRole, $idSecurityAction);
            $data = array(
                'id_access_role' => $idAccessRole,
                'id_security_action' => $idSecurityAction,
            );
            $this->getDb()->insert('pcs_common_security_actions_access_roles', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link AccessRole to SecurityAction", $e);
        }
    }

    /**
     * Unlink a AccessRole from SecurityAction
     * @param int $idAccessRole
     * @param int $idSecurityAction
     */
    public function unlinkFromSecurityAction($idAccessRole, $idSecurityAction)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_access_role = ?', $idAccessRole),
                $this->getDb()->quoteInto('id_security_action = ?', $idSecurityAction),
            );
            $this->getDb()->delete('pcs_common_security_actions_access_roles', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink AccessRole to SecurityAction", $e);
        }
    }

    /**
     * Unlink all SecurityAction relations
     * @param int $idAccessRole
     */
    public function unlinkAllSecurityAction($idAccessRole)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_access_role = ?', $idAccessRole),
            );
            $this->getDb()->delete('pcs_common_security_actions_access_roles', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink AccessRole to SecurityAction", $e);
        }
    }

   /**
    * @return array
    */
    public function getAllPermissions()
    {
        $permissions = array();
        $sql = "SELECT * FROM pcs_common_security_actions_access_roles";
        foreach( $this->getDb()->fetchAll($sql) as $accessRoleSecurityAction){
            $permissions[$accessRoleSecurityAction['id_security_action']][$accessRoleSecurityAction['id_access_role']] = 1;
        }
        return $permissions;
    }

    /**
     * @param int $idAccessRole
     * @return array
     */
    public function getAllPermissionsByModules($idAccessRole)
    {
    	
       $permissions = array();
        $sql = "SELECT sec.tag_module, sec.tag_action,(                    
                     SELECT case when  count(*) > 0 then  0 else 1 end
                    FROM pcs_common_security_actions as sec2
                    LEFT JOIN pcs_common_security_actions_access_roles as sec2rol
                        ON( sec2.id_action = sec2rol.id_security_action AND sec2rol.id_access_role = {$idAccessRole} )
                    WHERE sec2.tag_module = sec.tag_module AND sec2.tag_action = sec.tag_action
                    AND sec2rol.id_security_action IS NULL
                ) as allowed
                FROM pcs_common_security_actions as sec
                WHERE sec.tag_module IS NOT NULL AND sec.tag_action IS NOT NULL
                GROUP BY sec.tag_module, sec.tag_action";
       
        
        foreach( $this->getDb()->fetchAll($sql) as $row){
            $permissions[$row['tag_module']][$row['tag_action']] = $row['allowed'];
        }
        return $permissions;
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\AccessRoleCollection
     */
    protected function makeCollection(){
        return new AccessRoleCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\AccessRole
     */
    protected function makeBean($resultset){
        return AccessRoleFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param AccessRoleQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof AccessRoleQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate AccessRole
     * @param AccessRole $accessRole
     * @throws Exception
     */
    protected function validateBean($accessRole = null){
        if( !($accessRole instanceof AccessRole) ){
            $this->throwException("passed parameter isn't a AccessRole instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new AccessRoleException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new AccessRoleException($message);
        }
    }

 }