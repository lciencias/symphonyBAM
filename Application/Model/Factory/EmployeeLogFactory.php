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

use Application\Model\Bean\EmployeeLog;

/**
 *
 * EmployeeLogFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EmployeeLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\EmployeeLog
     */
    public static function createFromArray($fields)
    {
        $employeeLog = new EmployeeLog();
        self::populate($employeeLog, $fields);

        return $employeeLog;
    }

    /**
     *
     * @static
     * @param EmployeeLog employeeLog
     * @param array $fields
     */
    public static function populate($employeeLog, $fields)
    {
        if( !($employeeLog instanceof EmployeeLog) ){
            static::throwException("El objecto no es un EmployeeLog");
        }

        if( isset($fields['id_employee_log']) ){
            $employeeLog->setIdEmployeeLog($fields['id_employee_log']);
        }

        if( isset($fields['id_employee']) ){
            $employeeLog->setIdEmployee($fields['id_employee']);
        }

        if( isset($fields['id_user']) ){
            $employeeLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $employeeLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $employeeLog->setEventType($fields['event_type']);
        }

        if( isset($fields['note']) ){
            $employeeLog->setNote($fields['note']);
        }
    }

    /**
     * @throws EmployeeLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EmployeeLogException($message);
    }

}