<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Factory;

use Application\Model\Bean\CountryState;

/**
 *
 * CountryStateFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class CountryStateFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\CountryState
     */
    public static function createFromArray($fields)
    {
        $countryState = new CountryState();
        self::populate($countryState, $fields);

        return $countryState;
    }

    /**
     *
     * @static
     * @param CountryState countryState
     * @param array $fields
     */
    public static function populate($countryState, $fields)
    {
        if( !($countryState instanceof CountryState) ){
            static::throwException("El objecto no es un CountryState");
        }

        if( isset($fields['id_country_state']) ){
            $countryState->setIdCountryState($fields['id_country_state']);
        }

        if( isset($fields['name']) ){
            $countryState->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $countryState->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $countryState->setStatus($fields['status']);
        }
    }

    /**
     * @throws CountryStateException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CountryStateException($message);
    }

}