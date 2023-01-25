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

use Application\Model\Bean\PhoneNumber;

/**
 *
 * PhoneNumberCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\PhoneNumber current()
 * @method \Application\Model\Bean\PhoneNumber read()
 * @method \Application\Model\Bean\PhoneNumber getOne()
 * @method \Application\Model\Bean\PhoneNumber getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\PhoneNumberCollection intersect() intersect(\Application\Model\Collection\PhoneNumberCollection $collection)
 * @method \Application\Model\Collection\PhoneNumberCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\PhoneNumberCollection merge() merge(\Application\Model\Collection\PhoneNumberCollection $collection)
 * @method \Application\Model\Collection\PhoneNumberCollection diff() diff(\Application\Model\Collection\PhoneNumberCollection $collection)
 * @method \Application\Model\Collection\PhoneNumberCollection copy()
 */
class PhoneNumberCollection extends Collection{

    /**
     *
     * @param PhoneNumber $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof PhoneNumber) ){
            throw new \InvalidArgumentException("Debe de ser un objecto PhoneNumber");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function (PhoneNumber $phone){
            return array($phone->getIdPhoneNumber() => $phone->getFullNumber());
        });
    }



}