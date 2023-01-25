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

use Application\Model\Bean\Email;

/**
 *
 * EmailCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Email current()
 * @method \Application\Model\Bean\Email read()
 * @method \Application\Model\Bean\Email getOne()
 * @method \Application\Model\Bean\Email getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EmailCollection intersect() intersect(\Application\Model\Collection\EmailCollection $collection)
 * @method \Application\Model\Collection\EmailCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EmailCollection merge() merge(\Application\Model\Collection\EmailCollection $collection)
 * @method \Application\Model\Collection\EmailCollection diff() diff(\Application\Model\Collection\EmailCollection $collection)
 * @method \Application\Model\Collection\EmailCollection copy()
 */
class EmailCollection extends Collection{

    /**
     *
     * @param Email $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Email) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Email");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
       return $this->map(function (Email $email){
          return array($email->getIdEmail() => $email->getEmail());
       });
    }


}