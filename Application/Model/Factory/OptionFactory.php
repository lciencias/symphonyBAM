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

use Application\Model\Bean\Option;

/**
 *
 * OptionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class OptionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Base\Option
     */
    public static function createFromArray($fields)
    {
        $option = new Option();
        self::populate($option, $fields);

        return $option;
    }

    /**
     *
     * @static
     * @param Option option
     * @param array $fields
     */
    public static function populate($option, $fields)
    {
        if( !($option instanceof Option) ){
            static::throwException("El objecto no es un Option");
        }

        if( isset($fields['id_option']) ){
            $option->setIdOption($fields['id_option']);
        }

        if( isset($fields['name']) ){
            $option->setName($fields['name']);
        }

        if( isset($fields['value']) ){
            $option->setValue($fields['value']);
        }

        if( isset($fields['type']) ){
            $option->setType($fields['type']);
        }

        if( isset($fields['regexp']) ){
            $option->setRegexp($fields['regexp']);
        }

        if( isset($fields['detail']) ){
            $option->setDetail($fields['detail']);
        }

        if( isset($fields['options']) ){
            $option->setOptions($fields['options']);
        }
    }

    /**
     * @throws OptionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\OptionException($message);
    }

}