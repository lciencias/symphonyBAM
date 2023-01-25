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

use Application\Model\Bean\ClientResolution;

/**
 *
 * ClientResolutionFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientResolutionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientResolution
     */
    public static function createFromArray($fields)
    {
        $clientResolution = new ClientResolution();
        self::populate($clientResolution, $fields);

        return $clientResolution;
    }

    /**
     *
     * @static
     * @param ClientResolution clientResolution
     * @param array $fields
     */
    public static function populate($clientResolution, $fields)
    {
        if( !($clientResolution instanceof ClientResolution) ){
            static::throwException("El objecto no es un ClientResolution");
        }

        if( isset($fields['id_client_resolution']) ){
            $clientResolution->setIdClientResolution($fields['id_client_resolution']);
        }

        if( isset($fields['name']) ){
            $clientResolution->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $clientResolution->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $clientResolution->setStatus($fields['status']);
        }
        
        if( isset($fields['code']) ){
        	$clientResolution->setCode($fields['code']);
        }
     }

    /**
     * @throws ClientResolutionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientResolutionException($message);
    }

}