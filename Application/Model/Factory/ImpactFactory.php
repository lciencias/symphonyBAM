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

use Application\Model\Bean\Impact;

/**
 *
 * ImpactFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ImpactFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Impact
     */
    public static function createFromArray($fields)
    {
        $impact = new Impact();
        self::populate($impact, $fields);

        return $impact;
    }

    /**
     *
     * @static
     * @param Impact impact
     * @param array $fields
     */
    public static function populate($impact, $fields)
    {
        if( !($impact instanceof Impact) ){
            static::throwException("El objecto no es un Impact");
        }

        if( isset($fields['id_impact']) ){
            $impact->setIdImpact($fields['id_impact']);
        }

        if( isset($fields['name']) ){
            $impact->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $impact->setStatus($fields['status']);
        }
    }

    /**
     * @throws ImpactException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ImpactException($message);
    }

}