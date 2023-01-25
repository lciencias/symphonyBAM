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

use Application\Model\Bean\Comments;

/**
 *
 * CommentsFactory
 *
 * @category Application\Model\Factory
 * @author Luis Hernandez
 */
use Zend_Db;

class CommentsFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Comments
     */
    public static function createFromArray($fields)
    {
        $comments = new Comments();
        self::populate($comments, $fields);

        return $comments;
    }

    /**
     *
     * @static
     * @param Comments comments
     * @param array $fields
     */
    public static function populate($comments, $fields)
    {
        if( !($comments instanceof Comments) ){
            static::throwException("El objecto no es un Comments");
        }

        if( isset($fields['id_comment']) ){
            $comments->setIdComment($fields['id_comment']);
        }

        if( isset($fields['id_base_ticket']) ){
            $comments->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_user_origin']) ){
            $comments->setIdUserOrigin($fields['id_user_origin']);
        }

        if( isset($fields['id_user_destiny']) ){
            $comments->setIdUserDestiny($fields['id_user_destiny']);
        }

        if( isset($fields['creation_date']) ){
            $comments->setCreationDate($fields['creation_date']);
        }

        if( isset($fields['note']) ){
            $comments->setNote($fields['note']);
        }
    }

    /**
     * @throws CommentsException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CommentsException($message);
    }

}