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

use Application\Model\Bean\ControversyIssues;

/**
 *
 * ControversyIssuesFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class ControversyIssuesFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ControversyIssues
     */
    public static function createFromArray($fields)
    {
        $controversyIssues = new ControversyIssues();
        self::populate($controversyIssues, $fields);

        return $controversyIssues;
    }

    /**
     *
     * @static
     * @param ControversyIssues controversyIssues
     * @param array $fields
     */
    public static function populate($controversyIssues, $fields)
    {
        if( !($controversyIssues instanceof ControversyIssues) ){
            static::throwException("El objecto no es un ControversyIssues");
        }

        if( isset($fields['id_controversy_issue']) ){
            $controversyIssues->setIdControversyIssue($fields['id_controversy_issue']);
        }

        if( isset($fields['id_controversy_reason']) ){
            if($fields['id_controversy_reason'] == 0){
				$controversyIssues->setIdControversyReason(new \Zend_Db_Expr("NULL"));
            } else {
				$controversyIssues->setIdControversyReason($fields['id_controversy_reason']);
			}
        }

        if( isset($fields['name']) ){
            $controversyIssues->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $controversyIssues->setType($fields['type']);
        }
    }

    /**
     * @throws ControversyIssuesException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ControversyIssuesException($message);
    }

}