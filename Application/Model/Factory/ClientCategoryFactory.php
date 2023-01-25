<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Factory;

use Application\Model\Bean\ClientCategory;

/**
 *
 * ClientCategoryFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientCategoryFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientCategory
     */
    public static function createFromArray($fields)
    {
        $clientCategory = new ClientCategory();
        self::populate($clientCategory, $fields);

        return $clientCategory;
    }

    /**
     *
     * @static
     * @param ClientCategory clientCategory
     * @param array $fields
     */
    public static function populate($clientCategory, $fields)
    {
        if( !($clientCategory instanceof ClientCategory) ){
            static::throwException("El objecto no es un ClientCategory");
        }

        if( isset($fields['id_client_category']) ){
            $clientCategory->setIdClientCategory($fields['id_client_category']);
        }

        if( isset($fields['id_ticket_type']) ){
            $clientCategory->setIdTicketType($fields['id_ticket_type']);
        }

        if( isset($fields['id_group']) ){
            $clientCategory->setIdGroup($fields['id_group']);
        }

        if( isset($fields['id_escalation']) ){
            $clientCategory->setIdEscalation($fields['id_escalation']);
        }

        if( isset($fields['id_service_level']) ){
            $clientCategory->setIdServiceLevel($fields['id_service_level']);
        }

        if( isset($fields['name']) ){
            $clientCategory->setName($fields['name']);
        }

        if( isset($fields['id_parent']) ){
            $clientCategory->setIdParent($fields['id_parent']);
        }

        if( isset($fields['status']) ){
            $clientCategory->setStatus($fields['status']);
        }

        if( isset($fields['is_leaf']) ){
            $clientCategory->setIsLeaf($fields['is_leaf']);
        }

        if( isset($fields['note']) ){
            $clientCategory->setNote($fields['note']);
        }
         if( isset($fields['partialities']) ){
            $clientCategory->setPartialities($fields['partialities']);
        }
        if( isset($fields['financial_movement']) ){
            $clientCategory->setFinancialMovement($fields['financial_movement']);
        }
        if( isset($fields['type']) ){
            $clientCategory->setType($fields['type']);
        }
        if( isset($fields['movments']) ){
            $clientCategory->setMovments($fields['movments']);
        }
        if( isset($fields['product']) ){
        	$clientCategory->setProduct($fields['product']);
        }
        if( isset($fields['motive']) ){
        	$clientCategory->setMotive($fields['motive']);
        }
        if( isset($fields['chanel']) ){
        	$clientCategory->setChannel($fields['chanel']);
        }      
    }

    /**
     * @throws ClientCategoryException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientCategoryException($message);
    }

}