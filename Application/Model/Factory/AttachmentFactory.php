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

use Application\Model\Bean\Attachment;

/**
 *
 * AttachmentFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class AttachmentFactory extends FileFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Attachment
     */
    public static function createFromArray($fields)
    {
        $attachment = new Attachment();
        self::populate($attachment, $fields);

        return $attachment;
    }

    /**
     *
     * @static
     * @param Attachment attachment
     * @param array $fields
     */
    public static function populate($attachment, $fields)
    {
        parent::populate($attachment, $fields);
        if( !($attachment instanceof Attachment) ){
            static::throwException("El objecto no es un Attachment");
        }

        if( isset($fields['id_attachment']) ){
            $attachment->setIdAttachment($fields['id_attachment']);
        }

        if( isset($fields['id_base_ticket']) ){
            $attachment->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_file']) ){
            $attachment->setIdFile($fields['id_file']);
        }

        if( isset($fields['id_user']) ){
            $attachment->setIdUser($fields['id_user']);
        }

        if( isset($fields['created_at']) ){
            $attachment->setCreatedAt($fields['created_at']);
        }
    }

    /**
     * @throws AttachmentException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AttachmentException($message);
    }

}