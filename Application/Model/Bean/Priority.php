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
 * Priority
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Priority extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_priorities';

    /**
     * Constants Fields
     */
    const ID_PRIORITY = 'id_priority';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idPriority;


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
        return $this->getIdPriority();
    }


    /**
     * @return int
     */
    public function getIdPriority(){
        return $this->idPriority;
    }

    /**
     * @param int $idPriority
     * @return Priority
     */
    public function setIdPriority($idPriority){
        $this->idPriority = $idPriority;
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
     * @return Priority
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
     * @return Priority
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
            'id_priority' => $this->getIdPriority(),
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