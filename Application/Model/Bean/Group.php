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
 * Group
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Group extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_groups';

    /**
     * Constants Fields
     */
    const ID_GROUP = 'id_group';
    const ID_USER = 'id_user';
    const ID_WORKWEEK = 'id_workweek';
    const NAME = 'name';
    const STATUS = 'status';
    const ID_USER_ASSIGNED_FOR_TICKETS = 'id_user_assigned_for_tickets';
    const ACL = 'acl';
    /**
     * @var int
     */
    private $idGroup;


    /**
     * @var int
     */
    private $idUser;


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
     * @var int
     */
	private $idUserAssignedForTickets;

	/**
	 * @var string
	 */
	private $acl;
	
	/**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdGroup();
    }


    /**
     * @return int
     */
    public function getIdGroup(){
        return $this->idGroup;
    }

    /**
     * @param int $idGroup
     * @return Group
     */
    public function setIdGroup($idGroup){
        $this->idGroup = $idGroup;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdUser(){
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return Group
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdWorkweek(){
        return $this->idWorkweek;
    }

    /**
     * @param int $idWorkweek
     * @return Group
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
     * @return Group
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
     * @return Group
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdUserAssignedForTickets(){
    	return $this->idUserAssignedForTickets;
    }
    
    /**
     * @param int $status
     * @return Group
     */
    public function setIdUserAssignedForTickets($idUserAssignedForTickets){
    	$this->idUserAssignedForTickets = $idUserAssignedForTickets;
    	return $this;
    }
    
    /**
     * @return string
     */
    public function getAcl(){
    	return $this->acl;
    }
    
    /**
     * @param string $acl
     * @return Group
     */
    public function setAcl($acl){
    	$this->acl = $acl;
    	return $this;
    }
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_group' => $this->getIdGroup(),
            'id_user' => $this->getIdUser(),
            'id_workweek' => $this->getIdWorkweek(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
        	'id_user_assigned_for_tickets' => $this->getIdUserAssignedForTickets(),
        	'acl' => $this->getAcl(),
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