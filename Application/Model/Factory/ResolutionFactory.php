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

use Application\Model\Bean\Resolution;

/**
 *
 * ResolutionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ResolutionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Resolution
     */
    public static function createFromArray($fields)
    {
        $resolution = new Resolution();
        self::populate($resolution, $fields);

        return $resolution;
    }

    /**
     *
     * @static
     * @param Resolution resolution
     * @param array $fields
     */
    public static function populate($resolution, $fields)
    {
        if( !($resolution instanceof Resolution) ){
            static::throwException("El objecto no es un Resolution");
        }

        if( isset($fields['id_resolution']) ){
            $resolution->setIdResolution($fields['id_resolution']);
        }

        if( isset($fields['name']) ){
            $resolution->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $resolution->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $resolution->setStatus($fields['status']);
        }
    }

    /**
     * @throws ResolutionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ResolutionException($message);
    }

}