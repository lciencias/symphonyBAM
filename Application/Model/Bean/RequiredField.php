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
 * RequiredField
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class RequiredField extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_required_fields';

    /**
     * Constants Fields
     */
    const ID_REQUIRED_FIELD = 'id_required_field';
    const ID_CLIENT_CATEGORY = 'id_client_category';
    const ID_FIELD = 'id_field';

    /**
     * @var int
     */
    private $idRequiredField;


    /**
     * @var int
     */
    private $idClientCategory;


    /**
     * @var int
     */
    private $idField;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdRequiredField();
    }


    /**
     * @return int
     */
    public function getIdRequiredField(){
        return $this->idRequiredField;
    }

    /**
     * @param int $idRequiredField
     * @return RequiredField
     */
    public function setIdRequiredField($idRequiredField){
        $this->idRequiredField = $idRequiredField;
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
     * @return RequiredField
     */
    public function setIdClientCategory($idClientCategory){
        $this->idClientCategory = $idClientCategory;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdField(){
        return $this->idField;
    }

    /**
     * @param int $idField
     * @return RequiredField
     */
    public function setIdField($idField){
        $this->idField = $idField;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_required_field' => $this->getIdRequiredField(),
            'id_client_category' => $this->getIdClientCategory(),
            'id_field' => $this->getIdField(),
        );
        return $array;
    }

}