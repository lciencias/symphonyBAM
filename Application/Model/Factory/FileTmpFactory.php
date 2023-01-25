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



use Application\Model\Bean\FileTmp;
/**
 *
 * FileFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class FileTmpFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\File
     */
    public static function createFromArray($fields)
    {
        $fileTmp = new FileTmp();
        self::populate($fileTmp, $fields);
        return $fileTmp;
    }

    /**
     *
     * @static
     * @param File file
     * @param array $fields
     */
    public static function populate($fileTmp, $fields)
    {
        if( !($fileTmp instanceof FileTmp) ){
            static::throwException("El objecto no es un FileTmp");
        }

        if( isset($fields['id_file']) ){
            $fileTmp->setIdFile($fields['id_file']);
        }

        if( isset($fields['uri']) ){
            $fileTmp->setUri($fields['uri']);
        }

        if( isset($fields['original_name']) ){
            $fileTmp->setOriginalName($fields['original_name']);
        }
        
        if( isset($fields['id_transaction']) ){
        	$fileTmp->setIdTransaction($fields['id_transaction']);
        }
        
        if( isset($fields['amount_deposit']) ){
        	$fileTmp->setAmountDeposit($fields['amount_deposit']);
        }
        
        if( isset($fields['date_deposit']) ){
        	$fileTmp->setDateDeposit($fields['date_deposit']);
        }
        
        if( isset($fields['type_deposit']) ){
        	$fileTmp->setTypeDeposit($fields['type_deposit']);
        }
        
        if( isset($fields['id_session']) ){
        	$fileTmp->setIdSession($fields['id_session']);
        }
    }

    /**
     * @throws FileException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\FileTmpException($message);
    }

}