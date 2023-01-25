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

use Application\Model\Bean\ServiceLevel;

/**
 *
 * ServiceLevelFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ServiceLevelFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ServiceLevel
     */
    public static function createFromArray($fields)
    {
        $serviceLevel = new ServiceLevel();
        self::populate($serviceLevel, $fields);

        return $serviceLevel;
    }

    /**
     *
     * @static
     * @param ServiceLevel serviceLevel
     * @param array $fields
     */
    public static function populate($serviceLevel, $fields)
    {
        if( !($serviceLevel instanceof ServiceLevel) ){
            static::throwException("El objecto no es un ServiceLevel");
        }

        if( isset($fields['id_service_level']) ){
            $serviceLevel->setIdServiceLevel($fields['id_service_level']);
        }

        if( isset($fields['name']) ){
            $serviceLevel->setName($fields['name']);
        }

        if( isset($fields['resolution_time']) ){
            $serviceLevel->setResolutionTime($fields['resolution_time']);
        }

        if( isset($fields['response_time']) ){
            $serviceLevel->setResponseTime($fields['response_time']);
        }

        if( isset($fields['note']) ){
            $serviceLevel->setNote($fields['note']);
        }

        if( isset($fields['status']) ){
            $serviceLevel->setStatus($fields['status']);
        }
    }

    /**
     * @throws ServiceLevelException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ServiceLevelException($message);
    }

}