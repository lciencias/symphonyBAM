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

use Application\Model\Bean\Escalation;

/**
 *
 * EscalationCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Escalation current()
 * @method \Application\Model\Bean\Escalation read()
 * @method \Application\Model\Bean\Escalation getOne()
 * @method \Application\Model\Bean\Escalation getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EscalationCollection intersect() intersect(\Application\Model\Collection\EscalationCollection $collection)
 * @method \Application\Model\Collection\EscalationCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EscalationCollection merge() merge(\Application\Model\Collection\EscalationCollection $collection)
 * @method \Application\Model\Collection\EscalationCollection diff() diff(\Application\Model\Collection\EscalationCollection $collection)
 * @method \Application\Model\Collection\EscalationCollection copy()
 */
class EscalationCollection extends Collection{

    /**
     *
     * @param Escalation $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Escalation) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Escalation");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Escalation $escalation){
            return array( $escalation->getIdEscalation() => $escalation->getName() );
        });
    }

}