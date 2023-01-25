<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * Branch
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Branch extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_branches';

    /**
     * Constants Fields
     */
    const ID_BRANCH = 'id_branch';
    const ID_COUNTRY_STATE = 'id_country_state';
    const NAME = 'name';
    const STATUS = 'status';
    const ADDRESS = 'address';
    const ID_BAM = 'id_bam';
    const SCHEDULED = 'scheduled';

    /**
     * @var int
     */
    private $idBranch;


    /**
     * @var int
     */
    private $idCountryState;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $status;
    
    
    /**
     * @var string
     */
    private $address;
    
    
    /**
     * @var string
     */
    private $scheduled;
    
    /**
     * @var int
     */
    private $idBam;
    


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdBranch();
    }


    /**
     * @return int
     */
    public function getIdBranch(){
        return $this->idBranch;
    }

    /**
     * @param int $idBranch
     * @return Branch
     */
    public function setIdBranch($idBranch){
        $this->idBranch = $idBranch;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdCountryState(){
        return $this->idCountryState;
    }

    /**
     * @param int $idCountryState
     * @return Branch
     */
    public function setIdCountryState($idCountryState){
        $this->idCountryState = $idCountryState;
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
     * @return Branch
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
     * @return Branch
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
    
    
    /**
     * @return string
     */
    public function getAddress(){
        return $this->address;
    }

    /**
     * @param string $address
     * @return Branch
     */
    public function setAddress($address){
        $this->address = $address;
        return $this;
    }
    
    
    /**
     * @return string
     */
    public function getScheduled(){
        return $this->scheduled;
    }

    /**
     * @param string $address
     * @return Branch
     */
    public function setScheduled($scheduled){
        $this->scheduled = $scheduled;
        return $this;
    }
    
    
    /**
     * @return Int
     */
    public function getIdBam(){
        return $this->idBam;
    }

    /**
     * @param Int $id_bam
     * @return Branch
     */
    public function setIdBam($idBam){
        $this->idBam = $idBam;
        return $this;
    }
    

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_branch' => $this->getIdBranch(),
            'id_country_state' => $this->getIdCountryState(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'id_bam' => $this->getIdBam(),
            'address' => $this->getAddress(),
            'scheduled' => $this->getScheduled(),
        );
        return $array;
    }
    
    /**
     * 
     * @var array
     */
	public static $Status = array(
			'Active' => 1,
			'Inactive' => 2,
			);
	/**
	 * @return string
	 */
	public function getStatusName(){
		return array_search($this->getStatus(), self::$Status);
	}
	
	/**
	 * @author jlsn
	 * @return boolean
	 */
	public function isActive(){
		return $this->getStatus() == self::$Status['Active'] ? true : false;
	}
	
	/**
	 * @author jlsn
	 * @return boolean
	 */
	public function isInactive(){
		return $this->getStatus() == self::$Status['Inactive'] ? true : false;
	}
}