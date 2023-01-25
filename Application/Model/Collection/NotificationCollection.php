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

namespace Application\Model\Collection;

use Application\Model\Bean\Notification;

/**
 *
 * NotificationCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Notification current()
 * @method \Application\Model\Bean\Notification read()
 * @method \Application\Model\Bean\Notification getOne()
 * @method \Application\Model\Bean\Notification getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\NotificationCollection intersect() intersect(\Application\Model\Collection\NotificationCollection $collection)
 * @method \Application\Model\Collection\NotificationCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\NotificationCollection merge() merge(\Application\Model\Collection\NotificationCollection $collection)
 * @method \Application\Model\Collection\NotificationCollection diff() diff(\Application\Model\Collection\NotificationCollection $collection)
 * @method \Application\Model\Collection\NotificationCollection copy()
 */
class NotificationCollection extends Collection{

    /**
     *
     * @param Notification $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Notification) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Notification");
        }
    }


}