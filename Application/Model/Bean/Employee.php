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
 * Employee
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Employee extends Person{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_employees';

    /**
     * Constants Fields
     */
    const ID_EMPLOYEE = 'id_employee';
    const ID_PERSON = 'id_person';
    const ID_POSITION = 'id_position';
    const ID_LOCATION = 'id_location';
    const ID_AREA = 'id_area';
    const STATUS_EMPLOYEE = 'status_employee';
    const IS_VIP = 'is_vip';
    const ID_COMPANY = 'id_company';

    /**
     * @var int
     */
    private $idEmployee;


    /**
     * @var int
     */
    private $idPerson;


    /**
     * @var int
     */
    private $idPosition;


    /**
     * @var int
     */
    private $idLocation;


    /**
     * @var int
     */
    private $idArea;


    /**
     * @var int
     */
    private $statusEmployee;


    /**
     * @var boolean
     */
    private $isVip;

    /**
     *
     * @var int
     */
    private $idCompany;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdEmployee();
    }


    /**
     * @return int
     */
    public function getIdEmployee(){
        return $this->idEmployee;
    }

    /**
     * @param int $idEmployee
     * @return Employee
     */
    public function setIdEmployee($idEmployee){
        $this->idEmployee = $idEmployee;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdPerson(){
        return $this->idPerson;
    }

    /**
     * @param int $idPerson
     * @return Employee
     */
    public function setIdPerson($idPerson){
        $this->idPerson = $idPerson;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdPosition(){
        return $this->idPosition;
    }

    /**
     * @param int $idPosition
     * @return Employee
     */
    public function setIdPosition($idPosition){
        $this->idPosition = $idPosition;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdLocation(){
        return $this->idLocation;
    }

    /**
     * @param int $idLocation
     * @return Employee
     */
    public function setIdLocation($idLocation){
        $this->idLocation = $idLocation;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdArea(){
        return $this->idArea;
    }

    /**
     * @param int $idArea
     * @return Employee
     */
    public function setIdArea($idArea){
        $this->idArea = $idArea;
        return $this;
    }


    /**
     * @return int
     */
    public function getStatusEmployee(){
        return $this->statusEmployee;
    }

    /**
     * @param int $statusEmployee
     * @return Employee
     */
    public function setStatusEmployee($statusEmployee){
        $this->statusEmployee = $statusEmployee;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getIsVip(){
        return $this->isVip;
    }

    /**
     * @param boolean $isVip
     * @return Employee
     */
    public function setIsVip($isVip){
        $this->isVip = $isVip;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdCompany(){
        return $this->idCompany;
    }

    /**
     * @param int $idCompany
     * @return Employee
     */
    public function setIdCompany($idCompany){
        $this->idCompany = $idCompany;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_employee' => $this->getIdEmployee(),
            'id_person' => $this->getIdPerson(),
            'id_position' => $this->getIdPosition(),
            'id_location' => $this->getIdLocation(),
            'id_area' => $this->getIdArea(),
            'status_employee' => $this->getStatusEmployee(),
            'is_vip' => $this->getIsVip(),
            'id_company' => $this->getIdCompany(),
            'fullname' => $this->getFullName(),
        );
        return array_merge(parent::toArray(), $array);
    }

    /**
     * @return string
     */
    public function getStatusEmployeeName(){
        return array_search($this->getStatusEmployee(), self::$StatusEmployee);
    }

    /**
     * @staticvar array
     */
    public static $StatusEmployee = array(
        'Active' => 1,
        'Inactive' => 2,
    );

    /**
    * @staticvar array
    */
    public static $StatusEmployeeCombo = array(
        1  => 'Active' ,
        2  =>'Inactive'
    );

}