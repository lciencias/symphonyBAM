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

use Application\Model\Bean\Condition;

/**
 *
 * ConditionFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class ConditionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Condition
     */
    public static function createFromArray($fields)
    {
        $condition = new Condition();
        self::populate($condition, $fields);

        return $condition;
    }

    /**
     *
     * @static
     * @param Condition condition
     * @param array $fields
     */
    public static function populate($condition, $fields)
    {
        if( !($condition instanceof Condition) ){
            static::throwException("El objecto no es un Condition");
        }

        if( isset($fields['id_automata_condition']) ){
            $condition->setIdAutomataCondition($fields['id_automata_condition']);
        }

        if( isset($fields['id_element']) ){
            $condition->setIdElement($fields['id_element']);
        }

        if( isset($fields['name']) ){
            $condition->setName($fields['name']);
        }
    }

    /**
     * @throws ConditionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ConditionException($message);
    }

}