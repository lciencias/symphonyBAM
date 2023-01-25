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
 * class CronManager
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 */
use EasyCSV\Exception;

class CronManager
{

    /**
     *
     * cron jobs
     * @var array
     */
    protected $cronables = array();

    /**
     *
     * add one cron job
     */
    public function addCronable(Cronable $cronable)
    {
        $this->cronables[] = $cronable;
    }

    /**
     *
     * run all cron jobs
     */
    public function run()
    {
        $now = new \Zend_Date();
        $nowPlus5 = clone $now;
        $nowPlus5->addMinute(6);
        $errors = array();
        $i = 0;
        foreach ($this->cronables as $cronable)
        {
        	$i++;
            if( $cronable instanceof Cronable ){
                $cronable->setNow(clone $now);
                $cronable->setNowPlus5(clone $nowPlus5);
                if( $cronable->isActive() && $cronable->conditionToExecute() ){
                    try {
                        $cronable->run();
                    } catch (\Exception $e) {
                    	throw $e;
                        $errors[] = $e->getMessage();
                    }
                }
            }
        }
        echo "Se ejecutaron". $i ." procesos".PHP_EOL;
        if ($errors)
		echo "Errores Generales" . PHP_EOL . implode(PHP_EOL, $errors);
			
    }

}
