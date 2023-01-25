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

use Application\Model\Bean\Address;

/**
 *
 * AddressCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Address current()
 * @method \Application\Model\Bean\Address read()
 * @method \Application\Model\Bean\Address getOne()
 * @method \Application\Model\Bean\Address getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AddressCollection intersect() intersect(\Application\Model\Collection\AddressCollection $collection)
 * @method \Application\Model\Collection\AddressCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AddressCollection merge() merge(\Application\Model\Collection\AddressCollection $collection)
 * @method \Application\Model\Collection\AddressCollection diff() diff(\Application\Model\Collection\AddressCollection $collection)
 * @method \Application\Model\Collection\AddressCollection copy()
 */
class AddressCollection extends Collection{

    /**
     *
     * @param Address $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Address) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Address");
        }
    }


}