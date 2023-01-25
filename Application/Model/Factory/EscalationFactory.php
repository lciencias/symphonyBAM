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

namespace Application\Model\Factory;

use Application\Model\Bean\Escalation;

/**
 *
 * EscalationFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EscalationFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Escalation
     */
    public static function createFromArray($fields)
    {
        $escalation = new Escalation();
        self::populate($escalation, $fields);

        return $escalation;
    }

    /**
     *
     * @static
     * @param Escalation escalation
     * @param array $fields
     */
    public static function populate($escalation, $fields)
    {
        if( !($escalation instanceof Escalation) ){
            static::throwException("El objecto no es un Escalation");
        }

        if( isset($fields['id_escalation']) ){
            $escalation->setIdEscalation($fields['id_escalation']);
        }

        if( isset($fields['name']) ){
            $escalation->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $escalation->setStatus($fields['status']);
        }
    }

    /**
     * @throws EscalationException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EscalationException($message);
    }

}