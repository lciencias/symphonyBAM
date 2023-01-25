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

use Application\Model\Bean\EscalationDetail;

/**
 *
 * EscalationDetailCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\EscalationDetail current()
 * @method \Application\Model\Bean\EscalationDetail read()
 * @method \Application\Model\Bean\EscalationDetail getOne()
 * @method \Application\Model\Bean\EscalationDetail getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\EscalationDetailCollection intersect() intersect(\Application\Model\Collection\EscalationDetailCollection $collection)
 * @method \Application\Model\Collection\EscalationDetailCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\EscalationDetailCollection merge() merge(\Application\Model\Collection\EscalationDetailCollection $collection)
 * @method \Application\Model\Collection\EscalationDetailCollection diff() diff(\Application\Model\Collection\EscalationDetailCollection $collection)
 * @method \Application\Model\Collection\EscalationDetailCollection copy()
 */
class EscalationDetailCollection extends Collection{

    /**
     *
     * @param EscalationDetail $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof EscalationDetail) ){
            throw new \InvalidArgumentException("Debe de ser un objecto EscalationDetail");
        }
    }


}