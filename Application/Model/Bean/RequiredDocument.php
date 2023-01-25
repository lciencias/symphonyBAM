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
 * RequiredDocument
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class RequiredDocument extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_required_documents';

    /**
     * Constants Fields
     */
    const ID_REQUIRED_DOCUMENT = 'id_required_document';
    const ID_CLIENT_CATEGORY = 'id_client_category';
    const ID_DOCUMENT = 'id_document';

    /**
     * @var int
     */
    private $idRequiredDocument;


    /**
     * @var int
     */
    private $idClientCategory;


    /**
     * @var int
     */
    private $idDocument;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdRequiredDocument();
    }


    /**
     * @return int
     */
    public function getIdRequiredDocument(){
        return $this->idRequiredDocument;
    }

    /**
     * @param int $idRequiredDocument
     * @return RequiredDocument
     */
    public function setIdRequiredDocument($idRequiredDocument){
        $this->idRequiredDocument = $idRequiredDocument;
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
     * @return RequiredDocument
     */
    public function setIdClientCategory($idClientCategory){
        $this->idClientCategory = $idClientCategory;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdDocument(){
        return $this->idDocument;
    }

    /**
     * @param int $idDocument
     * @return RequiredDocument
     */
    public function setIdDocument($idDocument){
        $this->idDocument = $idDocument;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_required_document' => $this->getIdRequiredDocument(),
            'id_client_category' => $this->getIdClientCategory(),
            'id_document' => $this->getIdDocument(),
        );
        return $array;
    }

}