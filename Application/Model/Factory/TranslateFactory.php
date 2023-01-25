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

use Application\Model\Bean\Translate;

/**
 *
 * TranslateFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TranslateFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Translate
     */
    public static function createFromArray($fields)
    {
        $translate = new Translate();
        self::populate($translate, $fields);

        return $translate;
    }

    /**
     *
     * @static
     * @param Translate translate
     * @param array $fields
     */
    public static function populate($translate, $fields)
    {
        if( !($translate instanceof Translate) ){
            static::throwException("El objecto no es un Translate");
        }

        if( isset($fields['id_translate']) ){
            $translate->setIdTranslate($fields['id_translate']);
        }

        if( isset($fields['string']) ){
            $translate->setString($fields['string']);
        }

        if( isset($fields['en']) ){
            $translate->setEn($fields['en']);
        }

        if( isset($fields['es']) ){
            $translate->setEs($fields['es']);
        }
    }

    /**
     * @throws TranslateException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TranslateException($message);
    }

}