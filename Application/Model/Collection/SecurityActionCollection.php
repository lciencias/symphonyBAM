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

use Application\Model\Bean\SecurityAction;

/**
 *
 * SecurityActionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\SecurityAction current()
 * @method \Application\Model\Bean\SecurityAction read()
 * @method \Application\Model\Bean\SecurityAction getOne()
 * @method \Application\Model\Bean\SecurityAction getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\SecurityActionCollection intersect() intersect(\Application\Model\Collection\SecurityActionCollection $collection)
 * @method \Application\Model\Collection\SecurityActionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\SecurityActionCollection merge() merge(\Application\Model\Collection\SecurityActionCollection $collection)
 * @method \Application\Model\Collection\SecurityActionCollection diff() diff(\Application\Model\Collection\SecurityActionCollection $collection)
 * @method \Application\Model\Collection\SecurityActionCollection copy()
 */
class SecurityActionCollection extends Collection{

    /**
     *
     * @param SecurityAction $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof SecurityAction) ){
            throw new \InvalidArgumentException("Debe de ser un objecto SecurityAction");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(SecurityAction $securityAction){
            return array( $securityAction->getIdAction() => $securityAction->getName() );
        });
    }

}