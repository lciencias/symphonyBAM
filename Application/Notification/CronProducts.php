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
use Application\Model\Catalog\ProductsCatalog;
use Application\Model\Factory\ProductsFactory;
use Application\Model\Bean\Products;
use Application\Query\ProductsQuery;

use Application\Controller\CrudController;

/**
 * Clase CronNotification
 */

class CronProducts implements Cronable
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
        $query= $this->getCatalog('ProductsCatalog');
        try {
                    $WSClient = new WSClient();
                    $products = $WSClient->getProductsBase();
                    $query->beginTransaction();
                    
                    
                    $update="Update pcs_symphony_products set status = 2;";
                    $query->getDb()->query($update);
                    
                    foreach($products as $id=>$product){
                                $product['nombreProducto']=  utf8_decode($product['nombreProducto']);
                                $producto = ProductsQuery::create()->whereAdd(Products::ID_PRODUCT_BAM, $id)->findOne();
                                if(!$producto){
                                $params=array(Products::NAME=>$product['nombreProducto'],  Products::ID_PRODUCT_BAM=>$product['idBam'],  Products::STATUS=>($product['estatus'])?$product['estatus']:1);    
                                $producto = ProductsFactory::createFromArray($params);
                                $query->create($producto);   
                                }else{
                                $producto->setName($product['nombreProducto']);
                                $producto->setStatus(($product['estatus'])?$product['estatus']:1);
                                $query->update($producto);
                                }
                    }
                    $query->commit();
        } catch (Exception $e) {
            print_r($e);
        }
        
    }
    
    
    /**
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getProductsCatalog(){
        return $this->getContainer()->get('ProductsCatalog');
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
