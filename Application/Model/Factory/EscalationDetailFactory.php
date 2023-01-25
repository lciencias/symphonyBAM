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

use Application\Model\Bean\EscalationDetail;

/**
 *
 * EscalationDetailFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class EscalationDetailFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\EscalationDetail
     */
    public static function createFromArray($fields)
    {
        $escalationDetail = new EscalationDetail();
        self::populate($escalationDetail, $fields);

        return $escalationDetail;
    }

    /**
     *
     * @static
     * @param EscalationDetail escalationDetail
     * @param array $fields
     */
    public static function populate($escalationDetail, $fields)
    {
        if( !($escalationDetail instanceof EscalationDetail) ){
            static::throwException("El objecto no es un EscalationDetail");
        }

        if( isset($fields['id_escalation_details']) ){
            $escalationDetail->setIdEscalationDetails($fields['id_escalation_details']);
        }

        if( isset($fields['id_escalation']) ){
            $escalationDetail->setIdEscalation($fields['id_escalation']);
        }

        if( isset($fields['percentage']) ){
            $escalationDetail->setPercentage($fields['percentage']);
        }

        if( isset($fields['type']) ){
            $escalationDetail->setType($fields['type']);
        }

        if( isset($fields['value']) ){
            $escalationDetail->setValue($fields['value']);
        }
    }

    /**
     * @throws EscalationDetailException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\EscalationDetailException($message);
    }

}