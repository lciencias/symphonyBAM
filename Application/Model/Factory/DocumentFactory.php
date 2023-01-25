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

use Application\Model\Bean\Document;

/**
 *
 * DocumentFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class DocumentFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Document
     */
    public static function createFromArray($fields)
    {
        $document = new Document();
        self::populate($document, $fields);

        return $document;
    }

    /**
     *
     * @static
     * @param Document document
     * @param array $fields
     */
    public static function populate($document, $fields)
    {
        if( !($document instanceof Document) ){
            static::throwException("El objecto no es un Document");
        }

        if( isset($fields['id_document']) ){
            $document->setIdDocument($fields['id_document']);
        }

        if( isset($fields['name']) ){
            $document->setName($fields['name']);
        }

        if( isset($fields['type']) ){
            $document->setType($fields['type']);
        }

        if( isset($fields['status']) ){
            $document->setStatus($fields['status']);
        }
    }

    /**
     * @throws DocumentException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\DocumentException($message);
    }

}