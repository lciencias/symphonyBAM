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

use Application\Model\Bean\ControversyReasons;

/**
 *
 * ControversyReasonsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ControversyReasonsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ControversyReasons
     */
    public static function createFromArray($fields)
    {
        $controversyReasons = new ControversyReasons();
        self::populate($controversyReasons, $fields);

        return $controversyReasons;
    }

    /**
     *
     * @static
     * @param ControversyReasons controversyReasons
     * @param array $fields
     */
    public static function populate($controversyReasons, $fields)
    {
        if( !($controversyReasons instanceof ControversyReasons) ){
            static::throwException("El objecto no es un ControversyReasons");
        }

        if( isset($fields['id_controversy_reason']) ){
            $controversyReasons->setIdControversyReason($fields['id_controversy_reason']);
        }

        if( isset($fields['name']) ){
            $controversyReasons->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $controversyReasons->setStatus($fields['status']);
        }

        if( isset($fields['type']) ){
            $controversyReasons->setType($fields['type']);
        }

        if( isset($fields['debit_time']) ){
            $controversyReasons->setDebitTime($fields['debit_time']);
        }
    }

    /**
     * @throws ControversyReasonsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ControversyReasonsException($message);
    }

}