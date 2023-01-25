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

use Application\Model\Bean\Activity;

/**
 *
 * ActivityFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ActivityFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Activity
     */
    public static function createFromArray($fields)
    {
        $activity = new Activity();
        self::populate($activity, $fields);

        return $activity;
    }

    /**
     *
     * @static
     * @param Activity activity
     * @param array $fields
     */
    public static function populate($activity, $fields)
    {
        if( !($activity instanceof Activity) ){
            static::throwException("El objecto no es un Activity");
        }

        if( isset($fields['id_activity']) ){
            $activity->setIdActivity($fields['id_activity']);
        }

        if( isset($fields['id_base_ticket']) ){
            $activity->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_user']) ){
            $activity->setIdUser($fields['id_user']);
        }

        if( isset($fields['start_date']) ){
            $activity->setStartDate($fields['start_date']);
        }

        if( isset($fields['end_date']) ){
            $activity->setEndDate($fields['end_date']);
        }

        if( isset($fields['note']) ){
            $activity->setNote($fields['note']);
        }
    }

    /**
     * @throws ActivityException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ActivityException($message);
    }

}