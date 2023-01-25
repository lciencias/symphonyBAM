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
 * ServiceLevel
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
use PHPeriod\Duration;

class ServiceLevel extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_service_levels';

    /**
     * Constants Fields
     */
    const ID_SERVICE_LEVEL = 'id_service_level';
    const NAME = 'name';
    const RESOLUTION_TIME = 'resolution_time';
    const RESPONSE_TIME = 'response_time';
    const NOTE = 'note';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idServiceLevel;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $resolutionTime;


    /**
     * @var int
     */
    private $responseTime;


    /**
     * @var string
     */
    private $note;


    /**
     * @var int
     */
    private $status;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdServiceLevel();
    }


    /**
     * @return int
     */
    public function getIdServiceLevel(){
        return $this->idServiceLevel;
    }

    /**
     * @param int $idServiceLevel
     * @return ServiceLevel
     */
    public function setIdServiceLevel($idServiceLevel){
        $this->idServiceLevel = $idServiceLevel;
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
     * @return ServiceLevel
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getResolutionTime(){
        return $this->resolutionTime;
    }

    /**
     * @return Duration
     */
    public function getResolutionDuration(){
        return new Duration($this->resolutionTime * 60);
    }


    /**
     * @param int $resolutionTime
     * @return ServiceLevel
     */
    public function setResolutionTime($resolutionTime){
        $this->resolutionTime = $resolutionTime;
        return $this;
    }

    /**
     *
     * @return number
     */
    public function getServiceTime(){
        return ( $this->getResponseTime() + $this->getResolutionTime() ) * 60;
    }

    /**
     *
     * @return \PHPeriod\Duration
     */
    public function getDuration(){
        return new Duration($this->getServiceTime());
    }

    /**
     * @return int
     */
    public function getResponseTime(){
        return $this->responseTime;
    }

    /**
     * @return Duration
     */
    public function getResponseDuration(){
        return new Duration($this->responseTime * 60);
    }

    /**
     * @param int $responseTime
     * @return ServiceLevel
     */
    public function setResponseTime($responseTime){
        $this->responseTime = $responseTime;
        return $this;
    }


    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return ServiceLevel
     */
    public function setNote($note){
        $this->note = $note;
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
     * @return ServiceLevel
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
            'id_service_level' => $this->getIdServiceLevel(),
            'name' => $this->getName(),
            'resolution_time' => $this->getResolutionTime(),
        	'resolution_time_days' => $this->getResolutionTimeDays(),
            'resolution_time_hour' => $this->getResolutionTimeHours() ,
            'resolution_time_minute' => $this->getResolutionTimeMinutes(),
            'response_time' => $this->getResponseTime(),
        	'response_time_days' => $this->getResponseTimeDays(),
            'response_time_hour' => $this->getResponseTimeHours(),
            'response_time_minute' => $this->getResponseTimeMinutes(),
            'note' => $this->getNote(),
            'status' => $this->getStatus(),
        );
        return $array;
    }

    public function calculateHours(){
    	return floor($this->getResponseTime() / 60);
    }
    
    
    /**
     * @return number
     */
    public function getResponseTimeDays(){
    	return floor($this->calculateHours() / 24);
    }
    
    /**
     * @return number
     */
    
    public function getResponseTimeHours(){
        return $this->calculateHours() - ($this->getResponseTimeDays() * 24);
    }

    /**
     * @return number
     */
    public function getResponseTimeMinutes(){
        return $this->getResponseTime() - ($this->calculateHours() * 60);
    }

    /**
     *
     * @return string
     */
    public function getFormatedResponseTime(){
        return str_pad($this->getResponseTimeDays(), 2, '0', STR_PAD_LEFT). ":" . str_pad($this->getResponseTimeHours(), 2, '0', STR_PAD_LEFT). ":" . str_pad($this->getResponseTimeMinutes(), 2, '0', STR_PAD_LEFT);
    }

    /**
     *
     * @return string
     */
    public function getFormatedResolutionTime(){
        return str_pad($this->getResolutionTimeDays(), 2, '0', STR_PAD_LEFT). ":" . str_pad($this->getResolutionTimeHours(), 2, '0', STR_PAD_LEFT). ":" . str_pad($this->getResolutionTimeMinutes(), 2, '0', STR_PAD_LEFT);
    }

    /**
     * @return number
     */
    
    public function calculateResolutionHours(){
    	return floor($this->getResolutionTime() / 60);
    }
    
   /**
     * @return number
     */
    public function getResolutionTimeDays(){
    	return floor($this->calculateResolutionHours() / 24);
    }
    
    /**
     * @return number
     */
    public function getResolutionTimeHours(){
        return $this->calculateResolutionHours() - ($this->getResolutionTimeDays() * 24);
    }

    /**
     * @return number
     */
    public function getResolutionTimeMinutes(){
        return $this->getResolutionTime() - ($this->calculateResolutionHours() * 60);
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