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
 * Category
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Category extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_categories';

    /**
     * Constants Fields
     */
    const ID_CATEGORY = 'id_category';
    const ID_COMPANY = 'id_company';
    const ID_GROUP = 'id_group';
    const ID_ESCALATION = 'id_escalation';
    const ID_SERVICE_LEVEL = 'id_service_level';
    const ID_PARENT = 'id_parent';
    const NAME = 'name';
    const STATUS = 'status';
    const IS_LEAF = 'is_leaf';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idCategory;


    /**
     * @var int
     */
    private $idCompany;


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
     * @var int
     */
    private $idParent;


    /**
     * @var string
     */
    private $name;


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
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdCategory();
    }


    /**
     * @return int
     */
    public function getIdCategory(){
        return $this->idCategory;
    }

    /**
     * @param int $idCategory
     * @return Category
     */
    public function setIdCategory($idCategory){
        $this->idCategory = $idCategory;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdCompany(){
        return $this->idCompany;
    }

    /**
     * @param int $idCompany
     * @return Category
     */
    public function setIdCompany($idCompany){
        $this->idCompany = $idCompany;
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
     * @return Category
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
     * @return Category
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
     * @return Category
     */
    public function setIdServiceLevel($idServiceLevel){
        $this->idServiceLevel = $idServiceLevel;
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
     * @return Category
     */
    public function setIdParent($idParent){
        $this->idParent = $idParent;
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
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @return Category
     */
    public function setNote($note){
        $this->note = $note;
        return $this;
    }

    /**
     * 
     * @return string
     */
	public function __toString(){
		return $this->getName();
	}
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_category' => $this->getIdCategory(),
            'id_company' => $this->getIdCompany(),
            'id_group' => $this->getIdGroup(),
            'id_escalation' => $this->getIdEscalation(),
            'id_service_level' => $this->getIdServiceLevel(),
            'id_parent' => $this->getIdParent(),
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'is_leaf' => $this->getIsLeaf(),
            'note' => $this->getNote(),
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