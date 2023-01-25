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
use Application\Model\Bean\Notification;
use Application\Model\Factory\NotificationFactory;
use Application\Model\Collection\NotificationCollection;
use Application\Model\Exception\NotificationException;
use Application\Model\Bean\Bean;
use Application\Query\NotificationQuery;
use Query\Query;

/**
 *
 * NotificationCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Notification getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\NotificationCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class NotificationCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Notification a la base de datos
     * @param Notification $notification Objeto Notification
     */
    public function create($notification)
    {
        $this->validateBean($notification);
        try
        {
            $data = $notification->toArrayFor(
                array('id_base_ticket', 'id_template_email', 'to', 'dispatched', 'created', 'cc', 'bcc', 'id_file', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Notification::TABLENAME, $data);
            $notification->setIdNotification($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Notification can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Notification en la base de datos
     * @param Notification $notification Objeto Notification
     */
    public function update($notification)
    {
        $this->validateBean($notification);
        try
        {
            $data = $notification->toArrayFor(
                array('id_base_ticket', 'id_template_email', 'to', 'dispatched', 'created', 'cc', 'bcc', 'id_file',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Notification::TABLENAME, $data, "id_notification = '{$notification->getIdNotification()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Notification can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Notification a partir de su Id
     * @param int $idNotification
     */
    public function deleteById($idNotification)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_notification = ?', $idNotification));
            $this->getDb()->delete(Notification::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Notification can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\NotificationCollection
     */
    protected function makeCollection(){
        return new NotificationCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Notification
     */
    protected function makeBean($resultset){
        return NotificationFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param NotificationQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof NotificationQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Notification
     * @param Notification $notification
     * @throws Exception
     */
    protected function validateBean($notification = null){
        if( !($notification instanceof Notification) ){
            $this->throwException("passed parameter isn't a Notification instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new NotificationException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new NotificationException($message);
        }
    }

 }