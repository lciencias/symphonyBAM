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

use Application\Model\Bean\Channel;

/**
 *
 * ChannelFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ChannelFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Channel
     */
    public static function createFromArray($fields)
    {
        $channel = new Channel();
        self::populate($channel, $fields);

        return $channel;
    }

    /**
     *
     * @static
     * @param Channel channel
     * @param array $fields
     */
    public static function populate($channel, $fields)
    {
        if( !($channel instanceof Channel) ){
            static::throwException("El objecto no es un Channel");
        }

        if( isset($fields['id_channel']) ){
            $channel->setIdChannel($fields['id_channel']);
        }

        if( isset($fields['name']) ){
            $channel->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $channel->setStatus($fields['status']);
        }
        
        if( isset($fields['canal_acl']) ){
        	$channel->setCanalAcl($fields['canal_acl']);
        }
        if( isset($fields['canal_recl']) ){
        	$channel->setCanalRecl($fields['canal_recl']);
        }
        if( isset($fields['reopen']) ){
        	$channel->setReopen($fields['reopen']);
        }
    }

    /**
     * @throws ChannelException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ChannelException($message);
    }

}