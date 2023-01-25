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
use Application\Model\Bean\Group;
use Application\Model\Factory\GroupFactory;
use Application\Model\Collection\GroupCollection;
use Application\Model\Exception\GroupException;
use Application\Model\Bean\Bean;
use Application\Query\GroupQuery;
use Query\Query;

/**
 *
 * GroupCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Group getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\GroupCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class GroupCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Group a la base de datos
     * @param Group $group Objeto Group
     */
    public function create($group)
    {
        $this->validateBean($group);
        try
        {
            $data = $group->toArrayFor(
                array('id_user', 'id_workweek', 'name', 'status', 'id_user_assigned_for_tickets','acl')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Group::TABLENAME, $data);
            $group->setIdGroup($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Group can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Group en la base de datos
     * @param Group $group Objeto Group
     */
    public function update($group)
    {
        $this->validateBean($group);
        try
        {
            $data = $group->toArrayFor(
                array('id_user', 'id_workweek', 'name', 'status', 'id_user_assigned_for_tickets','acl' )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Group::TABLENAME, $data, "id_group = '{$group->getIdGroup()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Group can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Group a partir de su Id
     * @param int $idGroup
     */
    public function deleteById($idGroup)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_group = ?', $idGroup));
            $this->getDb()->delete(Group::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Group can't be deleted\n", $e);
        }
    }


    /**
     * Link a Group to User
     * @param int $idGroup
     * @param int $idUser
     */
    public function linkToUser($idGroup, $idUser)
    {
        try
        {
            $this->unlinkFromUser($idGroup, $idUser);
            $data = array(
                'id_group' => $idGroup,
                'id_user' => $idUser,
            );
            $this->getDb()->insert('pcs_symphony_user_group', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link Group to User", $e);
        }
    }

    /**
     * Unlink a Group from User
     * @param int $idGroup
     * @param int $idUser
     */
    public function unlinkFromUser($idGroup, $idUser)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_group = ?', $idGroup),
                $this->getDb()->quoteInto('id_user = ?', $idUser),
            );
            $this->getDb()->delete('pcs_symphony_user_group', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Group to User", $e);
        }
    }

    /**
     * Unlink all User relations
     * @param int $idGroup
     */
    public function unlinkAllUser($idGroup)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_group = ?', $idGroup),
            );
            $this->getDb()->delete('pcs_symphony_user_group', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink Group to User", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\GroupCollection
     */
    protected function makeCollection(){
        return new GroupCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Group
     */
    protected function makeBean($resultset){
        return GroupFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param GroupQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof GroupQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Group
     * @param Group $group
     * @throws Exception
     */
    protected function validateBean($group = null){
        if( !($group instanceof Group) ){
            $this->throwException("passed parameter isn't a Group instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new GroupException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new GroupException($message);
        }
    }

 }