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
 * Impact
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Impact extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_impacts';

    /**
     * Constants Fields
     */
    const ID_IMPACT = 'id_impact';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idImpact;


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
        return $this->getIdImpact();
    }


    /**
     * @return int
     */
    public function getIdImpact(){
        return $this->idImpact;
    }

    /**
     * @param int $idImpact
     * @return Impact
     */
    public function setIdImpact($idImpact){
        $this->idImpact = $idImpact;
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
     * @return Impact
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
     * @return Impact
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
            'id_impact' => $this->getIdImpact(),
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