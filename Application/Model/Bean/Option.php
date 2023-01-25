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
 * Option
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Option extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_options';

    /**
     * Constants Fields
     */
    const ID_OPTION = 'id_option';
    const NAME = 'name';
    const VALUE = 'value';
    const TYPE = 'type';
    const REGEXP = 'regexp';
    const DETAIL = 'detail';
    const OPTIONS = 'options';

    /**
     *
     * @var unknown_type
     */
    const SESSION_EXPIRATION = 1;

    /**
     * @var int
     */
    private $idOption;


    /**
     * @var string
     */
    private $name;


    /**
     * @var string
     */
    private $value;


    /**
     * @var int
     */
    private $type;


    /**
     * @var string
     */
    private $regexp;


    /**
     * @var string
     */
    private $detail;


    /**
     * @var string
     */
    private $options;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdOption();
    }


    /**
     * @return int
     */
    public function getIdOption(){
        return $this->idOption;
    }

    /**
     * @param int $idOption
     * @return Option
     */
    public function setIdOption($idOption){
        $this->idOption = $idOption;
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
     * @return Option
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param string $value
     * @return Option
     */
    public function setValue($value){
        $this->value = $value;
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
     * @return Option
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getRegexp(){
        return $this->regexp;
    }

    /**
     * @param string $regexp
     * @return Option
     */
    public function setRegexp($regexp){
        $this->regexp = $regexp;
        return $this;
    }


    /**
     * @return string
     */
    public function getDetail(){
        return $this->detail;
    }

    /**
     * @param string $detail
     * @return Option
     */
    public function setDetail($detail){
        $this->detail = $detail;
        return $this;
    }


    /**
     * @return string
     */
    public function getOptions(){
        return $this->options;
    }

    /**
     * @param string $options
     * @return Option
     */
    public function setOptions($options){
        $this->options = $options;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_option' => $this->getIdOption(),
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'type' => $this->getType(),
            'regexp' => $this->getRegexp(),
            'detail' => $this->getDetail(),
            'options' => $this->getOptions(),
        );
        return $array;
    }

    /**
     * Tipos de Opciones
     * @var array
     */
    public static $Types = array(
        'Simple'   => 1,
        'Multiple' => 2,
        'Yes_No'   => 3,
        'Select'   => 4,
    );
    /**
     * Options
     * @var array
     */
	public static $Options = array(
			'PasswordExpiration' => 1,
			'AutoAssignedTicket' => 2,
			'ModifyTicket' => 9,
			);
}