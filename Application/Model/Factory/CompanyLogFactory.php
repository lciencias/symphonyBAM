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

use Application\Model\Bean\CompanyLog;

/**
 *
 * CompanyLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CompanyLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\CompanyLog
     */
    public static function createFromArray($fields)
    {
        $companyLog = new CompanyLog();
        self::populate($companyLog, $fields);

        return $companyLog;
    }

    /**
     *
     * @static
     * @param CompanyLog companyLog
     * @param array $fields
     */
    public static function populate($companyLog, $fields)
    {
        if( !($companyLog instanceof CompanyLog) ){
            static::throwException("El objecto no es un CompanyLog");
        }

        if( isset($fields['id_company_log']) ){
            $companyLog->setIdCompanyLog($fields['id_company_log']);
        }

        if( isset($fields['id_company']) ){
            $companyLog->setIdCompany($fields['id_company']);
        }

        if( isset($fields['id_user']) ){
            $companyLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $companyLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $companyLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $companyLog->setNote($fields['note']);
        }
    }

    /**
     * @throws CompanyLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CompanyLogException($message);
    }

}