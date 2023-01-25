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

use Application\Model\Bean\Address;

/**
 *
 * AddressFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class AddressFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Address
     */
    public static function createFromArray($fields)
    {
        $address = new Address();
        self::populate($address, $fields);

        return $address;
    }

    /**
     *
     * @static
     * @param Address address
     * @param array $fields
     */
    public static function populate($address, $fields)
    {
        if( !($address instanceof Address) ){
            static::throwException("El objecto no es un Address");
        }

        if( isset($fields['id_address']) ){
            $address->setIdAddress($fields['id_address']);
        }

        if( isset($fields['zip_code']) ){
            $address->setZipCode($fields['zip_code']);
        }

        if( isset($fields['street']) ){
            $address->setStreet($fields['street']);
        }

        if( isset($fields['settlement']) ){
            $address->setSettlement($fields['settlement']);
        }

        if( isset($fields['district']) ){
            $address->setDistrict($fields['district']);
        }

        if( isset($fields['city']) ){
            $address->setCity($fields['city']);
        }

        if( isset($fields['state']) ){
            $address->setState($fields['state']);
        }

        if( isset($fields['country']) ){
            $address->setCountry($fields['country']);
        }
    }

    /**
     * @throws AddressException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AddressException($message);
    }

}