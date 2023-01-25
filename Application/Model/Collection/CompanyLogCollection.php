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

use Application\Model\Bean\CompanyLog;

/**
 *
 * CompanyLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\CompanyLog current()
 * @method \Application\Model\Bean\CompanyLog read()
 * @method \Application\Model\Bean\CompanyLog getOne()
 * @method \Application\Model\Bean\CompanyLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CompanyLogCollection intersect() intersect(\Application\Model\Collection\CompanyLogCollection $collection)
 * @method \Application\Model\Collection\CompanyLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CompanyLogCollection merge() merge(\Application\Model\Collection\CompanyLogCollection $collection)
 * @method \Application\Model\Collection\CompanyLogCollection diff() diff(\Application\Model\Collection\CompanyLogCollection $collection)
 * @method \Application\Model\Collection\CompanyLogCollection copy()
 */
class CompanyLogCollection extends Collection{

    /**
     *
     * @param CompanyLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof CompanyLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto CompanyLog");
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