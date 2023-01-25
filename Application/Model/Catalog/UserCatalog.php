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
use Application\Model\Bean\User;
use Application\Model\Factory\UserFactory;
use Application\Model\Collection\UserCollection;
use Application\Model\Exception\UserException;
use Application\Model\Bean\Bean;
use Application\Query\UserQuery;
use Query\Query;

/**
 *
 * UserCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\User getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\UserCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class UserCatalog extends EmployeeCatalog{

    /**
     * Metodo para agregar un User a la base de datos
     * @param User $user Objeto User
     */
    public function create($user)
    {
        $this->validateBean($user);
        try
        {
            if( !$user->getIdEmployee() ){
              parent::create($user);
            }

            $data = $user->toArrayFor(
                array('id_access_role', 'id_employee', 'username', 'password', 'status', 'id_branch', 'id_channel',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
           // die(print_r($data));
            $this->getDb()->insert(User::TABLENAME, $data);
            $user->setIdUser($this->getDb()->lastInsertId());


        }
        catch(\Exception $e)
        {
            $this->throwException("The User can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un User en la base de datos
     * @param User $user Objeto User
     */
    public function update($user)
    {
        $this->validateBean($user);
        try
        {
            $data = $user->toArrayFor(
                array('id_access_role', 'id_employee', 'username', 'password', 'status', 'id_branch', 'id_channel', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            
            $this->getDb()->update(User::TABLENAME, $data, "id_user = '{$user->getIdUser()}'");
            parent::update($user);
        }
        catch(\Exception $e)
        {
            $this->throwException("The User can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un User a partir de su Id
     * @param int $idUser
     */
    public function deleteById($idUser)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_user = ?', $idUser));
            $this->getDb()->delete(User::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The User can't be deleted\n", $e);
        }
    }


    /**
     * Link a User to Group
     * @param int $idUser
     * @param int $idGroup
     */
    public function linkToGroup($idUser, $idGroup)
    {
        try
        {
            $this->unlinkFromGroup($idUser, $idGroup);
            $data = array(
                'id_user' => $idUser,
                'id_group' => $idGroup,
            );
            $this->getDb()->insert('pcs_symphony_user_group', $data);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't link User to Group", $e);
        }
    }

    /**
     * Unlink a User from Group
     * @param int $idUser
     * @param int $idGroup
     */
    public function unlinkFromGroup($idUser, $idGroup)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_user = ?', $idUser),
                $this->getDb()->quoteInto('id_group = ?', $idGroup),
            );
            $this->getDb()->delete('pcs_symphony_user_group', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink User to Group", $e);
        }
    }

    /**
     * Unlink all Group relations
     * @param int $idUser
     */
    public function unlinkAllGroup($idUser)
    {
        try
        {
            $where = array(
                $this->getDb()->quoteInto('id_user = ?', $idUser),
            );
            $this->getDb()->delete('pcs_symphony_user_group', $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("Can't unlink User to Group", $e);
        }
    }

    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\UserCollection
     */
    protected function makeCollection(){
        return new UserCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\User
     */
    protected function makeBean($resultset){
        return UserFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param UserQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof UserQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate User
     * @param User $user
     * @throws Exception
     */
    protected function validateBean($user = null){
        if( !($user instanceof User) ){
            $this->throwException("passed parameter isn't a User instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new UserException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new UserException($message);
        }
    }

 }