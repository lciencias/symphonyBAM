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

use Application\Model\Bean\ImpactLog;

/**
 *
 * ImpactLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ImpactLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ImpactLog
     */
    public static function createFromArray($fields)
    {
        $impactLog = new ImpactLog();
        self::populate($impactLog, $fields);

        return $impactLog;
    }

    /**
     *
     * @static
     * @param ImpactLog impactLog
     * @param array $fields
     */
    public static function populate($impactLog, $fields)
    {
        if( !($impactLog instanceof ImpactLog) ){
            static::throwException("El objecto no es un ImpactLog");
        }

        if( isset($fields['id_impact_log']) ){
            $impactLog->setIdImpactLog($fields['id_impact_log']);
        }

        if( isset($fields['id_impact']) ){
            $impactLog->setIdImpact($fields['id_impact']);
        }

        if( isset($fields['id_user']) ){
            $impactLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $impactLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $impactLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $impactLog->setNote($fields['note']);
        }
    }

    /**
     * @throws ImpactLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ImpactLogException($message);
    }

}