<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Factory;

use Application\Model\Bean\Reasons;

/**
 *
 * ReasonsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ReasonsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Reasons
     */
    public static function createFromArray($fields)
    {
        $reasons = new Reasons();
        self::populate($reasons, $fields);

        return $reasons;
    }

    /**
     *
     * @static
     * @param Reasons reasons
     * @param array $fields
     */
    public static function populate($reasons, $fields)
    {
        if( !($reasons instanceof Reasons) ){
            static::throwException("El objecto no es un Reasons");
        }

        if( isset($fields['id_reason']) ){
            $reasons->setIdReason($fields['id_reason']);
        }

        if( isset($fields['name']) ){
            $reasons->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $reasons->setStatus($fields['status']);
        }
        if( isset($fields['partialities']) ){
            $reasons->setPartialities($fields['partialities']);
        }
        if( isset($fields['financial_movement']) ){
        	$reasons->setFinancialMovement($fields['financial_movement']);
        }
        if( isset($fields['type']) ){
        	$reasons->setType($fields['type']);
        }
        if( isset($fields['subtype']) ){
        	$reasons->setSubType($fields['subtype']);
        }
        if( isset($fields['movments']) ){
        	$reasons->setMovments($fields['movments']);
        }
        
    }

    /**
     * @throws ReasonsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ReasonsException($message);
    }

}