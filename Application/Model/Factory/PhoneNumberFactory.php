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

use Application\Model\Bean\PhoneNumber;

/**
 *
 * PhoneNumberFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PhoneNumberFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\PhoneNumber
     */
    public static function createFromArray($fields)
    {
        $phoneNumber = new PhoneNumber();
        self::populate($phoneNumber, $fields);

        return $phoneNumber;
    }

    /**
     *
     * @static
     * @param PhoneNumber phoneNumber
     * @param array $fields
     */
    public static function populate($phoneNumber, $fields)
    {
        if( !($phoneNumber instanceof PhoneNumber) ){
            static::throwException("El objecto no es un PhoneNumber");
        }

        if( isset($fields['id_phone_number']) ){
            $phoneNumber->setIdPhoneNumber($fields['id_phone_number']);
        }

        if( isset($fields['number']) ){
            $phoneNumber->setNumber($fields['number']);
        }

        if( isset($fields['area_code']) ){
            $phoneNumber->setAreaCode($fields['area_code']);
        }

        if( isset($fields['extension']) ){
            $phoneNumber->setExtension($fields['extension']);
        }
    }

    /**
     * @throws PhoneNumberException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PhoneNumberException($message);
    }

}