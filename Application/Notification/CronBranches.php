<?php
/**
 * PCS Mexico
 *
 * Sistema de Distribucion
 *
 * @category   project
 * @package    Project_Notification
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http:),array(www.pcsmexico.com)
 * @author     
 * @version    1.0
 */

namespace Application\Notification;

use Application\Query\ScheduledNotificationQuery;
use Application\Managers\NotificationManager;
use Application\Cron\Cronable;
use Application\Webservice\WSClient;
use Application\Model\Catalog\BranchCatalog;
use Application\Model\Factory\BranchFactory;
use Application\Model\Bean\Branch;
use Application\Query\BranchQuery;
use Application\Manager\FixManager;

use Application\Controller\CrudController;

/**
 * Clase CronNotification
 */

class CronBranches implements Cronable
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

    /**
     *
     * @var unknown_type
     */
    protected $view;

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
        $query= $this->getCatalog('BranchCatalog');
        try {
            $WSClient = new WSClient();
            $branches = $WSClient->getBranchesWs();
            $query->beginTransaction();                 
            foreach($branches as $id => $branch){
            	$branch['domicilio'] = utf8_decode($branch['domicilio']); 
            	$branch['domicilio'] = utf8_decode($branch['domicilio']);
            	
            	$branch['estado']    = utf8_decode($branch['estado']);
            	$branch['estado']    = utf8_decode($branch['estado']);
            	
            	$branch['nombreSucursal'] = utf8_decode($branch['nombreSucursal']);
            	$branch['nombreSucursal'] = utf8_decode($branch['nombreSucursal']);
            	
            	$branch['horarios'] = utf8_decode($branch['horarios']);
            	$branch['horarios'] = utf8_decode($branch['horarios']);
				$branche = BranchQuery::create()->whereAdd(Branch::ID_BAM, array($branch['idbam']))->findOne();
                if(!$branche){
                	$estado=  \Application\Query\CountryStateQuery::create()->findByPK($branch['estado']);
                    if(!$estado)	
                    	continue;
                    $params=array(Branch::NAME => trim($branch['nombreSucursal']),
                    			  Branch::ID_BAM=>"".$branch['idbam']."", 
                    			  Branch::STATUS=> $branch['estatus'],
                    			  Branch::ID_COUNTRY_STATE=>$branch['estado'],
                                  Branch::ADDRESS=>trim($branch['domicilio']),
                    			  Branch::SCHEDULED=>trim($branch['horarios']));   
					$branche = BranchFactory::createFromArray($params);
                    $query->create($branche);   
                }
                else{
                	if( trim($branch['nombreSucursal']) != ""){
                		$branche->setName(trim($branch['nombreSucursal']));
                	}
                    $branche->setStatus($branch['estatus']);
                    if( trim($branch['domicilio']) != ""){
                    	$branche->setAddress(trim($branch['domicilio']));
                    }
                    if( trim($branch['estado']) != ""){
                    	$branche->setIdCountryState($branch['estado']);
                    }
                    if( trim($branch['horarios']) != ""){
                    	$branche->setScheduled(trim($branch['horarios']));
                    }
                    $query->update($branche);
                }
            }
            $query->commit();
        } catch (Exception $e) {
            echo $id;
            print_r($e);
        }
    }
    
    function Sustituto_Cadena($rb){
    	## Sustituyo caracteres en la cadena final
    	$rb = str_replace("á", "&aacute;", $rb);
    	$rb = str_replace("é", "&eacute;", $rb);
    	$rb = str_replace("®", "&reg;", $rb);
    	$rb = str_replace("í", "&iacute;", $rb);
    	$rb = str_replace("�", "&iacute;", $rb);
    	$rb = str_replace("ó", "&oacute;", $rb);
    	$rb = str_replace("ú", "&uacute;", $rb);
    	$rb = str_replace("n~", "&ntilde;", $rb);
    	$rb = str_replace("º", "&ordm;", $rb);
    	$rb = str_replace("ª", "&ordf;", $rb);
    	$rb = str_replace("Ã¡", "&aacute;", $rb);
    	$rb = str_replace("ñ", "&ntilde;", $rb);
    	$rb = str_replace("Ñ", "&Ntilde;", $rb);
    	$rb = str_replace("Ã±", "&ntilde;", $rb);
    	$rb = str_replace("n~", "&ntilde;", $rb);
    	$rb = str_replace("Ú", "&Uacute;", $rb);
    	return $rb;
    }
    
    /**
     * @return the $view
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param unknown_type $view
     */
    public function setView($view) {
        $this->view = $view;
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
