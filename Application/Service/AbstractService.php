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


namespace Application\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 * AbstractService
 *
 * @category Application\Service
 * @author guadalupe, chente
 */
abstract class AbstractService
{

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     *
     * @var \Zend_Translate
     */
    protected $i18n;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher){
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    public function getEventDispatcher(){
        return $this->eventDispatcher;
    }

    /**
     *
     * @param \Zend_Translate $i18n
     */
    public function setI18n(\Zend_Translate $i18n){
        $this->i18n = $i18n;
    }

    /**
     *
     * @return \Zend_Translate
     */
    public function getI18n(){
        return $this->i18n;
    }

}
