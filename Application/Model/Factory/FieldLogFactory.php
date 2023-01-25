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

use Application\Model\Bean\FieldLog;

/**
 *
 * FieldLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class FieldLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\FieldLog
     */
    public static function createFromArray($fields)
    {
        $fieldLog = new FieldLog();
        self::populate($fieldLog, $fields);

        return $fieldLog;
    }

    /**
     *
     * @static
     * @param FieldLog fieldLog
     * @param array $fields
     */
    public static function populate($fieldLog, $fields)
    {
        if( !($fieldLog instanceof FieldLog) ){
            static::throwException("El objecto no es un FieldLog");
        }

        if( isset($fields['id_field_log']) ){
            $fieldLog->setIdFieldLog($fields['id_field_log']);
        }

        if( isset($fields['id_field']) ){
            $fieldLog->setIdField($fields['id_field']);
        }

        if( isset($fields['id_user']) ){
            $fieldLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $fieldLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $fieldLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $fieldLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws FieldLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\FieldLogException($message);
    }

}