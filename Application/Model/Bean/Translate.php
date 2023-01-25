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
 * Translate
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Translate extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_translates';

    /**
     * Constants Fields
     */
    const ID_TRANSLATE = 'id_translate';
    const STRING = 'string';
    const EN = 'en';
    const ES = 'es';

    /**
     * @var int
     */
    private $idTranslate;


    /**
     * @var string
     */
    private $string;


    /**
     * @var string
     */
    private $en;


    /**
     * @var string
     */
    private $es;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTranslate();
    }


    /**
     * @return int
     */
    public function getIdTranslate(){
        return $this->idTranslate;
    }

    /**
     * @param int $idTranslate
     * @return Translate
     */
    public function setIdTranslate($idTranslate){
        $this->idTranslate = $idTranslate;
        return $this;
    }


    /**
     * @return string
     */
    public function getString(){
        return $this->string;
    }

    /**
     * @param string $string
     * @return Translate
     */
    public function setString($string){
        $this->string = $string;
        return $this;
    }


    /**
     * @return string
     */
    public function getEn(){
        return $this->en;
    }

    /**
     * @param string $en
     * @return Translate
     */
    public function setEn($en){
        $this->en = $en;
        return $this;
    }


    /**
     * @return string
     */
    public function getEs(){
        return $this->es;
    }

    /**
     * @param string $es
     * @return Translate
     */
    public function setEs($es){
        $this->es = $es;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_translate' => $this->getIdTranslate(),
            'string' => $this->getString(),
            'en' => $this->getEn(),
            'es' => $this->getEs(),
        );
        return $array;
    }

}