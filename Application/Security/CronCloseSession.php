<?php
/**
 * PCS Mexico
 *
 * Sistema de Distribucion
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 * @author     Vicente Mendoza Moreno
 * @version    1.0
 */

namespace Application\Security;

use Application\Query\OptionQuery;
use Application\Cron\Cronable;
use Application\Model\Bean\Option;

/**
 * Clase CronNotification que representa el controller para la ruta default
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 */
class CronCloseSession implements Cronable
{

    /**
     *
     * @var Zend_Date
     */
    protected $now;

    /**
     *
     * @var Zend_Date
     */
    protected $nowPlus5;

    /* (non-PHPdoc)
     * @see Cronable::isActive()
     */
    public function isActive() {
        return true;
    }

    /* (non-PHPdoc)
     * @see Cronable::conditionToExecute()
     */
    public function conditionToExecute() {
        return true;
    }

    /**
     * (non-PHPdoc)
     * @see Application\Cron.Cronable::run()
     */
    public function run()
    {
        $lastRequest = new \Zend_Date();
        $lastRequest->subMinute(OptionQuery::create()->fetchSessionExpiration());
        $this->getCatalog('SessionCatalog')->deleteByLastRequest($lastRequest->get('yyyy-MM-dd HH:mm:ss'));
    }

    /**
     * @return Zend_Date
     */
    public function getNow() {
        return $this->now;
    }

    /**
     * @return Zend_Date
     */
    public function getNowPlus5() {
        return $this->nowPlus5;
    }

    /**
     * @param Zend_Date $now
     */
    public function setNow($now) {
        $this->now = $now;
    }

    /**
     * @param Zend_Date
     */
    public function setNowPlus5($nowPlus5) {
        $this->nowPlus5 = $nowPlus5;
    }

    /**
     *
     * @param unknown_type $catalog
     * @return \Application\Model\Catalog\Catalog
     */
    private function getCatalog($catalog){
        return \Zend_Registry::getInstance()->get('container')->get($catalog);
    }

}
