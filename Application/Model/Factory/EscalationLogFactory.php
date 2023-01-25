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

use Application\Model\Bean\EscalationLog;

/**
 *
 * EscalationLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EscalationLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\EscalationLog
     */
    public static function createFromArray($fields)
    {
        $escalationLog = new EscalationLog();
        self::populate($escalationLog, $fields);

        return $escalationLog;
    }

    /**
     *
     * @static
     * @param EscalationLog escalationLog
     * @param array $fields
     */
    public static function populate($escalationLog, $fields)
    {
        if( !($escalationLog instanceof EscalationLog) ){
            static::throwException("El objecto no es un EscalationLog");
        }

        if( isset($fields['id_escalation_log']) ){
            $escalationLog->setIdEscalationLog($fields['id_escalation_log']);
        }

        if( isset($fields['id_escalation']) ){
            $escalationLog->setIdEscalation($fields['id_escalation']);
        }

        if( isset($fields['id_user']) ){
            $escalationLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $escalationLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $escalationLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $escalationLog->setNote($fields['note']);
        }
    }

    /**
     * @throws EscalationLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EscalationLogException($message);
    }

}