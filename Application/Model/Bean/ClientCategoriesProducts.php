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
 * ClientCategoriesProducts
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class ClientCategoriesProducts extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_categories_products';

    /**
     * Constants Fields
     */
    const ID_CLIENT_CATEGORY_PRODUCT = 'id_client_category_product';
    const ID_CLIENT_CATEGORY = 'id_client_category';
    const ID_PRODUCT = 'id_product';

    /**
     * @var int
     */
    private $idClientCategoryProduct;


    /**
     * @var int
     */
    private $idClientCategory;


    /**
     * @var int
     */
    private $idProduct;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdClientCategoryProduct();
    }


    /**
     * @return int
     */
    public function getIdClientCategoryProduct(){
        return $this->idClientCategoryProduct;
    }

    /**
     * @param int $idClientCategoryProduct
     * @return ClientCategoriesProducts
     */
    public function setIdClientCategoryProduct($idClientCategoryProduct){
		$this->idClientCategoryProduct = $idClientCategoryProduct;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdClientCategory(){
        return $this->idClientCategory;
    }

    /**
     * @param int $idClientCategory
     * @return ClientCategoriesProducts
     */
    public function setIdClientCategory($idClientCategory){
		$this->idClientCategory = $idClientCategory;	
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
     * @return ClientCategoriesProducts
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
            'id_client_category_product' => $this->getIdClientCategoryProduct(),
            'id_client_category' => $this->getIdClientCategory(),
            'id_product' => $this->getIdProduct(),
        );
        return $array;
    }

}
