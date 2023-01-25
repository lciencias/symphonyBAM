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
 * ReasonProducts
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class ReasonProducts extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_reasons_products';

    /**
     * Constants Fields
     */
    const ID_REASON_PRODUCT = 'id_reason_product';
    const ID_REASON = 'id_reason';
    const ID_PRODUCT = 'id_product';

    /**
     * @var int
     */
    private $idReasonProduct;


    /**
     * @var int
     */
    private $idReason;


    /**
     * @var int
     */
    private $idProduct;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdReasonProduct();
    }


    /**
     * @return int
     */
    public function getIdReasonProduct(){
        return $this->idReasonProduct;
    }

    /**
     * @param int $idReasonProduct
     * @return ReasonProducts
     */
    public function setIdReasonProduct($idReasonProduct){
		$this->idReasonProduct = $idReasonProduct;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdReason(){
        return $this->idReason;
    }

    /**
     * @param int $idReason
     * @return ReasonProducts
     */
    public function setIdReason($idReason){
		$this->idReason = $idReason;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdProduct(){
        return $this->idProduct;
    }

    /**
     * @param int $idProduct
     * @return ReasonProducts
     */
    public function setIdProduct($idProduct){
		$this->idProduct = $idProduct;	
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_reason_product' => $this->getIdReasonProduct(),
            'id_reason' => $this->getIdReason(),
            'id_product' => $this->getIdProduct(),
        );
        return $array;
    }

}
