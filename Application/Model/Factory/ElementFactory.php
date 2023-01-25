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

use Application\Model\Bean\Element;

/**
 *
 * ElementFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ElementFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Element
     */
    public static function createFromArray($fields)
    {
        $element = new Element();
        self::populate($element, $fields);

        return $element;
    }

    /**
     *
     * @static
     * @param Element element
     * @param array $fields
     */
    public static function populate($element, $fields)
    {
        if( !($element instanceof Element) ){
            static::throwException("El objecto no es un Element");
        }

        if( isset($fields['id_element']) ){
            $element->setIdElement($fields['id_element']);
        }

        if( isset($fields['name']) ){
            $element->setName($fields['name']);
        }
    }

    /**
     * @throws ElementException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ElementException($message);
    }

}