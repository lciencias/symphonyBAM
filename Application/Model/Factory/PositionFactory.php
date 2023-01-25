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

use Application\Model\Bean\Position;

/**
 *
 * PositionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PositionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Position
     */
    public static function createFromArray($fields)
    {
        $position = new Position();
        self::populate($position, $fields);

        return $position;
    }

    /**
     *
     * @static
     * @param Position position
     * @param array $fields
     */
    public static function populate($position, $fields)
    {
        if( !($position instanceof Position) ){
            static::throwException("El objecto no es un Position");
        }

        if( isset($fields['id_position']) ){
            $position->setIdPosition($fields['id_position']);
        }

        if( isset($fields['id_company']) ){
            $position->setIdCompany($fields['id_company']);
        }

        if( isset($fields['name']) ){
            $position->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $position->setStatus($fields['status']);
        }
    }

    /**
     * @throws PositionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PositionException($message);
    }

}