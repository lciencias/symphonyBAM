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

use Application\Model\Bean\ClientCategoryResolution;

/**
 *
 * ClientCategoryResolutionFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientCategoryResolutionFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientCategoryResolution
     */
    public static function createFromArray($fields)
    {
        $clientCategoryResolution = new ClientCategoryResolution();
        self::populate($clientCategoryResolution, $fields);

        return $clientCategoryResolution;
    }

    /**
     *
     * @static
     * @param ClientCategoryResolution clientCategoryResolution
     * @param array $fields
     */
    public static function populate($clientCategoryResolution, $fields)
    {
        if( !($clientCategoryResolution instanceof ClientCategoryResolution) ){
            static::throwException("El objecto no es un ClientCategoryResolution");
        }

        if( isset($fields['id_client_category_resolution']) ){
            $clientCategoryResolution->setIdClientCategoryResolution($fields['id_client_category_resolution']);
        }

        if( isset($fields['id_client_resolution']) ){
            $clientCategoryResolution->setIdClientResolution($fields['id_client_resolution']);
        }

        if( isset($fields['id_client_category']) ){
            $clientCategoryResolution->setIdClientCategory($fields['id_client_category']);
        }
    }

    /**
     * @throws ClientCategoryResolutionException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientCategoryResolutionException($message);
    }

}