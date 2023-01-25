<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Bean;

/**
 *
 * Reasons
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class Reasons extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_reasons';

    /**
     * Constants Fields
     */
    const ID_REASON = 'id_reason';
    const NAME = 'name';
    const STATUS = 'status';
    const PARTIALITIES = 'partialities';
    const FINANCIAL_MOVEMENT = 'financial_movement';
    const TYPE = 'type';
    const SUBTYPE = 'subtype';
    const MOVMENTS = 'movments';
    /**
     * @var int
     */
    private $idReason;


    /**
     * @var string
     */
    private $name;
    
    /**
     * @var int
     */
    private $status;
    
    /**
     * @var int
     */
    private $partialities;


    /**
     * @var string
     */
    private $financialMovement;
    

    /**
     * @var string
     */
    private $type;
    
    /**
     * @var string
     */
    private $subType;
    
    /**
     * @var int
     */
    private $movments;
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdReason();
    }


    /**
     * @return int
     */
    public function getIdReason(){
        return $this->idReason;
    }

    /**
     * @param int $idReason
     * @return Reasons
     */
    public function setIdReason($idReason){
		$this->idReason = $idReason;	
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
     * @return Reasons
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
     * @return Reasons
     */
    public function setStatus($status){
		$this->status = $status;	
        return $this;
    }
    
     /**
     * @return int
     */
    public function getPartialities(){
        return $this->partialities;
    }

    /**
     * @param int $status
     * @return Reasons
     */
    public function setPartialities($partialities){
		$this->partialities = $partialities;	
        return $this;
    }

    /**
     * @return string
     */
    public function getFinancialMovement(){
    	return $this->financialMovement;
    }
    
    /**
     * @param string $financialMovement
     * @return Reasons
     */
    public function setFinancialMovement($financialMovement){
    	$this->financialMovement = $financialMovement;
    	return $this;
    }

    /**
     * @return string
     */
    public function getType(){
    	return $this->type;
    }
    
    /**
     * @param string $type
     * @return Reasons
     */
    public function setType($type){
    	$this->type = $type;
    	return $this;
    }

    /**
     * @return string
     */
    public function getSubType(){
    	return $this->subType;
    }
    
    /**
     * @param string $subType
     * @return Reasons
     */
    public function setSubType($subType){
    	$this->subType = $subType;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getMovments(){
    	return $this->movments;
    }
    
    /**
     * @param string $movments
     * @return Reasons
     */
    public function setMovments($movments){
    	$this->movments = $movments;
    	return $this;
    }
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_reason' => $this->getIdReason(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'partialities' => $this->getPartialities(),
        	'financial_movement' => $this->getFinancialMovement(),
        	'type' => $this->getType(),
        	'subtype' => $this->getSubType(),
        	'movments' => $this->getMovments(),
        );
        return $array;
    }
    
    /**
     * @staticvar array
     */
    public static $subtypes = array(
        'Personal' => 1,
        'Sucursal' => 2,
        'Producto' => 3,
        'No. movimientos' => 4,
    );
    
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
