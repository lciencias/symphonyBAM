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

use Application\Model\Bean\ServiceLevelLog;

/**
 *
 * ServiceLevelLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ServiceLevelLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    public static function createFromArray($fields)
    {
        $serviceLevelLog = new ServiceLevelLog();
        self::populate($serviceLevelLog, $fields);

        return $serviceLevelLog;
    }

    /**
     *
     * @static
     * @param ServiceLevelLog serviceLevelLog
     * @param array $fields
     */
    public static function populate($serviceLevelLog, $fields)
    {
        if( !($serviceLevelLog instanceof ServiceLevelLog) ){
            static::throwException("El objecto no es un ServiceLevelLog");
        }

        if( isset($fields['id_service_level_log']) ){
            $serviceLevelLog->setIdServiceLevelLog($fields['id_service_level_log']);
        }

        if( isset($fields['id_service_level']) ){
            $serviceLevelLog->setIdServiceLevel($fields['id_service_level']);
        }

        if( isset($fields['id_user']) ){
            $serviceLevelLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $serviceLevelLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $serviceLevelLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $serviceLevelLog->setNote($fields['note']);
        }
    }

    /**
     * @throws ServiceLevelLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ServiceLevelLogException($message);
    }

}