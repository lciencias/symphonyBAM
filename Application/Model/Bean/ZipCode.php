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

namespace Application\Model\Bean;

/**
 *
 * ZipCode
 *
 * @category Application\Model\Bean
 * @author chente
 */
class ZipCode extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_mexico_zip_codes';

    /**
     * Constants Fields
     */
    const ID_ZIP_CODE = 'id_zip_code';
    const ZIP_CODE = 'zip_code';
    const SETTLEMENT = 'settlement';
    const SETTLEMENT_TYPE = 'settlement_type';
    const DISTRICT = 'district';
    const STATE = 'state';
    const CITY = 'city';
    const D_CP = 'd_cp';
    const ID_MEXICO_STATE = 'id_mexico_state';
    const OFFICE_CODE = 'office_code';
    const ZC_CODE = 'zc_code';
    const SETTLEMENT_TYPE_CODE = 'settlement_type_code';
    const DISTRICT_CODE = 'district_code';
    const ID_SETTLEMENT_ZIP_CODE = 'id_settlement_zip_code';
    const ZONE = 'zone';
    const CITY_CODE = 'city_code';

    /**
     * @var int
     */
    private $idZipCode;

    /**
     * @var int
     */
    private $zipCode;

    /**
     * @var string
     */
    private $settlement;

    /**
     * @var int
     */
    private $settlementType;

    /**
     * @var string
     */
    private $district;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $city;

    /**
     * @var int
     */
    private $dCp;

    /**
     * @var int
     */
    private $idMexicoState;

    /**
     * @var int
     */
    private $officeCode;

    /**
     * @var int
     */
    private $zcCode;

    /**
     * @var int
     */
    private $settlementTypeCode;

    /**
     * @var int
     */
    private $districtCode;

    /**
     * @var int
     */
    private $idSettlementZipCode;

    /**
     * @var int
     */
    private $zone;

    /**
     * @var int
     */
    private $cityCode;

    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdZipCode();
    }


    /**
     * @return int
     */
    public function getIdZipCode(){
        return $this->idZipCode;
    }

    /**
     * @param int $idZipCode
     * @return ZipCode
     */
    public function setIdZipCode($idZipCode){
        $this->idZipCode = $idZipCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getZipCode(){
        return $this->zipCode;
    }

    /**
     * @param int $zipCode
     * @return ZipCode
     */
    public function setZipCode($zipCode){
        $this->zipCode = $zipCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getSettlement(){
        return $this->settlement;
    }

    /**
     * @param string $settlement
     * @return ZipCode
     */
    public function setSettlement($settlement){
        $this->settlement = $settlement;
        return $this;
    }

    /**
     * @return int
     */
    public function getSettlementType(){
        return $this->settlementType;
    }

    /**
     * @param int $settlementType
     * @return ZipCode
     */
    public function setSettlementType($settlementType){
        $this->settlementType = $settlementType;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(){
        return $this->district;
    }

    /**
     * @param string $district
     * @return ZipCode
     */
    public function setDistrict($district){
        $this->district = $district;
        return $this;
    }

    /**
     * @return string
     */
    public function getState(){
        return $this->state;
    }

    /**
     * @param string $state
     * @return ZipCode
     */
    public function setState($state){
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity(){
        return $this->city;
    }

    /**
     * @param string $city
     * @return ZipCode
     */
    public function setCity($city){
        $this->city = $city;
        return $this;
    }

    /**
     * @return int
     */
    public function getDCp(){
        return $this->dCp;
    }

    /**
     * @param int $dCp
     * @return ZipCode
     */
    public function setDCp($dCp){
        $this->dCp = $dCp;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdMexicoState(){
        return $this->idMexicoState;
    }

    /**
     * @param int $idMexicoState
     * @return ZipCode
     */
    public function setIdMexicoState($idMexicoState){
        $this->idMexicoState = $idMexicoState;
        return $this;
    }

    /**
     * @return int
     */
    public function getOfficeCode(){
        return $this->officeCode;
    }

    /**
     * @param int $officeCode
     * @return ZipCode
     */
    public function setOfficeCode($officeCode){
        $this->officeCode = $officeCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getZcCode(){
        return $this->zcCode;
    }

    /**
     * @param int $zcCode
     * @return ZipCode
     */
    public function setZcCode($zcCode){
        $this->zcCode = $zcCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getSettlementTypeCode(){
        return $this->settlementTypeCode;
    }

    /**
     * @param int $settlementTypeCode
     * @return ZipCode
     */
    public function setSettlementTypeCode($settlementTypeCode){
        $this->settlementTypeCode = $settlementTypeCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getDistrictCode(){
        return $this->districtCode;
    }

    /**
     * @param int $districtCode
     * @return ZipCode
     */
    public function setDistrictCode($districtCode){
        $this->districtCode = $districtCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdSettlementZipCode(){
        return $this->idSettlementZipCode;
    }

    /**
     * @param int $idSettlementZipCode
     * @return ZipCode
     */
    public function setIdSettlementZipCode($idSettlementZipCode){
        $this->idSettlementZipCode = $idSettlementZipCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getZone(){
        return $this->zone;
    }

    /**
     * @param int $zone
     * @return ZipCode
     */
    public function setZone($zone){
        $this->zone = $zone;
        return $this;
    }

    /**
     * @return int
     */
    public function getCityCode(){
        return $this->cityCode;
    }

    /**
     * @param int $cityCode
     * @return ZipCode
     */
    public function setCityCode($cityCode){
        $this->cityCode = $cityCode;
        return $this;
    }

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_zip_code' => $this->getIdZipCode(),
            'zip_code' => $this->getZipCode(),
            'settlement' => $this->getSettlement(),
            'settlement_type' => $this->getSettlementType(),
            'district' => $this->getDistrict(),
            'state' => $this->getState(),
            'city' => $this->getCity(),
            'd_cp' => $this->getDCp(),
            'id_mexico_state' => $this->getIdMexicoState(),
            'office_code' => $this->getOfficeCode(),
            'zc_code' => $this->getZcCode(),
            'settlement_type_code' => $this->getSettlementTypeCode(),
            'district_code' => $this->getDistrictCode(),
            'id_settlement_zip_code' => $this->getIdSettlementZipCode(),
            'zone' => $this->getZone(),
            'city_code' => $this->getCityCode(),
        );
        return $array;
    }

}