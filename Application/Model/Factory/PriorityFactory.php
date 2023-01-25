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

use Application\Model\Bean\Priority;

/**
 *
 * PriorityFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class PriorityFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Priority
     */
    public static function createFromArray($fields)
    {
        $priority = new Priority();
        self::populate($priority, $fields);

        return $priority;
    }

    /**
     *
     * @static
     * @param Priority priority
     * @param array $fields
     */
    public static function populate($priority, $fields)
    {
        if( !($priority instanceof Priority) ){
            static::throwException("El objecto no es un Priority");
        }

        if( isset($fields['id_priority']) ){
            $priority->setIdPriority($fields['id_priority']);
        }

        if( isset($fields['name']) ){
            $priority->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $priority->setStatus($fields['status']);
        }
    }

    /**
     * @throws PriorityException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\PriorityException($message);
    }

}