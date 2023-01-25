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

use Application\Model\Bean\RequiredDocument;

/**
 *
 * RequiredDocumentFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class RequiredDocumentFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\RequiredDocument
     */
    public static function createFromArray($fields)
    {
        $requiredDocument = new RequiredDocument();
        self::populate($requiredDocument, $fields);

        return $requiredDocument;
    }

    /**
     *
     * @static
     * @param RequiredDocument requiredDocument
     * @param array $fields
     */
    public static function populate($requiredDocument, $fields)
    {
        if( !($requiredDocument instanceof RequiredDocument) ){
            static::throwException("El objecto no es un RequiredDocument");
        }

        if( isset($fields['id_required_document']) ){
            $requiredDocument->setIdRequiredDocument($fields['id_required_document']);
        }

        if( isset($fields['id_client_category']) ){
            $requiredDocument->setIdClientCategory($fields['id_client_category']);
        }

        if( isset($fields['id_document']) ){
            $requiredDocument->setIdDocument($fields['id_document']);
        }
    }

    /**
     * @throws RequiredDocumentException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\RequiredDocumentException($message);
    }

}