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
 * TicketType
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class TicketType extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_ticket_types';

    /**
     * Constants Fields
     */
    const ID_TICKET_TYPE = 'id_ticket_type';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idTicketType;


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
        return $this->getIdTicketType();
    }


    /**
     * @return int
     */
    public function getIdTicketType(){
        return $this->idTicketType;
    }

    /**
     * @param int $idTicketType
     * @return TicketType
     */
    public function setIdTicketType($idTicketType){
        $this->idTicketType = $idTicketType;
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
     * @return TicketType
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
     * @return TicketType
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
            'id_ticket_type' => $this->getIdTicketType(),
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
     * @staticvar array
     */
    public static $TicketType = array(
        'Queja'=>2,
	'Consulta'=>3,
	'Aclaración'=>4,
	'Servicios'=>18,
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

    public static $Complaints = array(2,3,4,18);
    public static $states = array(1,2,3,4,6);
    public static $statesJur= array(1,2,3,4);
}