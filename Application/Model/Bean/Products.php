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
 * Products
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class Products extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_products';

    /**
     * Constants Fields
     */
    const ID_PRODUCT = 'id_product';
    const NAME = 'name';
    const ID_PRODUCT_BAM = 'id_product_bam';
    const DESCRIPTION = 'description';
    const REQUIREMENTS = 'requirements';
    const COMMISSIONS = 'commissions';
    const STATUS = 'status';
    const ESPECIAL = 'especial';

    /**
     * @var int
     */
    private $idProduct;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $idProductBam;


    /**
     * @var string
     */
    private $description;


    /**
     * @var string
     */
    private $requirements;


    /**
     * @var string
     */
    private $commissions;


    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $especial;
    

    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdProduct();
    }


    /**
     * @return int
     */
    public function getIdProduct(){
        return $this->idProduct;
    }

    /**
     * @param int $idProduct
     * @return Products
     */
    public function setIdProduct($idProduct){
		$this->idProduct = $idProduct;	
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
     * @return Products
     */
    public function setName($name){
		$this->name = $name;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdProductBam(){
        return $this->idProductBam;
    }

    /**
     * @param int $idProductBam
     * @return Products
     */
    public function setIdProductBam($idProductBam){
		$this->idProductBam = $idProductBam;	
        return $this;
    }


    /**
     * @return string
     */
    public function getDescription(){
        return $this->description;
    }

    /**
     * @param string $description
     * @return Products
     */
    public function setDescription($description){
		$this->description = $description;	
        return $this;
    }


    /**
     * @return string
     */
    public function getRequirements(){
        return $this->requirements;
    }

    /**
     * @param string $requirements
     * @return Products
     */
    public function setRequirements($requirements){
		$this->requirements = $requirements;	
        return $this;
    }


    /**
     * @return string
     */
    public function getCommissions(){
        return $this->commissions;
    }

    /**
     * @param string $commissions
     * @return Products
     */
    public function setCommissions($commissions){
		$this->commissions = $commissions;	
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
     * @return Products
     */
    public function setStatus($status){
		$this->status = $status;	
        return $this;
    }

    /**
     * @return int
     */
    public function getEspecial(){
    	return $this->especial;
    }
    
    /**
     * @param int $especial
     * @return Products
     */
    public function setEspecial($especial){
    	$this->especial = $especial;
    	return $this;
    }
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_product' => $this->getIdProduct(),
            'name' => $this->getName(),
            'id_product_bam' => $this->getIdProductBam(),
            'description' => $this->getDescription(),
            'requirements' => $this->getRequirements(),
            'commissions' => $this->getCommissions(),
            'status' => $this->getStatus(),
        	'especial' => $this->getEspecial(),
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
