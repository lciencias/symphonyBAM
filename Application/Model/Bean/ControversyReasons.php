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
 * ControversyReasons
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class ControversyReasons extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_controversy_reasons';

    /**
     * Constants Fields
     */
    const ID_CONTROVERSY_REASON = 'id_controversy_reason';
    const NAME = 'name';
    const STATUS = 'status';
    const TYPE = 'type';
    const DEBIT_TIME = 'debit_time';

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
    private $status;


    /**
     * @var string
     */
    private $type;


    /**
     * @var string
     */
    private $debitTime;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdControversyReason();
    }


    /**
     * @return int
     */
    public function getIdControversyReason(){
        return $this->idControversyReason;
    }

    /**
     * @param int $idControversyReason
     * @return ControversyReasons
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
     * @return ControversyReasons
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
     * @return ControversyReasons
     */
    public function setStatus($status){
		$this->status = $status;	
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
     * @return ControversyReasons
     */
    public function setType($type){
		$this->type = $type;	
        return $this;
    }


    /**
     * @return string
     */
    public function getDebitTime(){
        return $this->debitTime;
    }

    /**
     * @param string $debitTime
     * @return ControversyReasons
     */
    public function setDebitTime($debitTime){
		$this->debitTime = $debitTime;	
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_controversy_reason' => $this->getIdControversyReason(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'type' => $this->getType(),
            'debit_time' => $this->getDebitTime(),
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
