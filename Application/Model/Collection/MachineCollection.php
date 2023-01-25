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

use Application\Model\Bean\Machine;

/**
 *
 * MachineCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Machine current()
 * @method \Application\Model\Bean\Machine read()
 * @method \Application\Model\Bean\Machine getOne()
 * @method \Application\Model\Bean\Machine getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\MachineCollection intersect() intersect(\Application\Model\Collection\MachineCollection $collection)
 * @method \Application\Model\Collection\MachineCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\MachineCollection merge() merge(\Application\Model\Collection\MachineCollection $collection)
 * @method \Application\Model\Collection\MachineCollection diff() diff(\Application\Model\Collection\MachineCollection $collection)
 * @method \Application\Model\Collection\MachineCollection copy()
 */
class MachineCollection extends Collection{

    /**
     *
     * @param Machine $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Machine) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Machine");
        }
    }


}