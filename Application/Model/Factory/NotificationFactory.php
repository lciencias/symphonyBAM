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

namespace Application\Model\Factory;

use Application\Model\Bean\Notification;

/**
 *
 * NotificationFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class NotificationFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Notification
     */
    public static function createFromArray($fields)
    {
        $notification = new Notification();
        self::populate($notification, $fields);

        return $notification;
    }

    /**
     *
     * @static
     * @param Notification notification
     * @param array $fields
     */
    public static function populate($notification, $fields)
    {
        if( !($notification instanceof Notification) ){
            static::throwException("El objecto no es un Notification");
        }

        if( isset($fields['id_notification']) ){
            $notification->setIdNotification($fields['id_notification']);
        }

        if( isset($fields['id_base_ticket']) ){
            $notification->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_template_email']) ){
            $notification->setIdTemplateEmail($fields['id_template_email']);
        }

        if( isset($fields['to']) ){
            $notification->setTo($fields['to']);
        }

        if( isset($fields['dispatched']) ){
            $notification->setDispatched($fields['dispatched']);
        }

        if( isset($fields['created']) ){
            $notification->setCreated($fields['created']);
        }

        if( isset($fields['cc']) ){
            $notification->setCc($fields['cc']);
        }

        if( isset($fields['bcc']) ){
            $notification->setBcc($fields['bcc']);
        }
        
        if( isset($fields['id_file']) ){
        	$notification->setIdFile($fields['id_file']);
        }
        
    }

    /**
     * @throws NotificationException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\NotificationException($message);
    }

}