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
 * PhoneNumber
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class PhoneNumber extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_phone_numbers';

    /**
     * Constants Fields
     */
    const ID_PHONE_NUMBER = 'id_phone_number';
    const NUMBER = 'number';
    const AREA_CODE = 'area_code';
    const EXTENSION = 'extension';

    /**
     * @var int
     */
    private $idPhoneNumber;


    /**
     * @var string
     */
    private $number;


    /**
     * @var string
     */
    private $areaCode;


    /**
     * @var string
     */
    private $extension;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdPhoneNumber();
    }


    /**
     * @return int
     */
    public function getIdPhoneNumber(){
        return $this->idPhoneNumber;
    }

    /**
     * @param int $idPhoneNumber
     * @return PhoneNumber
     */
    public function setIdPhoneNumber($idPhoneNumber){
        $this->idPhoneNumber = $idPhoneNumber;
        return $this;
    }


    /**
     * @return string
     */
    public function getNumber(){
        return $this->number;
    }

    /**
     * @param string $number
     * @return PhoneNumber
     */
    public function setNumber($number){
        $this->number = $number;
        return $this;
    }


    /**
     * @return string
     */
    public function getAreaCode(){
        return $this->areaCode;
    }

    /**
     * @param string $areaCode
     * @return PhoneNumber
     */
    public function setAreaCode($areaCode){
        $this->areaCode = $areaCode;
        return $this;
    }


    /**
     * @return string
     */
    public function getExtension(){
        return $this->extension;
    }

    /**
     * @param string $extension
     * @return PhoneNumber
     */
    public function setExtension($extension){
        $this->extension = $extension;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_phone_number' => $this->getIdPhoneNumber(),
            'number' => $this->getNumber(),
            'area_code' => $this->getAreaCode(),
            'extension' => $this->getExtension(),
        );
        return $array;
    }

    /**
     *
     * @return string
     */
    public function getFullNumber(){
        $num = '';
        if( $this->getAreaCode() ){
            $num .= "({$this->getAreaCode()}) ";
        }
        $num .= $this->getNumber();
        if( $this->getExtension() ){
            $num .= " ext. ".$this->getExtension();
        }
        return $num;
    }

}