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
 * Customize
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Customize extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_customize';

    /**
     * Constants Fields
     */
    const ID_PCS_COMMON_CUSTOMIZE = 'id_pcs_common_customize';
    const ID_COMPANY = 'id_company';
    const LOGO = 'logo';
    const BACKGROUND_COLOR = 'background_color';
    const FORWARD_COLOR = 'forward_color';
    const FONT_SIZE = 'font_size';

    /**
     * @var int
     */
    private $idPcsCommonCustomize;


    /**
     * @var int
     */
    private $idCompany;


    /**
     * @var string
     */
    private $logo;


    /**
     * @var string
     */
    private $backgroundColor;


    /**
     * @var string
     */
    private $forwardColor;


    /**
     * @var string
     */
    private $fontSize;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdPcsCommonCustomize();
    }


    /**
     * @return int
     */
    public function getIdPcsCommonCustomize(){
        return $this->idPcsCommonCustomize;
    }

    /**
     * @param int $idPcsCommonCustomize
     * @return Customize
     */
    public function setIdPcsCommonCustomize($idPcsCommonCustomize){
        $this->idPcsCommonCustomize = $idPcsCommonCustomize;
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
     * @return Customize
     */
    public function setIdCompany($idCompany){
        $this->idCompany = $idCompany;
        return $this;
    }


    /**
     * @return string
     */
    public function getLogo(){
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return Customize
     */
    public function setLogo($logo){
        $this->logo = $logo;
        return $this;
    }


    /**
     * @return string
     */
    public function getBackgroundColor(){
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor
     * @return Customize
     */
    public function setBackgroundColor($backgroundColor){
        $this->backgroundColor = $backgroundColor;
        return $this;
    }


    /**
     * @return string
     */
    public function getForwardColor(){
        return $this->forwardColor;
    }

    /**
     * @param string $forwardColor
     * @return Customize
     */
    public function setForwardColor($forwardColor){
        $this->forwardColor = $forwardColor;
        return $this;
    }


    /**
     * @return string
     */
    public function getFontSize(){
        return $this->fontSize;
    }

    /**
     * @param string $fontSize
     * @return Customize
     */
    public function setFontSize($fontSize){
        $this->fontSize = $fontSize;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_pcs_common_customize' => $this->getIdPcsCommonCustomize(),
            'id_company' => $this->getIdCompany(),
            'logo' => $this->getLogo(),
            'background_color' => $this->getBackgroundColor(),
            'forward_color' => $this->getForwardColor(),
            'font_size' => $this->getFontSize(),
        );
        return $array;
    }

}