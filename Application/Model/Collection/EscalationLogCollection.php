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

use Application\Model\Bean\EscalationLog;

/**
 *
 * EscalationLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EscalationLog current()
 * @method \Application\Model\Bean\EscalationLog read()
 * @method \Application\Model\Bean\EscalationLog getOne()
 * @method \Application\Model\Bean\EscalationLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EscalationLogCollection intersect() intersect(\Application\Model\Collection\EscalationLogCollection $collection)
 * @method \Application\Model\Collection\EscalationLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EscalationLogCollection merge() merge(\Application\Model\Collection\EscalationLogCollection $collection)
 * @method \Application\Model\Collection\EscalationLogCollection diff() diff(\Application\Model\Collection\EscalationLogCollection $collection)
 * @method \Application\Model\Collection\EscalationLogCollection copy()
 */
class EscalationLogCollection extends Collection{

    /**
     *
     * @param EscalationLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof EscalationLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto EscalationLog");
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