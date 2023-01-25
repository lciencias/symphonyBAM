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

use Application\Model\Bean\AreaLog;

/**
 *
 * AreaLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class AreaLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\AreaLog
     */
    public static function createFromArray($fields)
    {
        $areaLog = new AreaLog();
        self::populate($areaLog, $fields);

        return $areaLog;
    }

    /**
     *
     * @static
     * @param AreaLog areaLog
     * @param array $fields
     */
    public static function populate($areaLog, $fields)
    {
        if( !($areaLog instanceof AreaLog) ){
            static::throwException("El objecto no es un AreaLog");
        }

        if( isset($fields['id_area_log']) ){
            $areaLog->setIdAreaLog($fields['id_area_log']);
        }

        if( isset($fields['id_user']) ){
            $areaLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_area']) ){
            $areaLog->setIdArea($fields['id_area']);
        }

        if( isset($fields['date_log']) ){
            $areaLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $areaLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $areaLog->setNote($fields['note']);
        }
    }

    /**
     * @throws AreaLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AreaLogException($message);
    }

}