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
 * ControversyChargebacks
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class ControversyChargebacks extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_controversy_chargebacks';

    /**
     * Constants Fields
     */
    const ID_CONTROVERSY_CHARGEBACK = 'id_controversy_chargeback';
    const ID_CONTROVERSY_REASON = 'id_controversy_reason';
    const NAME = 'name';
    const TYPE = 'type';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idControversyChargeback;


    /**
     * @var int
     */
    private $idControversyReason;


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
        return $this->getIdControversyChargeback();
    }


    /**
     * @return int
     */
    public function getIdControversyChargeback(){
        return $this->idControversyChargeback;
    }

    /**
     * @param int $idControversyChargeback
     * @return ControversyChargebacks
     */
    public function setIdControversyChargeback($idControversyChargeback){
		$this->idControversyChargeback = $idControversyChargeback;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdControversyReason(){
        return $this->idControversyReason;
    }

    /**
     * @param int $idControversyReason
     * @return ControversyChargebacks
     */
    public function setIdControversyReason($idControversyReason){
		$this->idControversyReason = $idControversyReason;	
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
     * @return ControversyChargebacks
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
     * @return ControversyChargebacks
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
     * @return ControversyChargebacks
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
            'id_controversy_chargeback' => $this->getIdControversyChargeback(),
            'id_controversy_reason' => $this->getIdControversyReason(),
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

}
