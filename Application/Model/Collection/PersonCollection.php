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

use Application\Model\Bean\Person;

/**
 *
 * PersonCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Person current()
 * @method \Application\Model\Bean\Person read()
 * @method \Application\Model\Bean\Person getOne()
 * @method \Application\Model\Bean\Person getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PersonCollection intersect() intersect(\Application\Model\Collection\PersonCollection $collection)
 * @method \Application\Model\Collection\PersonCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PersonCollection merge() merge(\Application\Model\Collection\PersonCollection $collection)
 * @method \Application\Model\Collection\PersonCollection diff() diff(\Application\Model\Collection\PersonCollection $collection)
 * @method \Application\Model\Collection\PersonCollection copy()
 */
class PersonCollection extends Collection{

    /**
     *
     * @param Person $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Person) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Person");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Person $person){
            return array( $person->getIdPerson() => $person->getFullName() );
        });
    }

}