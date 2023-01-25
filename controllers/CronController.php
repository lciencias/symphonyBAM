<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

use Application\Controller\BaseController;
use Application\Cron;
use Application\Security\CronCloseSession;

/**
 * Clase IndexController que representa el controller para la ruta default
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class CronController extends BaseController
{

    public function init(){
        parent::initI18n();
        parent::toView();
    }

    /**
     * Pantalla para despues del inicio de sesi�n
     */
    public function jobsAction()
    {
    	$now = new \Zend_Date();
    	echo 'Ejecutando el Cron...'.PHP_EOL;
    	echo $now->get('dd/MMM/yyyy a las hh:mm:ss') . PHP_EOL;
        $manager = new Cron\CronManager();
      	$manager->addCronable($this->getContainer()->get('cron_notification'));
        $manager->addCronable($this->getContainer()->get('cron_escalation'));
        $manager->addCronable(new CronCloseSession());
        $manager->run();
        $this->view->setLayoutFile(null);
        echo 'Fin de la ejecucion del cron: ';
        echo $now->get('dd/MMM/yyyy a las hh:mm:ss') . PHP_EOL . PHP_EOL;
        die();
    }
    
    public function productsAction(){
        $manager = new Cron\CronManager();
        $products = $this->getContainer()->get('cron_products');// 
        $manager->addCronable($products);
        $manager->run();
        $this->view->setLayoutFile(null);
        die();        
    }
    
    public function branchesAction(){
        $manager = new Cron\CronManager();
        $branch = $this->getContainer()->get('cron_branches');// 
        $manager->addCronable($branch);
        $manager->run();
        $this->view->setLayoutFile(null);
        die();        
    }

    public function ticketsAction(){
    	$manager = new Cron\CronManager();
    	$tickets = $this->getContainer()->get('cron_tickets');//
    	$manager->addCronable($tickets);
    	$manager->run();
    	$this->view->setLayoutFile(null);
    	die();
    }
    
}