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

use Zend\Cache\Cache;

/**
 *
 * Chain
 *
 * @category Application\Storage
 * @author guadalupe, chente
 */
class Chain implements Storage
{

    /**
     * @var Storage
     */
    private $primaryStorage;

    /**
     * @var Storage
     */
    private $secondaryStorage;

    /**
     * @param Storage $primaryStorage
     * @param Storage $secodaryStorage
     */
    public function __construct(Storage $primaryStorage, Storage $secondaryStorage)
    {
        $this->primaryStorage = $primaryStorage;
        $this->secondaryStorage = $secondaryStorage;
    }

    /**
     * Save
     * @param string $key
     * @param mixed $object
     */
    public function save($key, $object){
        $this->primaryStorage->save($key, $object);
        $this->secondaryStorage->save($key, $object);
    }

    /**
     * Load
     * @param string $key
     * @return mixed
     */
    public function load($key)
    {
        if( !$this->exists($key) ){
            return null;
        }

        if( $this->primaryStorage->exists($key) ){
            return $this->primaryStorage->load($key);
        }

        if( $this->secondaryStorage->exists($key) ){
            $object = $this->secondaryStorage->load($key);
            $this->primaryStorage->save($key, $object);
            return $object;
        }
    }

    /**
     * Exists
     * @param string
     * @return boolean
     */
    public function exists($key){
        return $this->primaryStorage->exists($key) ||
        $this->secondaryStorage->exists($key);
    }

    /**
     * Delete cache
     */
    public function removeAll(){
        $this->primaryStorage->removeAll();
        $this->secondaryStorage->removeAll();
    }

    /**
     *
     */
    public function remove($key){
        $this->primaryStorage->remove($key);
        $this->secondaryStorage->remove($key);
    }

}