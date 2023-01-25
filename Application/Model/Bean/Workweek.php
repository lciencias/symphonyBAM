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
 * Workweek
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Workweek extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_workweeks';

    /**
     * Constants Fields
     */
    const ID_WORKWEEK = 'id_workweek';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idWorkweek;

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
        return $this->getIdWorkweek();
    }


    /**
     * @return int
     */
    public function getIdWorkweek(){
        return $this->idWorkweek;
    }

    /**
     * @param int $idWorkweek
     * @return Workweek
     */
    public function setIdWorkweek($idWorkweek){
        $this->idWorkweek = $idWorkweek;
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
     * @return Workweek
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
     * @return Workweek
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
            'id_workweek' => $this->getIdWorkweek(),
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