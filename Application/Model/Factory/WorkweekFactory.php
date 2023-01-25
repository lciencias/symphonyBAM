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

use Application\Model\Bean\Workweek;

/**
 *
 * WorkweekFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class WorkweekFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Workweek
     */
    public static function createFromArray($fields)
    {
        $workweek = new Workweek();
        self::populate($workweek, $fields);

        return $workweek;
    }

    /**
     *
     * @static
     * @param Workweek workweek
     * @param array $fields
     */
    public static function populate($workweek, $fields)
    {
        if( !($workweek instanceof Workweek) ){
            static::throwException("El objecto no es un Workweek");
        }

        if( isset($fields['id_workweek']) ){
            $workweek->setIdWorkweek($fields['id_workweek']);
        }

        if( isset($fields['name']) ){
            $workweek->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $workweek->setStatus($fields['status']);
        }
    }

    /**
     * @throws WorkweekException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\WorkweekException($message);
    }

}