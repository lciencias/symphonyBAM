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
 * Field
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Field extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_fields';

    /**
     * Constants Fields
     */
    const ID_FIELD = 'id_field';
    const NAME = 'name';
    const REG_EX = 'reg_ex';
    const TYPE = 'type';
    const STATUS = 'status';
    const SAMPLE = 'sample';

    /**
     * @var int
     */
    private $idField;


    /**
     * @var string
     */
    private $name;


    /**
     * @var string
     */
    private $regEx;


    /**
     * @var int
     */
    private $type;


    /**
     * @var int
     */
    private $status;


    /**
     * @var string
     */
    private $sample;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdField();
    }


    /**
     * @return int
     */
    public function getIdField(){
        return $this->idField;
    }

    /**
     * @param int $idField
     * @return Field
     */
    public function setIdField($idField){
        $this->idField = $idField;
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
     * @return Field
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getRegEx(){
        return $this->regEx;
    }

    /**
     * @param string $regEx
     * @return Field
     */
    public function setRegEx($regEx){
        $this->regEx = $regEx;
        return $this;
    }


    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param int $type
     * @return Field
     */
    public function setType($type){
        $this->type = $type;
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
     * @return Field
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * @return string
     */
    public function getSample(){
        return $this->sample;
    }

    /**
     * @param string $sample
     * @return Field
     */
    public function setSample($sample){
        $this->sample = $sample;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_field' => $this->getIdField(),
            'name' => $this->getName(),
            'reg_ex' => $this->getRegEx(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
            'sample' => $this->getSample(),
        );
        return $array;
    }
    public static $RegEx = array(
    		'Select and option' => '', //$this->i18n->_('Select and option');
    		'Dates' => '^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$',//$this->i18n->_('Dates');
    		'Positive Numbers' => '^[+]?([0-9]+(?:[\.][0-9]*)?|\.[0-9]+)$',//$this->i18n->_('Positive Numbers');
    		'Numbers' => '^[0-9]+$', //$this->i18n->_('Numbers');
    		'Just Characters' => '^[a-zA-Z0-9 ]+$',//$this->i18n->_('Just Characters');
    		'E-mail' => '\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b', //$this->i18n->_('E-mail');
    		'Hour' => '^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$',
//     		'Credit Card Number' => '',
    		);
    /**
     * 
     * @var array
     */
    public static $Status = array(
    		'Active' => 1,
    		'Inactive' => 2,
    		);
    /**
     * @return string
     */
    public function getStatusName(){
		return array_search($this->getStatus(), self::$Status);
    }
    /**
     * 
     * @return boolean
     */
    public function isActive(){
    	return $this->getStatus() == self::$Status['Active'] ? true : false;
    }
    /**
     * 
     * @return boolean
     */
    public function isInactive(){
    	return $this->getStatus() == self::$Status['Inactive'] ? true : false;
    }
}