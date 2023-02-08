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

namespace Application\Storage;

/**
 *
 * StorageFactory
 *
 * @category Application\Storage
 * @author guadalupe, chente
 */
class StorageFactory
{

    /**
     * @staticvar array
     */
    private static $storages = array();

    /**
     * @param string|Storage
     * @return Storage
     */
    public static function create($name)
    {
        if( $name instanceOf Storage ){
            return $name;
        }

        if( null === $name || (is_string($name) && 'null' == $name) ){
            return self::lazyLoad('null', function(){
                return new OrNull();
            });
        }

        if( is_string($name) && 'memory' == $name ){
            return self::lazyLoad('memory', function(){
                return new Memory();
            });
        }

        if( is_string($name) && 'file' == $name ){
            return self::lazyLoad('file', function(){
                return new File();
            });
        }

        throw new \Exception("No existe el storage especificado ".$name);
    }

    /**
     * @param string $name
     * @param Closure $createStorageFn
     * @return Storage
     */
    private static function lazyLoad($name, $createStorageFn)
    {
        if( !isset(self::$storages[$name]) ){
            self::$storages[$name] = $createStorageFn();
        }

        return self::$storages[$name];
    }

}