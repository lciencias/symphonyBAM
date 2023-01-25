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
 * Area
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Area extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_areas';

    /**
     * Constants Fields
     */
    const ID_AREA = 'id_area';
    const ID_COMPANY = 'id_company';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idArea;


    /**
     * @var int
     */
    private $idCompany;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $status;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdArea();
    }


    /**
     * @return int
     */
    public function getIdArea(){
        return $this->idArea;
    }

    /**
     * @param int $idArea
     * @return Area
     */
    public function setIdArea($idArea){
        $this->idArea = $idArea;
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
     * @return Area
     */
    public function setIdCompany($idCompany){
        $this->idCompany = $idCompany;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return Area
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param int $status
     * @return Area
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_area' => $this->getIdArea(),
            'id_company' => $this->getIdCompany(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getStatusName(){
        return array_search($this->getStatus(), self::$Status);
    }

    /**
     * @staticvar array
     */
    public static $Status = array(
        'Active' => 1,
        'Inactive' => 2,
    );

    /**
     * @return boolean
     */
    public function isActive(){
        return $this->getStatus() == self::$Status['Active'];
    }

    /**
     * @return boolean
     */
    public function isInactive(){
        return $this->getStatus() == self::$Status['Inactive'];
    }

}