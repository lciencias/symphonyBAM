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
 * ClientCategoryResolution
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientCategoryResolution extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_categories_resolutions';

    /**
     * Constants Fields
     */
    const ID_CLIENT_CATEGORY_RESOLUTION = 'id_client_category_resolution';
    const ID_CLIENT_RESOLUTION = 'id_client_resolution';
    const ID_CLIENT_CATEGORY = 'id_client_category';

    /**
     * @var int
     */
    private $idClientCategoryResolution;


    /**
     * @var int
     */
    private $idClientResolution;


    /**
     * @var int
     */
    private $idClientCategory;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdClientCategoryResolution();
    }


    /**
     * @return int
     */
    public function getIdClientCategoryResolution(){
        return $this->idClientCategoryResolution;
    }

    /**
     * @param int $idClientCategoryResolution
     * @return ClientCategoryResolution
     */
    public function setIdClientCategoryResolution($idClientCategoryResolution){
        $this->idClientCategoryResolution = $idClientCategoryResolution;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdClientResolution(){
        return $this->idClientResolution;
    }

    /**
     * @param int $idClientResolution
     * @return ClientCategoryResolution
     */
    public function setIdClientResolution($idClientResolution){
        $this->idClientResolution = $idClientResolution;
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
     * @return ClientCategoryResolution
     */
    public function setIdClientCategory($idClientCategory){
        $this->idClientCategory = $idClientCategory;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_client_category_resolution' => $this->getIdClientCategoryResolution(),
            'id_client_resolution' => $this->getIdClientResolution(),
            'id_client_category' => $this->getIdClientCategory(),
        );
        return $array;
    }

}