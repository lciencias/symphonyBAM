<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Factory;

use Application\Model\Bean\ClientResolutionLog;

/**
 *
 * ClientResolutionLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientResolutionLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientResolutionLog
     */
    public static function createFromArray($fields)
    {
        $clientResolutionLog = new ClientResolutionLog();
        self::populate($clientResolutionLog, $fields);

        return $clientResolutionLog;
    }

    /**
     *
     * @static
     * @param ClientResolutionLog clientResolutionLog
     * @param array $fields
     */
    public static function populate($clientResolutionLog, $fields)
    {
        if( !($clientResolutionLog instanceof ClientResolutionLog) ){
            static::throwException("El objecto no es un ClientResolutionLog");
        }

        if( isset($fields['id_client_resolution_log']) ){
            $clientResolutionLog->setIdClientResolutionLog($fields['id_client_resolution_log']);
        }

        if( isset($fields['id_client_resolution']) ){
            $clientResolutionLog->setIdClientResolution($fields['id_client_resolution']);
        }

        if( isset($fields['id_user']) ){
            $clientResolutionLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $clientResolutionLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $clientResolutionLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $clientResolutionLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws ClientResolutionLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientResolutionLogException($message);
    }

}