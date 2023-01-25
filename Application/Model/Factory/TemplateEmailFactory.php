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

use Application\Model\Bean\TemplateEmail;

/**
 *
 * TemplateEmailFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class TemplateEmailFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\TemplateEmail
     */
    public static function createFromArray($fields)
    {
        $templateEmail = new TemplateEmail();
        self::populate($templateEmail, $fields);

        return $templateEmail;
    }

    /**
     *
     * @static
     * @param TemplateEmail templateEmail
     * @param array $fields
     */
    public static function populate($templateEmail, $fields)
    {
        if( !($templateEmail instanceof TemplateEmail) ){
            static::throwException("El objecto no es un TemplateEmail");
        }

        if( isset($fields['id_template_email']) ){
            $templateEmail->setIdTemplateEmail($fields['id_template_email']);
        }

        if( isset($fields['name']) ){
            $templateEmail->setName($fields['name']);
        }

        if( isset($fields['subject']) ){
            $templateEmail->setSubject($fields['subject']);
        }

        if( isset($fields['body']) ){
            $templateEmail->setBody($fields['body']);
        }

        if( isset($fields['event']) ){
            $templateEmail->setEvent($fields['event']);
        }

        if( isset($fields['status']) ){
            $templateEmail->setStatus($fields['status']);
        }

        if( isset($fields['to_employee']) ){
            $templateEmail->setToEmployee($fields['to_employee']);
        }

        if( isset($fields['to_user']) ){
            $templateEmail->setToUser($fields['to_user']);
        }

        if( isset($fields['to_group']) ){
            $templateEmail->setToGroup($fields['to_group']);
        }

        if( isset($fields['language']) ){
            $templateEmail->setLanguage($fields['language']);
        }
        
        if( isset($fields['kind_of_ticket']) ){
        	$templateEmail->setKindOfTicket($fields['kind_of_ticket']);
        }
    }

    /**
     * @throws TemplateEmailException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\TemplateEmailException($message);
    }

}