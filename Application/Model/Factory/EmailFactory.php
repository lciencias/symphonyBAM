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

use Application\Model\Bean\Email;

/**
 *
 * EmailFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EmailFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Email
     */
    public static function createFromArray($fields)
    {
        $email = new Email();
        self::populate($email, $fields);

        return $email;
    }

    /**
     *
     * @static
     * @param Email email
     * @param array $fields
     */
    public static function populate($email, $fields)
    {
        if( !($email instanceof Email) ){
            static::throwException("El objecto no es un Email");
        }

        if( isset($fields['id_email']) ){
            $email->setIdEmail($fields['id_email']);
        }

        if( isset($fields['email']) ){
            $email->setEmail($fields['email']);
        }
    }

    /**
     * @throws EmailException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EmailException($message);
    }

}