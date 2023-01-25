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

use Application\Model\Bean\Customize;

/**
 *
 * CustomizeCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Customize current()
 * @method \Application\Model\Bean\Customize read()
 * @method \Application\Model\Bean\Customize getOne()
 * @method \Application\Model\Bean\Customize getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CustomizeCollection intersect() intersect(\Application\Model\Collection\CustomizeCollection $collection)
 * @method \Application\Model\Collection\CustomizeCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CustomizeCollection merge() merge(\Application\Model\Collection\CustomizeCollection $collection)
 * @method \Application\Model\Collection\CustomizeCollection diff() diff(\Application\Model\Collection\CustomizeCollection $collection)
 * @method \Application\Model\Collection\CustomizeCollection copy()
 */
class CustomizeCollection extends Collection{

    /**
     *
     * @param Customize $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Customize) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Customize");
        }
    }


}