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

use Application\Model\Bean\Session;

/**
 *
 * SessionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Session current()
 * @method \Application\Model\Bean\Session read()
 * @method \Application\Model\Bean\Session getOne()
 * @method \Application\Model\Bean\Session getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\SessionCollection intersect() intersect(\Application\Model\Collection\SessionCollection $collection)
 * @method \Application\Model\Collection\SessionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\SessionCollection merge() merge(\Application\Model\Collection\SessionCollection $collection)
 * @method \Application\Model\Collection\SessionCollection diff() diff(\Application\Model\Collection\SessionCollection $collection)
 * @method \Application\Model\Collection\SessionCollection copy()
 */
class SessionCollection extends Collection{

    /**
     *
     * @param Session $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Session) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Session");
        }
    }

    /**
     *
     * @return array
     */
    public function getUserIds(){
        return $this->map(function (Session $session){
           return array( $session->getIdUser() => $session->getIdUser() );
        });
    }


}