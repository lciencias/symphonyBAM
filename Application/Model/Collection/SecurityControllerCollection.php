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

use Application\Model\Bean\SecurityController;

/**
 *
 * SecurityControllerCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\SecurityController current()
 * @method \Application\Model\Bean\SecurityController read()
 * @method \Application\Model\Bean\SecurityController getOne()
 * @method \Application\Model\Bean\SecurityController getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\SecurityControllerCollection intersect() intersect(\Application\Model\Collection\SecurityControllerCollection $collection)
 * @method \Application\Model\Collection\SecurityControllerCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\SecurityControllerCollection merge() merge(\Application\Model\Collection\SecurityControllerCollection $collection)
 * @method \Application\Model\Collection\SecurityControllerCollection diff() diff(\Application\Model\Collection\SecurityControllerCollection $collection)
 * @method \Application\Model\Collection\SecurityControllerCollection copy()
 */
class SecurityControllerCollection extends Collection{

    /**
     *
     * @param SecurityController $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof SecurityController) ){
            throw new \InvalidArgumentException("Debe de ser un objecto SecurityController");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(SecurityController $securityController){
            return array( $securityController->getIdController() => $securityController->getName() );
        });
    }

}