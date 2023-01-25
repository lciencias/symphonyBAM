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

use Application\Model\Bean\Customize;

/**
 *
 * CustomizeFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CustomizeFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Customize
     */
    public static function createFromArray($fields)
    {
        $customize = new Customize();
        self::populate($customize, $fields);

        return $customize;
    }

    /**
     *
     * @static
     * @param Customize customize
     * @param array $fields
     */
    public static function populate($customize, $fields)
    {
        if( !($customize instanceof Customize) ){
            static::throwException("El objecto no es un Customize");
        }

        if( isset($fields['id_pcs_common_customize']) ){
            $customize->setIdPcsCommonCustomize($fields['id_pcs_common_customize']);
        }

        if( isset($fields['id_company']) ){
            $customize->setIdCompany($fields['id_company']);
        }

        if( isset($fields['logo']) ){
            $customize->setLogo($fields['logo']);
        }

        if( isset($fields['background_color']) ){
            $customize->setBackgroundColor($fields['background_color']);
        }

        if( isset($fields['forward_color']) ){
            $customize->setForwardColor($fields['forward_color']);
        }

        if( isset($fields['font_size']) ){
            $customize->setFontSize($fields['font_size']);
        }
    }

    /**
     * @throws CustomizeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CustomizeException($message);
    }

}