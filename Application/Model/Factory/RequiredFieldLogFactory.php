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

use Application\Model\Bean\RequiredFieldLog;

/**
 *
 * RequiredFieldLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class RequiredFieldLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\RequiredFieldLog
     */
    public static function createFromArray($fields)
    {
        $requiredFieldLog = new RequiredFieldLog();
        self::populate($requiredFieldLog, $fields);

        return $requiredFieldLog;
    }

    /**
     *
     * @static
     * @param RequiredFieldLog requiredFieldLog
     * @param array $fields
     */
    public static function populate($requiredFieldLog, $fields)
    {
        if( !($requiredFieldLog instanceof RequiredFieldLog) ){
            static::throwException("El objecto no es un RequiredFieldLog");
        }

        if( isset($fields['id_required_field_log']) ){
            $requiredFieldLog->setIdRequiredFieldLog($fields['id_required_field_log']);
        }

        if( isset($fields['id_user']) ){
            $requiredFieldLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_required_field']) ){
            $requiredFieldLog->setIdRequiredField($fields['id_required_field']);
        }

        if( isset($fields['date_log']) ){
            $requiredFieldLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $requiredFieldLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $requiredFieldLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws RequiredFieldLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\RequiredFieldLogException($message);
    }

}