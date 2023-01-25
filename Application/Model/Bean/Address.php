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

namespace Application\Model\Bean;

/**
 *
 * Address
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Address extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_addresses';

    /**
     * Constants Fields
     */
    const ID_ADDRESS = 'id_address';
    const ZIP_CODE = 'zip_code';
    const STREET = 'street';
    const SETTLEMENT = 'settlement';
    const DISTRICT = 'district';
    const CITY = 'city';
    const STATE = 'state';
    const COUNTRY = 'country';

    /**
     * @var int
     */
    private $idAddress;


    /**
     * @var string
     */
    private $zipCode;


    /**
     * @var string
     */
    private $street;


    /**
     * @var string
     */
    private $settlement;


    /**
     * @var string
     */
    private $district;


    /**
     * @var string
     */
    private $city;


    /**
     * @var string
     */
    private $state;


    /**
     * @var string
     */
    private $country;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAddress();
    }


    /**
     * @return int
     */
    public function getIdAddress(){
        return $this->idAddress;
    }

    /**
     * @param int $idAddress
     * @return Address
     */
    public function setIdAddress($idAddress){
        $this->idAddress = $idAddress;
        return $this;
    }


    /**
     * @return string
     */
    public function getZipCode(){
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     * @return Address
     */
    public function setZipCode($zipCode){
        $this->zipCode = $zipCode;
        return $this;
    }


    /**
     * @return string
     */
    public function getStreet(){
        return $this->street;
    }

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet($street){
        $this->street = $street;
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
     * @return Address
     */
    public function setSettlement($settlement){
        $this->settlement = $settlement;
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
     * @return Address
     */
    public function setDistrict($district){
        $this->district = $district;
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
     * @return Address
     */
    public function setCity($city){
        $this->city = $city;
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
     * @return Address
     */
    public function setState($state){
        $this->state = $state;
        return $this;
    }


    /**
     * @return string
     */
    public function getCountry(){
        return $this->country;
    }

    /**
     * @param string $country
     * @return Address
     */
    public function setCountry($country){
        $this->country = $country;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_address' => $this->getIdAddress(),
            'zip_code' => $this->getZipCode(),
            'street' => $this->getStreet(),
            'settlement' => $this->getSettlement(),
            'district' => $this->getDistrict(),
            'city' => $this->getCity(),
            'state' => $this->getState(),
            'country' => $this->getCountry(),
        );
        return $array;
    }

}