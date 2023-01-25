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

use Application\Model\Bean\ClientCategoryLog;

/**
 *
 * ClientCategoryLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientCategoryLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    public static function createFromArray($fields)
    {
        $clientCategoryLog = new ClientCategoryLog();
        self::populate($clientCategoryLog, $fields);

        return $clientCategoryLog;
    }

    /**
     *
     * @static
     * @param ClientCategoryLog clientCategoryLog
     * @param array $fields
     */
    public static function populate($clientCategoryLog, $fields)
    {
        if( !($clientCategoryLog instanceof ClientCategoryLog) ){
            static::throwException("El objecto no es un ClientCategoryLog");
        }

        if( isset($fields['id_category_log']) ){
            $clientCategoryLog->setIdCategoryLog($fields['id_category_log']);
        }

        if( isset($fields['id_user']) ){
            $clientCategoryLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_client_category']) ){
            $clientCategoryLog->setIdClientCategory($fields['id_client_category']);
        }

        if( isset($fields['date_log']) ){
            $clientCategoryLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $clientCategoryLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $clientCategoryLog->setNote($fields['note']);
        }
    }

    /**
     * @throws ClientCategoryLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientCategoryLogException($message);
    }

}