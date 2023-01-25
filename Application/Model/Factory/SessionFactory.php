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

use Application\Model\Bean\Session;

/**
 *
 * SessionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class SessionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Session
     */
    public static function createFromArray($fields)
    {
        $session = new Session();
        self::populate($session, $fields);

        return $session;
    }

    /**
     *
     * @static
     * @param Session session
     * @param array $fields
     */
    public static function populate($session, $fields)
    {
        if( !($session instanceof Session) ){
            static::throwException("El objecto no es un Session");
        }

        if( isset($fields['id_session']) ){
            $session->setIdSession($fields['id_session']);
        }

        if( isset($fields['id_user']) ){
            $session->setIdUser($fields['id_user']);
        }

        if( isset($fields['hash']) ){
            $session->setHash($fields['hash']);
        }

        if( isset($fields['last_request']) ){
            $session->setLastRequest($fields['last_request']);
        }
    }

    /**
     * @throws SessionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\SessionException($message);
    }

}