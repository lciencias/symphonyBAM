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

use Application\Model\Bean\LocationLog;

/**
 *
 * LocationLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class LocationLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\LocationLog
     */
    public static function createFromArray($fields)
    {
        $locationLog = new LocationLog();
        self::populate($locationLog, $fields);

        return $locationLog;
    }

    /**
     *
     * @static
     * @param LocationLog locationLog
     * @param array $fields
     */
    public static function populate($locationLog, $fields)
    {
        if( !($locationLog instanceof LocationLog) ){
            static::throwException("El objecto no es un LocationLog");
        }

        if( isset($fields['id_location_log']) ){
            $locationLog->setIdLocationLog($fields['id_location_log']);
        }

        if( isset($fields['id_location']) ){
            $locationLog->setIdLocation($fields['id_location']);
        }

        if( isset($fields['id_user']) ){
            $locationLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $locationLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $locationLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $locationLog->setNote($fields['note']);
        }
    }

    /**
     * @throws LocationLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\LocationLogException($message);
    }

}