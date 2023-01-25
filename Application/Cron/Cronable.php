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

namespace Application\Cron;

/**
 * Interface Cronable
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 */
interface Cronable
{

    /**
     *
     * run
     */
    public function run();

    /**
     *
     * @return boolean
     */
    public function isActive();

    /**
     *
     * @return boolean
     */
    public function conditionToExecute();

    /**
     *
     * @param $now Zend_Date
     */
    public function setNow($now);

    /**
     *
     * @return Zend_Date
     */
    public function getNow();

    /**
     *
     * @param $nowPlus5 Zend_Date
     */
    public function setNowPlus5($nowPlus5);

    /**
     *
     * @return Zend_Date
     */
    public function getNowPlus5();

}
