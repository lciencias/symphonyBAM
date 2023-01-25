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

use Application\Model\Bean\Employee;

/**
 *
 * EmployeeFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EmployeeFactory extends PersonFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Employee
     */
    public static function createFromArray($fields)
    {
        $employee = new Employee();
        self::populate($employee, $fields);

        return $employee;
    }

    /**
     *
     * @static
     * @param Employee employee
     * @param array $fields
     */
    public static function populate($employee, $fields)
    {
        parent::populate($employee, $fields);
        if( !($employee instanceof Employee) ){
            static::throwException("El objecto no es un Employee");
        }

        if( isset($fields['id_employee']) ){
            $employee->setIdEmployee($fields['id_employee']);
        }

        if( isset($fields['id_person']) ){
            $employee->setIdPerson($fields['id_person']);
        }

        if( isset($fields['id_position']) ){
            $employee->setIdPosition($fields['id_position']);
        }

        if( isset($fields['id_location']) ){
            $employee->setIdLocation($fields['id_location']);
        }

        if( isset($fields['id_area']) ){
            $employee->setIdArea($fields['id_area']);
        }

        if( isset($fields['status_employee']) ){
            $employee->setStatusEmployee($fields['status_employee']);
        }

        if( isset($fields['is_vip']) ){
            $employee->setIsVip($fields['is_vip']);
        }

        if( isset($fields['id_company']) ){
            $employee->setIdCompany($fields['id_company']);
        }
    }

    /**
     * @throws EmployeeException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EmployeeException($message);
    }

}