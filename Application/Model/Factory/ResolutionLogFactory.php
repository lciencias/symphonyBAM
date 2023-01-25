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

use Application\Model\Bean\ResolutionLog;

/**
 *
 * ResolutionLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ResolutionLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ResolutionLog
     */
    public static function createFromArray($fields)
    {
        $resolutionLog = new ResolutionLog();
        self::populate($resolutionLog, $fields);

        return $resolutionLog;
    }

    /**
     *
     * @static
     * @param ResolutionLog resolutionLog
     * @param array $fields
     */
    public static function populate($resolutionLog, $fields)
    {
        if( !($resolutionLog instanceof ResolutionLog) ){
            static::throwException("El objecto no es un ResolutionLog");
        }

        if( isset($fields['id_resolution_log']) ){
            $resolutionLog->setIdResolutionLog($fields['id_resolution_log']);
        }

        if( isset($fields['id_resolution']) ){
            $resolutionLog->setIdResolution($fields['id_resolution']);
        }

        if( isset($fields['id_user']) ){
            $resolutionLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $resolutionLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $resolutionLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $resolutionLog->setNote($fields['note']);
        }
    }

    /**
     * @throws ResolutionLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ResolutionLogException($message);
    }

}