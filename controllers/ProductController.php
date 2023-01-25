<?php
use Application\Controller\BaseController;
use Application\Query\ProductsQuery;
use Application\Model\Bean\Products;
use Application\Model\Factory\ProductsFactory;
use Application\Query\UserQuery;
use Application\Model\Bean\User;
use Application\Model\Catalog\ProductsCatalog;
/**
 *
 *
 * Fecha: 14/11/2016<br>
 * Empresa: PCS Mexico <br>
 * Lenguaje: PHP<br>
 * 
 * @package
 *
 * @version 1
 * @author 
 *        
 */
class ProductController extends BaseController {
    /**
     * 
     * @author 
     * @access public
     * @module Producto 
     * @action List
     */
    public function indexAction() {
        $params = $this->getRequest ()->getParams ();
//         print_r($params);
//         die();
        $ProductCollection = ProductsQuery::create ()->filter ( $params )->find ();
        $this->view->ProductCollection = $ProductCollection;
        $this->view->statuses = $this->toFilterSelect(Products::$Status);
    }
    /**
     * 
     * Formulario de creación y modificación
     * @author 
     * @access public
     * @module Producto 
     * @action Crear/Actualizar
     */
    public function formAction() {
        $id = $this->getRequest()->getParam('id') ? : -1;
        $products = ProductsQuery::create()->findByPK($id);
        $this->view->product = $products ? $products : new Products();
    }
    /**
     * 
     * Acción para guardar los productos
     * @author 
     * @access public
     * @module Producto 
     * @action Crear/Actualizar
     */
    public function saveAction() {
        $Products = ProductsFactory::createFromArray($this->getRequest()->getParams());
        $this->getProductsCatalog()->beginTransaction();
       
        try {
        	
            if ($Products->getIdProduct()){
                $this->getProductsCatalog()->update($Products);
               // $this->newLogForUpdate($Products);
                $this->setFlash('ok', "Se ha actualizado el producto con el id ". $Products->getIdProduct());
                
            }
            else{
                $this->getProductsCatalog()->create($Products);
                $Products->setStatus(1);
                //$this->newLogForCreate($Products);
                $this->setFlash('ok', "Se ha creado el producto con el id ". $Products->getIdProduct());
            }
        
        } catch (Exception $e) {
            $this->getProductsCatalog()->rollBack();
            $this->setFlash('error', $e->getMessage());
        }
        $this->getProductsCatalog()->commit();
        $this->_redirect('product');
    }
    /**
     *
     * Desactiva un elemento
     * @author 
     * @access public
     * @return string Mensaje del resultado
     * @module Producto 
     * @action Desactivar
     * 
     **/
    public function disableAction(){
    	
        $id = $this->getRequest()->getParam('id') ? : -1;
        $Products = ProductsQuery::create()->findByPK($id);
        $this->getProductsCatalog()->beginTransaction();
        try {
            if(!$Products)
                throw new Exception('El producto no existe');
            $Products->setStatus(Products::$Status['Inactive']);
            $this->getProductsCatalog()->update($Products);
           // $this->newLogForDisable($Products);
            $this->setFlash('ok', "Se ha desactivado el producto con el id ". $Products->getIdProduct());
        } catch (Exception $e) {
            $this->getProductsCatalog()->rollBack();
            $this->setFlash('error', $e->getMessage());
        }
        $this->getProductsCatalog()->commit();
        $this->_redirect('product');
    }
    /**
     *
     * Activa un elemento
     * @author 
     * @access public
     * @return string Mensaje del resultado
     * @module Producto 
     * @action Activar
     *
     **/
    public function enableAction(){
        $id = $this->getRequest()->getParam('id') ? : -1;
        $Products = ProductsQuery::create()->findByPK($id);
        $this->getProductsCatalog()->beginTransaction();
        try {
            if(!$Products)
                throw new Exception('El producto no existe');
            $Products->setStatus(Products::$Status['Active']);
            $this->getProductsCatalog()->update($Products);
            //$this->newLogForEnable($Products);
            $this->setFlash('ok', "Se ha activado el producto con el id ". $Products->getIdProduct());
        } catch (Exception $e) {
            $this->getProductsCatalog()->rollBack();
            $this->setFlash('error', $e->getMessage());
        }
        $this->getProductsCatalog()->commit();
        $this->_redirect('product');
    }
    /**
     *
     * Activa un elemento
     * @author 
     * @access public
     * @return string Mensaje del resultado
     * @module Producto 
     * @action Tracking
     *
     **/
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $ProductLogCollection = ProductLogQuery::create()->whereAdd(ProductLog::ID__PRODUCT, $id)->find();
        $this->view->users = UserQuery::create()->whereAdd(User::ID_USER, $ProductLogCollection->getUserIds())->find();
    	$this->view->logs = $ProductLogCollection;
    }
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @return \Application\Model\Bean\ProductLog
     */
    protected function newLogForCreate(Products $Products){
        return $this->newLog($Products, ProductLog::$EventTypes['Create'] );
    }
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @return \Application\Model\Bean\ProductLog
     */
    private function newLogForUpdate(Products $Products){
        return $this->newLog($Products, ProductLog::$EventTypes['Update'] );
    }
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @return \Application\Model\Bean\ProductLog
     */
    private function newLogForDisable(Products $Products){
        return $this->newLog($Products, ProductLog::$EventTypes['Disable'] );
    }
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @return \Application\Model\Bean\ProductLog
     */
    private function newLogForEnable(Products $Products){
        return $this->newLog($Products, ProductLog::$EventTypes['Enable'] );
    }
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @param int $eventType
     * @return \Application\Model\Bean\ProductLog
     */
    private function newLog(Products $Products, $eventType){
        $now = \Zend_Date::now();
        $log = ProductLogFactory::createFromArray(array(
            'id__product' => $Products->getIdProduct(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getProductLogCatalog()->create($log);
        return $log;
    }
    /**
     * 
     * 
     * @author 
     * @access private
     * @return \Application\Model\Catalog\ProductCatalog
     **/
    private function getProductsCatalog() {
    	return $this->getContainer()->get('ProductsCatalog');
    }
    /**
     *
     *
     * @author 
     * @access private
     * @return \Application\Model\Catalog\ProductCatalog
     **/
    private function getProductLogCatalog() {
        return $this->getContainer()->get('ProductLogCatalog');
    }
    
    /**
     * @author 
     * @access private
     * @param Products $Products
     * @return \Application\Model\Bean\ProductLog
     */
    public function syncAction(){
        
    }
}