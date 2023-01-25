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
 * ClientResolution
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientResolution extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_resolutions';

    /**
     * Constants Fields
     */
    const ID_CLIENT_RESOLUTION = 'id_client_resolution';
    const NAME = 'name';
    const TYPE = 'type';
    const STATUS = 'status';
    const CODE = 'code';
    /**
     * @var int
     */
    private $idClientResolution;


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
     * @var string
     */
    private $code;
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdClientResolution();
    }


    /**
     * @return int
     */
    public function getIdClientResolution(){
        return $this->idClientResolution;
    }

    /**
     * @param int $idClientResolution
     * @return ClientResolution
     */
    public function setIdClientResolution($idClientResolution){
        $this->idClientResolution = $idClientResolution;
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
     * @return ClientResolution
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
     * @return ClientResolution
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
     * @return ClientResolution
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * @return String
     */
    public function getCode(){
    	return $this->code;
    }
    
    /**
     * @param String $code
     * @return ClientResolution
     */
    public function setCode($code){
    	$this->code = $code;
    	return $this;
    }
    
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_client_resolution' => $this->getIdClientResolution(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
        	'code' => $this->getCode(),
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
	 * 
	 * @var array 
	 */
	public static $Type = array(
			'Favorable' => 1,
			'Unfavorable' => 2,
			);
	/**
	 * 
	 * @var array
	 */
	public static $R27Resolution = array(
			'Favorable' => '501',
			'Unfavorable' => '502',
			'Pending' => '503',
			);
	/**
	 * @return string
	 */
	public function getStatusName(){
		return array_search($this->getStatus(), self::$Status);
	}
	/**
	 * @return string
	 */
	public function getTypeName(){
		return array_search($this->getType(), self::$Type);
	}
	/**
	 *
	 * @return boolean
	 */
	public function isActive(){
		return $this->getStatus() == self::$Status['Active'] ? true : false;
	}
	/**
	 *
	 * @return boolean
	 */
	public function isInactive(){
		return $this->getStatus() == self::$Status['Inactive'] ? true : false;
	}
	
	/**
	 *
	 * @return boolean
	 */
	public function isFavorable(){
		return $this->getStatus() == self::$Type['Favorable'] ? true : false;
	}
	/**
	 *
	 * @return boolean
	 */
	public function isUnfavorable(){
		return $this->getStatus() == self::$Type['Unfavorable'] ? true : false;
	}
	/**
	 * 
	 * @return array
	 * @param string $header
	 */
	public static function getTypesCombo($header = null){
		$array = array();
		if ($header)
			$array[''] = $header;
		return $array + array_flip(self::$Type);
	}
}