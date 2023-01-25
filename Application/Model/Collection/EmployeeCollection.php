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

namespace Application\Model\Collection;

use Application\Model\Bean\Employee;

/**
 *
 * EmployeeCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Employee current()
 * @method \Application\Model\Bean\Employee read()
 * @method \Application\Model\Bean\Employee getOne()
 * @method \Application\Model\Bean\Employee getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EmployeeCollection intersect() intersect(\Application\Model\Collection\EmployeeCollection $collection)
 * @method \Application\Model\Collection\EmployeeCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EmployeeCollection merge() merge(\Application\Model\Collection\EmployeeCollection $collection)
 * @method \Application\Model\Collection\EmployeeCollection diff() diff(\Application\Model\Collection\EmployeeCollection $collection)
 * @method \Application\Model\Collection\EmployeeCollection copy()
 */
class EmployeeCollection extends PersonCollection{

    /**
     *
     * @param Employee $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Employee) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Employee");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Employee $employee){
            return array( $employee->getIdEmployee() => $employee->getFullName() );
        });
    }

}