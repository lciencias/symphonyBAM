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

use Application\Model\Bean\EmployeeLog;

/**
 *
 * EmployeeLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EmployeeLog current()
 * @method \Application\Model\Bean\EmployeeLog read()
 * @method \Application\Model\Bean\EmployeeLog getOne()
 * @method \Application\Model\Bean\EmployeeLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EmployeeLogCollection intersect() intersect(\Application\Model\Collection\EmployeeLogCollection $collection)
 * @method \Application\Model\Collection\EmployeeLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EmployeeLogCollection merge() merge(\Application\Model\Collection\EmployeeLogCollection $collection)
 * @method \Application\Model\Collection\EmployeeLogCollection diff() diff(\Application\Model\Collection\EmployeeLogCollection $collection)
 * @method \Application\Model\Collection\EmployeeLogCollection copy()
 */
class EmployeeLogCollection extends Collection{

    /**
     *
     * @param EmployeeLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof EmployeeLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto EmployeeLog");
        }
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function($log){
            return array($log->getIdUser() => $log->getIdUser());
        });
    }

}