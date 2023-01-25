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

use Application\Model\Bean\CategoryLog;

/**
 *
 * CategoryLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\CategoryLog current()
 * @method \Application\Model\Bean\CategoryLog read()
 * @method \Application\Model\Bean\CategoryLog getOne()
 * @method \Application\Model\Bean\CategoryLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CategoryLogCollection intersect() intersect(\Application\Model\Collection\CategoryLogCollection $collection)
 * @method \Application\Model\Collection\CategoryLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CategoryLogCollection merge() merge(\Application\Model\Collection\CategoryLogCollection $collection)
 * @method \Application\Model\Collection\CategoryLogCollection diff() diff(\Application\Model\Collection\CategoryLogCollection $collection)
 * @method \Application\Model\Collection\CategoryLogCollection copy()
 */
class CategoryLogCollection extends Collection{

    /**
     *
     * @param CategoryLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof CategoryLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto CategoryLog");
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