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
 * Channel
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Channel extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_channels';

    /**
     * Constants Fields
     */
    const ID_CHANNEL = 'id_channel';
    const NAME = 'name';
    const STATUS = 'status';
    const CANAL_ACL = 'canal_acl';
    const CANAL_RECL = 'canal_recl';
    const REOPEN = 'reopen';

    /**
     * @var int
     */
    private $idChannel;


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
    private $canalAcl;

    /**
     * @var string
     */
    private $canalRecl;
    
    /**
     * @var string
     */
    private $reopen;
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdChannel();
    }


    /**
     * @return int
     */
    public function getIdChannel(){
        return $this->idChannel;
    }

    /**
     * @param int $idChannel
     * @return Channel
     */
    public function setIdChannel($idChannel){
        $this->idChannel = $idChannel;
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
     * @return Channel
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
     * @return Channel
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * @return String
     */
    public function getCanalAcl(){
    	return $this->canalAcl;
    }
    
    /**
     * @param String $canalAcl
     * @return Channel
     */
    public function setCanalAcl($canalAcl){
    	$this->canalAcl = $canalAcl;
    	return $this;
    }
    

    /**
     * @return String
     */
    public function getCanalRecl(){
    	return $this->canalRecl;
    }
    
    /**
     * @param String $canalRecl
     * @return Channel
     */
    public function setCanalRecl($canalRecl){
    	$this->canalRecl = $canalRecl;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getReopen(){
    	return $this->reopen;
    }
    
    /**
     * @param String $reopen
     * @return Channel
     */
    public function setReopen($reopen){
    	$this->reopen = $reopen;
    	return $this;
    }    
    
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_channel' => $this->getIdChannel(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
        	'canal_acl' => $this->getCanalAcl(),
        	'canal_recl'=> $this->getCanalRecl(),
        	'reopen' => $this->getReopen(),
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
    
    public static $condusef = array('Condusef');
    public static $correo = array('Correo Electrónico');
    

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