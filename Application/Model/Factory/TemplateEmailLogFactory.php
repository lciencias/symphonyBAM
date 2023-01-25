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

use Application\Model\Bean\TemplateEmailLog;

/**
 *
 * TemplateEmailLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TemplateEmailLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    public static function createFromArray($fields)
    {
        $templateEmailLog = new TemplateEmailLog();
        self::populate($templateEmailLog, $fields);

        return $templateEmailLog;
    }

    /**
     *
     * @static
     * @param TemplateEmailLog templateEmailLog
     * @param array $fields
     */
    public static function populate($templateEmailLog, $fields)
    {
        if( !($templateEmailLog instanceof TemplateEmailLog) ){
            static::throwException("El objecto no es un TemplateEmailLog");
        }

        if( isset($fields['id_template_email_log']) ){
            $templateEmailLog->setIdTemplateEmailLog($fields['id_template_email_log']);
        }

        if( isset($fields['id_template_email']) ){
            $templateEmailLog->setIdTemplateEmail($fields['id_template_email']);
        }

        if( isset($fields['id_user']) ){
            $templateEmailLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $templateEmailLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $templateEmailLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $templateEmailLog->setNote($fields['note']);
        }
    }

    /**
     * @throws TemplateEmailLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TemplateEmailLogException($message);
    }

}