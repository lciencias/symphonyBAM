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

use Application\Model\Bean\Location;

/**
 *
 * LocationFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class LocationFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Location
     */
    public static function createFromArray($fields)
    {
        $location = new Location();
        self::populate($location, $fields);

        return $location;
    }

    /**
     *
     * @static
     * @param Location location
     * @param array $fields
     */
    public static function populate($location, $fields)
    {
        if( !($location instanceof Location) ){
            static::throwException("El objecto no es un Location");
        }

        if( isset($fields['id_location']) ){
            $location->setIdLocation($fields['id_location']);
        }

        if( isset($fields['id_company']) ){
            $location->setIdCompany($fields['id_company']);
        }

        if( isset($fields['name']) ){
            $location->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $location->setStatus($fields['status']);
        }
    }

    /**
     * @throws LocationException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\LocationException($message);
    }

}