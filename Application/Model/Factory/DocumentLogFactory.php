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

use Application\Model\Bean\DocumentLog;

/**
 *
 * DocumentLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class DocumentLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\DocumentLog
     */
    public static function createFromArray($fields)
    {
        $documentLog = new DocumentLog();
        self::populate($documentLog, $fields);

        return $documentLog;
    }

    /**
     *
     * @static
     * @param DocumentLog documentLog
     * @param array $fields
     */
    public static function populate($documentLog, $fields)
    {
        if( !($documentLog instanceof DocumentLog) ){
            static::throwException("El objecto no es un DocumentLog");
        }

        if( isset($fields['id_document_log']) ){
            $documentLog->setIdDocumentLog($fields['id_document_log']);
        }

        if( isset($fields['id_document']) ){
            $documentLog->setIdDocument($fields['id_document']);
        }

        if( isset($fields['id_user']) ){
            $documentLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['date_log']) ){
            $documentLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $documentLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $documentLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws DocumentLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\DocumentLogException($message);
    }

}