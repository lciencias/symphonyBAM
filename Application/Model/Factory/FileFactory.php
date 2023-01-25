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

use Application\Model\Bean\File;

/**
 *
 * FileFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class FileFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\File
     */
    public static function createFromArray($fields)
    {
        $file = new File();
        self::populate($file, $fields);

        return $file;
    }

    /**
     *
     * @static
     * @param File file
     * @param array $fields
     */
    public static function populate($file, $fields)
    {
        if( !($file instanceof File) ){
            static::throwException("El objecto no es un File");
        }

        if( isset($fields['id_file']) ){
            $file->setIdFile($fields['id_file']);
        }

        if( isset($fields['uri']) ){
            $file->setUri($fields['uri']);
        }

        if( isset($fields['original_name']) ){
            $file->setOriginalName($fields['original_name']);
        }
    }

    /**
     * @throws FileException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\FileException($message);
    }

}