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
 * Memory
 *
 * @category Application\Storage
 * @author guadalupe, chente
 */
class Memory implements Storage
{

    /**
     *
     * @staticvar array $cache
     */
    private static $cache = array();

    /**
     * Save
     * @param string $key
     * @param mixed $object
     */
    public function save($key, $object){
        self::$cache[$key] = $object;
    }

    /**
     * Load
     * @param string $key
     * @return mixed
     */
    public function load($key){
        if( !$this->exists($key) ){
            return null;
        }
        return self::$cache[$key];
    }

    /**
     * Exists
     * @param string
     * @return boolean
     */
    public function exists($key){
        return array_key_exists($key, self::$cache);
    }

    /**
     * Delete cache
     */
    public function removeAll(){
        self::$cache = array();
    }

    /**
     *
     */
    public function remove($key){
        unset(self::$cache[$key]);
    }

}