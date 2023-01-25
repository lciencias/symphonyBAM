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
 * ClientCategory
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientCategory extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_categories';

    /**
     * Constants Fields
     */
    const ID_CLIENT_CATEGORY = 'id_client_category';
    const ID_TICKET_TYPE = 'id_ticket_type';
    const ID_GROUP = 'id_group';
    const ID_ESCALATION = 'id_escalation';
    const ID_SERVICE_LEVEL = 'id_service_level';
    const NAME = 'name';
    const ID_PARENT = 'id_parent';
    const STATUS = 'status';
    const IS_LEAF = 'is_leaf';
    const NOTE = 'note';
    const PARTIALITIES = 'partialities';
    const FINANCIAL_MOVEMENT = 'financial_movement';
    const TYPE = 'type';
    const MOVMENTS = 'movments';
    const PRODUCT  = 'product';
    const MOTIVE   = 'motive';
    const CHANNEL  = 'chanel';

    /**
     * @var int
     */
    private $idClientCategory;


    /**
     * @var int
     */
    private $idTicketType;


    /**
     * @var int
     */
    private $idGroup;


    /**
     * @var int
     */
    private $idEscalation;


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
    private $idParent;


    /**
     * @var int
     */
    private $status;


    /**
     * @var boolean
     */
    private $isLeaf;


    /**
     * @var string
     */
    private $note;
    
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
     * @var int
     */
    private $movments;

    /**
     * @var string
     */
    private $product; 
    
    /**
     * @var string
     */
    private $motive;
    
    /**
     * @var string
     */
    private $channel;
    
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdClientCategory();
    }


    /**
     * @return int
     */
    public function getIdClientCategory(){
        return $this->idClientCategory;
    }

    /**
     * @param int $idClientCategory
     * @return ClientCategory
     */
    public function setIdClientCategory($idClientCategory){
        $this->idClientCategory = $idClientCategory;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTicketType(){
        return $this->idTicketType;
    }

    /**
     * @param int $idTicketType
     * @return ClientCategory
     */
    public function setIdTicketType($idTicketType){
        $this->idTicketType = $idTicketType;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdGroup(){
        return $this->idGroup;
    }

    /**
     * @param int $idGroup
     * @return ClientCategory
     */
    public function setIdGroup($idGroup){
        $this->idGroup = $idGroup;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdEscalation(){
        return $this->idEscalation;
    }

    /**
     * @param int $idEscalation
     * @return ClientCategory
     */
    public function setIdEscalation($idEscalation){
        $this->idEscalation = $idEscalation;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdServiceLevel(){
        return $this->idServiceLevel;
    }

    /**
     * @param int $idServiceLevel
     * @return ClientCategory
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
     * @return ClientCategory
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdParent(){
        return $this->idParent;
    }

    /**
     * @param int $idParent
     * @return ClientCategory
     */
    public function setIdParent($idParent){
        $this->idParent = $idParent;
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
     * @return ClientCategory
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getIsLeaf(){
        return $this->isLeaf;
    }

    /**
     * @param boolean $isLeaf
     * @return ClientCategory
     */
    public function setIsLeaf($isLeaf){
        $this->isLeaf = $isLeaf;
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
     * @return ClientCategory
     */
    public function setNote($note){
        $this->note = $note;
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
     * @return String
     */
    public function getProduct(){
    	return $this->product;
    }
    
    /**
     * @param string $product
     * @return Reasons
     */
    public function setProduct($product){
    	$this->product= $product;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getMotive(){
    	return $this->motive;
    }
    
    /**
     * @param string $motive
     * @return Reasons
     */
    public function setMotive($motive){
    	$this->motive= $motive;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getChannel(){
    	return $this->channel;
    }
    
    /**
     * @param string $channel
     * @return Reasons
     */
    public function setChannel($channel){
    	$this->channel= $channel;
    	return $this;
    }
        
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_client_category' => $this->getIdClientCategory(),
            'id_ticket_type' => $this->getIdTicketType(),
            'id_group' => $this->getIdGroup(),
            'id_escalation' => $this->getIdEscalation(),
            'id_service_level' => $this->getIdServiceLevel(),
            'name' => $this->getName(),
            'id_parent' => $this->getIdParent(),
            'status' => $this->getStatus(),
            'is_leaf' => $this->getIsLeaf(),
            'note' => $this->getNote(),
            'partialities' => $this->getPartialities(),
        	'financial_movement' => $this->getFinancialMovement(),
        	'type' => $this->getType(),
        	'movments' => $this->getMovments(),
       		'product' => $this->getProduct(),
			'motive'  => $this->getMotive(),
        	'chanel'  => $this->getChannel(),        		
        );
        return $array;
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