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

namespace Application\Model\Factory;

use Application\Model\Bean\Field;

/**
 *
 * FieldFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class FieldFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Field
     */
    public static function createFromArray($fields)
    {
        $field = new Field();
        self::populate($field, $fields);

        return $field;
    }

    /**
     *
     * @static
     * @param Field field
     * @param array $fields
     */
    public static function populate($field, $fields)
    {
        if( !($field instanceof Field) ){
            static::throwException("El objecto no es un Field");
        }

        if( isset($fields['id_field']) ){
            $field->setIdField($fields['id_field']);
        }

        if( isset($fields['name']) ){
            $field->setName($fields['name']);
        }

        if( isset($fields['reg_ex']) ){
            $field->setRegEx($fields['reg_ex']);
        }

        if( isset($fields['type']) ){
            $field->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $field->setStatus($fields['status']);
        }

        if( isset($fields['sample']) ){
            $field->setSample($fields['sample']);
        }
    }

    /**
     * @throws FieldException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\FieldException($message);
    }

}