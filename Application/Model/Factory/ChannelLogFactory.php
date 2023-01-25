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

use Application\Model\Bean\ChannelLog;

/**
 *
 * ChannelLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ChannelLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ChannelLog
     */
    public static function createFromArray($fields)
    {
        $channelLog = new ChannelLog();
        self::populate($channelLog, $fields);

        return $channelLog;
    }

    /**
     *
     * @static
     * @param ChannelLog channelLog
     * @param array $fields
     */
    public static function populate($channelLog, $fields)
    {
        if( !($channelLog instanceof ChannelLog) ){
            static::throwException("El objecto no es un ChannelLog");
        }

        if( isset($fields['id_channels_logs']) ){
            $channelLog->setIdChannelsLogs($fields['id_channels_logs']);
        }

        if( isset($fields['id_channel']) ){
            $channelLog->setIdChannel($fields['id_channel']);
        }

        if( isset($fields['id_user']) ){
            $channelLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $channelLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
        	$channelLog->setIdEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $channelLog->setNote($fields['note']);
        }
    }

    /**
     * @throws ChannelLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ChannelLogException($message);
    }

}