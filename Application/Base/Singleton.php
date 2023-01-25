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

namespace Application\Base;

/**
 *
 * Singleton
 *
 * @category Application\Base
 * @author guadalupe, chente
 */
abstract class Singleton
{

    /**
     *
     *
     * @var array
     */
    private static $instances = array();

    /**
     *
     *
     */
    final private function __construct(){}

    /**
     *
     *
     */
    final private function __clone(){}

    /**
     *
     *
     */
    final public static function getInstance(){
        $class = get_called_class();
        if( !isset(self::$instances[$class]) ){
            self::$instances[$class] = new static();
        }
        return self::$instances[$class];
    }
}