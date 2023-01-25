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

use Application\Model\Bean\Area;

/**
 *
 * AreaFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class AreaFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Area
     */
    public static function createFromArray($fields)
    {
        $area = new Area();
        self::populate($area, $fields);

        return $area;
    }

    /**
     *
     * @static
     * @param Area area
     * @param array $fields
     */
    public static function populate($area, $fields)
    {
        if( !($area instanceof Area) ){
            static::throwException("El objecto no es un Area");
        }

        if( isset($fields['id_area']) ){
            $area->setIdArea($fields['id_area']);
        }

        if( isset($fields['id_company']) ){
            $area->setIdCompany($fields['id_company']);
        }

        if( isset($fields['name']) ){
            $area->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $area->setStatus($fields['status']);
        }
    }

    /**
     * @throws AreaException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AreaException($message);
    }

}