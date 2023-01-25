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
 * Resolution
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Resolution extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_resolutions';

    /**
     * Constants Fields
     */
    const ID_RESOLUTION = 'id_resolution';
    const NAME = 'name';
    const TYPE = 'type';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idResolution;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $type;


    /**
     * @var int
     */
    private $status;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdResolution();
    }


    /**
     * @return int
     */
    public function getIdResolution(){
        return $this->idResolution;
    }

    /**
     * @param int $idResolution
     * @return Resolution
     */
    public function setIdResolution($idResolution){
        $this->idResolution = $idResolution;
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
     * @return Resolution
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param int $type
     * @return Resolution
     */
    public function setType($type){
        $this->type = $type;
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
     * @return Resolution
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
            'id_resolution' => $this->getIdResolution(),
            'name' => $this->getName(),
            'type' => $this->getType(),
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

    /**
     * @staticvar array
     */
    public static $Types = array(
        'Fixed' => 1,
        'Duplicate' => 2,
        'Wontfix' => 3,
        'Worksforme' => 4,
        'Invalid' => 5,
    );

    /**
     * @return string
     */
    public function getTypeName(){
        return array_search($this->getType(), self::$Types);
    }

}