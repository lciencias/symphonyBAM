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

namespace Application\Model\Factory;

use Application\Model\Bean\Person;

/**
 *
 * PersonFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PersonFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Person
     */
    public static function createFromArray($fields)
    {
        $person = new Person();
        self::populate($person, $fields);

        return $person;
    }

    /**
     *
     * @static
     * @param Person person
     * @param array $fields
     */
    public static function populate($person, $fields)
    {
        if( !($person instanceof Person) ){
            static::throwException("El objecto no es un Person");
        }

        if( isset($fields['id_person']) ){
            $person->setIdPerson($fields['id_person']);
        }

        if( isset($fields['name']) ){
            $person->setName($fields['name']);
        }

        if( isset($fields['last_name']) ){
            $person->setLastName($fields['last_name']);
        }

        if( isset($fields['middle_name']) ){
            $person->setMiddleName($fields['middle_name']);
        }

        if( isset($fields['curp']) ){
            $person->setCurp($fields['curp']);
        }

        if( isset($fields['language']) ){
            $person->setLanguage($fields['language']);
        }

    }

    /**
     * @throws PersonException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PersonException($message);
    }

}