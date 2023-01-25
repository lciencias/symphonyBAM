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

use Application\Model\Bean\RequiredField;

/**
 *
 * RequiredFieldFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class RequiredFieldFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\RequiredField
     */
    public static function createFromArray($fields)
    {
        $requiredField = new RequiredField();
        self::populate($requiredField, $fields);

        return $requiredField;
    }

    /**
     *
     * @static
     * @param RequiredField requiredField
     * @param array $fields
     */
    public static function populate($requiredField, $fields)
    {
        if( !($requiredField instanceof RequiredField) ){
            static::throwException("El objecto no es un RequiredField");
        }

        if( isset($fields['id_required_field']) ){
            $requiredField->setIdRequiredField($fields['id_required_field']);
        }

        if( isset($fields['id_client_category']) ){
            $requiredField->setIdClientCategory($fields['id_client_category']);
        }

        if( isset($fields['id_field']) ){
            $requiredField->setIdField($fields['id_field']);
        }
    }

    /**
     * @throws RequiredFieldException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\RequiredFieldException($message);
    }

}