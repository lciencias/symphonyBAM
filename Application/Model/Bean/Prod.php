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
	
use Application\Date\PCSDate;

/**
 *
 * Transactions
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class Prod extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'productos';

    /**
     * Constants Fields
     */
    const ID_BAM = 'id_product_bam';
    const NAME = 'name';
    const NO_TARJETA = 'no_tarjeta';

    /**
     * @var int
     */
    private $idBam;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Zend_Date
     */
    private $noTarjeta;



    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdBam();
    }

    /**
     * @return string
     */
    public function getIdBam(){
        return $this->idBam;
    }

    /**
     * @param string $idBam
     * @return Prod
     */
    public function setIdBam($idBam){
		$this->idBam = $idBam;	
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
     * @return Prod
     */
    public function setName($name){
    	$this->name = $name;
    	return $this;
    }
    
    /**
     * @return string
     */
    public function getNoTarjeta(){
    	return $this->noTarjeta;
    }
    
    /**
     * @param string $noTarjeta
     * @return Prod
     */
    public function setNoTarjeta($noTarjeta){
    	$this->noTarjeta = $noTarjeta;
    	return $this;
    }
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_bam' => $this->getIdBam(),
            'name' => $this->getName(),
            'no_tarjeta' => $this->getNoTarjeta(),
        );
        return $array;
    }
}
