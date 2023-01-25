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
 * User
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class User extends Employee{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_users';

    /**
     * Constants Fields
     */
    const ID_USER = 'id_user';
    const ID_ACCESS_ROLE = 'id_access_role';
    const ID_EMPLOYEE = 'id_employee';
    const ID_BRANCH   = 'id_branch';
    const ID_CHANNEL  = 'id_channel';
    const USERNAME 	  = 'username';
    const PASSWORD 	  = 'password';
    const STATUS 	  = 'status';

    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idAccessRole;


    /**
     * @var int
     */
    private $idEmployee;

    /**
     * @var int
     */
    private $idBranch;
    
    
    /**
     * @var int
     */
    private $idChannel;
    
    
    
    /**
     * @var string
     */
    private $username;


    /**
     * @var string
     */
    private $password;


    /**
     * @var int
     */
    private $status;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdUser();
    }


    /**
     * @return int
     */
    public function getIdUser(){
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return User
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdAccessRole(){
        return $this->idAccessRole;
    }

    /**
     * @param int $idAccessRole
     * @return User
     */
    public function setIdAccessRole($idAccessRole){
        $this->idAccessRole = $idAccessRole;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdEmployee(){
        return $this->idEmployee;
    }

    /**
     * @param int $idEmployee
     * @return User
     */
    public function setIdEmployee($idEmployee){
        $this->idEmployee = $idEmployee;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdBranch(){
    	return $this->idBranch;
    }
    
    /**
     * @param int $idBranch
     * @return User
     */
    public function setIdbranch($idBranch){
    	$this->idBranch = $idBranch;
    	return $this;
    }
    
    
    /**
     * @return int
     */
    public function getIdChannel(){
    	return $this->idChannel;
    }
    
    /**
     * @param int $idChannel
     * @return User
     */
    public function setIdChannel($idChannel){
    	$this->idChannel = $idChannel;
    	return $this;
    }
    
    /**
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username){
        $this->username = $username;
        return $this;
    }


    /**
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password){
        $this->password = $password;
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
     * @return User
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
	/**
	 * 
	 * @return string
	 */
    public function __toString(){
    	return $this->getFullName();
    }

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_user' => $this->getIdUser(),
            'id_access_role' => $this->getIdAccessRole(),
            'id_employee' => $this->getIdEmployee(),
        	'id_branch'   => $this->getIdBranch(),
        	'id_channel'  => $this->getIdChannel(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'status' => $this->getStatus(),
        );
        return array_merge(parent::toArray(), $array);
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
    public static $StatusCombo = array(
             1  =>'Active',
             2  =>'Inactive'
    );
    /**
     * 
     * @return boolean
     */
	public function isActive(){
		return $this->getStatus() == self::$Status['Active'];
	}
	/**
	 * 
	 * @return boolean
	 */
	public function isInactive(){
		return $this->getStatus() == self::$Status['Inactive'];
	}
}