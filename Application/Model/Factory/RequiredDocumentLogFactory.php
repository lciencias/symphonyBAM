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

use Application\Model\Bean\RequiredDocumentLog;

/**
 *
 * RequiredDocumentLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class RequiredDocumentLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\RequiredDocumentLog
     */
    public static function createFromArray($fields)
    {
        $requiredDocumentLog = new RequiredDocumentLog();
        self::populate($requiredDocumentLog, $fields);

        return $requiredDocumentLog;
    }

    /**
     *
     * @static
     * @param RequiredDocumentLog requiredDocumentLog
     * @param array $fields
     */
    public static function populate($requiredDocumentLog, $fields)
    {
        if( !($requiredDocumentLog instanceof RequiredDocumentLog) ){
            static::throwException("El objecto no es un RequiredDocumentLog");
        }

        if( isset($fields['id_required_document_log']) ){
            $requiredDocumentLog->setIdRequiredDocumentLog($fields['id_required_document_log']);
        }

        if( isset($fields['id_user']) ){
            $requiredDocumentLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_required_document']) ){
            $requiredDocumentLog->setIdRequiredDocument($fields['id_required_document']);
        }

        if( isset($fields['date_log']) ){
            $requiredDocumentLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $requiredDocumentLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $requiredDocumentLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws RequiredDocumentLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\RequiredDocumentLogException($message);
    }

}