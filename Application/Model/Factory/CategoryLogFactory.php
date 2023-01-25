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

use Application\Model\Bean\CategoryLog;

/**
 *
 * CategoryLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CategoryLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\CategoryLog
     */
    public static function createFromArray($fields)
    {
        $categoryLog = new CategoryLog();
        self::populate($categoryLog, $fields);

        return $categoryLog;
    }

    /**
     *
     * @static
     * @param CategoryLog categoryLog
     * @param array $fields
     */
    public static function populate($categoryLog, $fields)
    {
        if( !($categoryLog instanceof CategoryLog) ){
            static::throwException("El objecto no es un CategoryLog");
        }

        if( isset($fields['id_category_log']) ){
            $categoryLog->setIdCategoryLog($fields['id_category_log']);
        }

        if( isset($fields['id_category']) ){
            $categoryLog->setIdCategory($fields['id_category']);
        }

        if( isset($fields['id_user']) ){
            $categoryLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $categoryLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $categoryLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $categoryLog->setNote($fields['note']);
        }
    }

    /**
     * @throws CategoryLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CategoryLogException($message);
    }

}