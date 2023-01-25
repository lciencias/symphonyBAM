<?php
/**
 * Bender
 *
 * Example Project created by Bender Code Generator
 *
 * @copyright Copyright (c) 2012 Bender (https://github.com/chentepixtol/Bender2)
 * @author    chente, $LastChangedBy$
 * @version   1
 */

namespace Application\Model\Factory;

use Application\Model\Bean\ZipCode;

/**
 *
 * ZipCodeFactory
 *
 * @category Application\Model\Factory
 * @author chente
 */
class ZipCodeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ZipCode
     */
    public static function createFromArray($fields)
    {
        $zipCode = new ZipCode();
        self::populate($zipCode, $fields);

        return $zipCode;
    }

    /**
     *
     * @static
     * @param ZipCode zipCode
     * @param array $fields
     */
    public static function populate($zipCode, $fields)
    {
        if( !($zipCode instanceof ZipCode) ){
            static::throwException("El objecto no es un ZipCode");
        }

        if( isset($fields['id_zip_code']) ){
            $zipCode->setIdZipCode($fields['id_zip_code']);
        }

        if( isset($fields['zip_code']) ){
            $zipCode->setZipCode($fields['zip_code']);
        }

        if( isset($fields['settlement']) ){
            $zipCode->setSettlement($fields['settlement']);
        }

        if( isset($fields['settlement_type']) ){
            $zipCode->setSettlementType($fields['settlement_type']);
        }

        if( isset($fields['district']) ){
            $zipCode->setDistrict($fields['district']);
        }

        if( isset($fields['state']) ){
            $zipCode->setState($fields['state']);
        }

        if( isset($fields['city']) ){
            $zipCode->setCity($fields['city']);
        }

        if( isset($fields['d_cp']) ){
            $zipCode->setDCp($fields['d_cp']);
        }

        if( isset($fields['id_mexico_state']) ){
            $zipCode->setIdMexicoState($fields['id_mexico_state']);
        }

        if( isset($fields['office_code']) ){
            $zipCode->setOfficeCode($fields['office_code']);
        }

        if( isset($fields['zc_code']) ){
            $zipCode->setZcCode($fields['zc_code']);
        }

        if( isset($fields['settlement_type_code']) ){
            $zipCode->setSettlementTypeCode($fields['settlement_type_code']);
        }

        if( isset($fields['district_code']) ){
            $zipCode->setDistrictCode($fields['district_code']);
        }

        if( isset($fields['id_settlement_zip_code']) ){
            $zipCode->setIdSettlementZipCode($fields['id_settlement_zip_code']);
        }

        if( isset($fields['zone']) ){
            $zipCode->setZone($fields['zone']);
        }

        if( isset($fields['city_code']) ){
            $zipCode->setCityCode($fields['city_code']);
        }
    }

    /**
     * @throws ZipCodeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ZipCodeException($message);
    }

}