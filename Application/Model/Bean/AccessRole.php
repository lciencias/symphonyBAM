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
 * AccessRole
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class AccessRole extends AbstractBean{
	/**
	 * Only in BAM
	 * @const int 
	 */
	const ADMINISTRATOR = 1;
	/**
	 * Only in BAM
	 * @const int
	 */
	const SUPERVISOR = 2;
	/**
	 * Only in BAM
	 * @const int
	 */
	const GESTOR = 3;
	/**
	 * Only in BAM
	 * @const int
	 */
	const RESOLUTOR = 4;
	/**
	 * Only in BAM
	 * @const int
	 */
	const COMPTROLLER = 5;
	/**
	 * Only in BAM
	 * @const int
	 */
	const GROUP_SUPERVISOR = 6;
	
	/**
	 * Only in BAM
	 * @const int
	 */
	const ACLARACIONES = 11;
	
	/**
	 * Only in BAM
	 * @const int
	 */
	const COMPENSACION = 13;
	
	/**
	 * Only in BAM
	 * @const int
	 */
	const JURIDICO = 14;
	
	
    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_access_roles';

    /**
     * Constants Fields
     */
    const ID_ACCESS_ROLE = 'id_access_role';
    const NAME = 'name';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idAccessRole;


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
        return $this->getIdAccessRole();
    }


    /**
     * @return int
     */
    public function getIdAccessRole(){
        return $this->idAccessRole;
    }

    /**
     * @param int $idAccessRole
     * @return AccessRole
     */
    public function setIdAccessRole($idAccessRole){
        $this->idAccessRole = $idAccessRole;
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
     * @return AccessRole
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
     * @return AccessRole
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
            'id_access_role' => $this->getIdAccessRole(),
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