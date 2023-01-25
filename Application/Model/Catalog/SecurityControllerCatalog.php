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
use Application\Model\Bean\SecurityController;
use Application\Model\Factory\SecurityControllerFactory;
use Application\Model\Collection\SecurityControllerCollection;
use Application\Model\Exception\SecurityControllerException;
use Application\Model\Bean\Bean;
use Application\Query\SecurityControllerQuery;
use Query\Query;

/**
 *
 * SecurityControllerCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\SecurityController getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\SecurityControllerCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class SecurityControllerCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un SecurityController a la base de datos
     * @param SecurityController $securityController Objeto SecurityController
     */
    public function create($securityController)
    {
        $this->validateBean($securityController);
        try
        {
            $data = $securityController->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(SecurityController::TABLENAME, $data);
            $securityController->setIdController($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityController can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un SecurityController en la base de datos
     * @param SecurityController $securityController Objeto SecurityController
     */
    public function update($securityController)
    {
        $this->validateBean($securityController);
        try
        {
            $data = $securityController->toArrayFor(
                array('name', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(SecurityController::TABLENAME, $data, "id_controller = '{$securityController->getIdController()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityController can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un SecurityController a partir de su Id
     * @param int $idController
     */
    public function deleteById($idController)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_controller = ?', $idController));
            $this->getDb()->delete(SecurityController::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The SecurityController can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\SecurityControllerCollection
     */
    protected function makeCollection(){
        return new SecurityControllerCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\SecurityController
     */
    protected function makeBean($resultset){
        return SecurityControllerFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param SecurityControllerQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof SecurityControllerQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate SecurityController
     * @param SecurityController $securityController
     * @throws Exception
     */
    protected function validateBean($securityController = null){
        if( !($securityController instanceof SecurityController) ){
            $this->throwException("passed parameter isn't a SecurityController instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new SecurityControllerException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new SecurityControllerException($message);
        }
    }

 }