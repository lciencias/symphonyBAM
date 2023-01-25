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

use Application\Model\Bean\MexicoZipCode;

/**
 *
 * MexicoZipCodeFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class MexicoZipCodeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\MexicoZipCode
     */
    public static function createFromArray($fields)
    {
        $mexicoZipCode = new MexicoZipCode();
        self::populate($mexicoZipCode, $fields);

        return $mexicoZipCode;
    }

    /**
     *
     * @static
     * @param MexicoZipCode mexicoZipCode
     * @param array $fields
     */
    public static function populate($mexicoZipCode, $fields)
    {
        if( !($mexicoZipCode instanceof MexicoZipCode) ){
            static::throwException("El objecto no es un MexicoZipCode");
        }

        if( isset($fields['id_zip_code']) ){
            $mexicoZipCode->setIdZipCode($fields['id_zip_code']);
        }

        if( isset($fields['zip_code']) ){
            $mexicoZipCode->setZipCode($fields['zip_code']);
        }

        if( isset($fields['settlement']) ){
            $mexicoZipCode->setSettlement($fields['settlement']);
        }

        if( isset($fields['settlement_type']) ){
            $mexicoZipCode->setSettlementType($fields['settlement_type']);
        }

        if( isset($fields['district']) ){
            $mexicoZipCode->setDistrict($fields['district']);
        }

        if( isset($fields['state']) ){
            $mexicoZipCode->setState($fields['state']);
        }

        if( isset($fields['city']) ){
            $mexicoZipCode->setCity($fields['city']);
        }

        if( isset($fields['d_cp']) ){
            $mexicoZipCode->setDCp($fields['d_cp']);
        }

        if( isset($fields['id_mexico_state']) ){
            $mexicoZipCode->setIdMexicoState($fields['id_mexico_state']);
        }

        if( isset($fields['office_code']) ){
            $mexicoZipCode->setOfficeCode($fields['office_code']);
        }

        if( isset($fields['zc_code']) ){
            $mexicoZipCode->setZcCode($fields['zc_code']);
        }

        if( isset($fields['settlement_type_code']) ){
            $mexicoZipCode->setSettlementTypeCode($fields['settlement_type_code']);
        }

        if( isset($fields['district_code']) ){
            $mexicoZipCode->setDistrictCode($fields['district_code']);
        }

        if( isset($fields['id_settlement_zip_code']) ){
            $mexicoZipCode->setIdSettlementZipCode($fields['id_settlement_zip_code']);
        }

        if( isset($fields['zone']) ){
            $mexicoZipCode->setZone($fields['zone']);
        }

        if( isset($fields['city_code']) ){
            $mexicoZipCode->setCityCode($fields['city_code']);
        }
    }

    /**
     * @throws MexicoZipCodeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\MexicoZipCodeException($message);
    }

}