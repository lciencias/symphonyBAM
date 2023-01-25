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
 * Person
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Person extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_persons';

    /**
     * Constants Fields
     */
    const ID_PERSON = 'id_person';
    const NAME = 'name';
    const LAST_NAME = 'last_name';
    const MIDDLE_NAME = 'middle_name';
    const CURP = 'curp';
    const LANGUAGE = 'language';

    /**
     * @var int
     */
    private $idPerson;


    /**
     * @var string
     */
    private $name;


    /**
     * @var string
     */
    private $lastName;


    /**
     * @var string
     */
    private $middleName;


    /**
     * @var string
     */
    private $curp;

    /**
     *
     * @var string
     */
    private $language;

    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdPerson();
    }


    /**
     * @return int
     */
    public function getIdPerson(){
        return $this->idPerson;
    }

    /**
     * @param int $idPerson
     * @return Person
     */
    public function setIdPerson($idPerson){
        $this->idPerson = $idPerson;
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
     * @return Person
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getLastName(){
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName){
        $this->lastName = $lastName;
        return $this;
    }


    /**
     * @return string
     */
    public function getMiddleName(){
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return Person
     */
    public function setMiddleName($middleName){
        $this->middleName = $middleName;
        return $this;
    }


    /**
     * @return string
     */
    public function getCurp(){
        return $this->curp;
    }

    /**
     * @param string $curp
     * @return Person
     */
    public function setCurp($curp){
        $this->curp = $curp;
        return $this;
    }

    /**
     *
     * @param string $language
     */
    public function setLanguage($language){
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage(){
        return $this->language;
    }

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_person' => $this->getIdPerson(),
            'name' => $this->getName(),
            'last_name' => $this->getLastName(),
            'middle_name' => $this->getMiddleName(),
            'curp' => $this->getCurp(),
            'language' => $this->getLanguage(),
        );
        return $array;
    }

    /**
     * @staticvar array
     */
    public static $Languages = array(
        'English' => 'en',
        'Spanish' => 'es',
    );

   /**
    * Returns the fullName
    * @return string
    */
    public function getFullName(){
        return $this->name . ' ' .$this->lastName . ' ' .  $this->middleName;
    }


}