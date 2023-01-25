<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

use Application\Model\Catalog\ReasonsCatalog;
use Application\Model\Factory\ReasonsFactory;
use Application\Model\Metadata\ReasonsMetadata;
use Application\Model\Bean\Reasons;
use Application\Query\ReasonsQuery;
use Application\Query\UserQuery;
use Application\Form\ReasonsForm;
use Application\Query\ProductsQuery;
use Application\Model\Bean\Products;

require_once 'dompdf/dompdf_config.inc.php';

use Application\Controller\CrudController;

/**
 *
 * 
 */
class ReasonsController extends CrudController{
    
    /**
     *
     * @module Channel
     * @action List
     */
    public function indexAction(){
        return $this->_forward('list');
    }
    
        /**
     *
     * @module Channel
     * @action List
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }
        $optionsProducts=ProductsQuery::create()->actives()->find()->toCombo();
        $optionsProducts[0]=$this->i18n->_('Select');
        
        $list="SELECT a.id_reason,b.name as product FROM pcs_symphony_reasons_products a "
                . "INNER JOIN pcs_symphony_products b ON a.id_product=b.id_product";
        $queryProduct=$this->getReasonsCatalog()->getDb()->fetchAll($list);
        foreach($queryProduct as $products){
            $listProducts[$products['id_reason']][]=$products['product'];
        }
        
        if($post['id_product']>0){ 
            
            $this->view->reasons =$reasons = ReasonsQuery::create()
                    ->distinct()
                    ->addColumn("Reasons.".Reasons::ID_REASON)
                    ->addColumn("Reasons.".Reasons::NAME)
                    ->addColumn("Reasons.".Reasons::STATUS)
                    ->filter($post)
                    ->innerJoinProducts()
                    ->whereAdd("Reason2Product.id_product", $post['id_product'])
                    ->addAscendingOrderBy(Reasons::NAME)
            ->page($page, $this->getMaxPerPage())
            ->find();
            $total=$reasons->count();
            
        }else{
        $total = ReasonsQuery::create()->filter($post)->count();
        $this->view->reasons = $reasons = ReasonsQuery::create()
            ->filter($post)
                ->addAscendingOrderBy(Reasons::NAME)
            ->page($page, $this->getMaxPerPage())
            ->find();    
        }

        $this->view->listProducts = $listProducts;
        $this->view->optionProducts = $optionsProducts;
        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(Reasons::$Status);

    }
    
    /**
     *
     * @module Channel
     * @action Create
     */
    public function newAction()
    {
        $url = $this->generateUrl('reasons', 'create');
        $this->view->form = $this->getForm()->setAction($url);
        $products=ProductsQuery::create()->find();
        
        $this->view->products=$products;
    }
    
    /**
     *
     * @module Channel
     * @action Edit
     */
    public function editAction()
    {

            $id = $this->getRequest()->getParam('id');
            if(!$id)$this->_redirect('reasons/list');
            $reason = ReasonsQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Reasons with id {$id}"));
            $products=ProductsQuery::create()->actives()->find();
            $productsSelect="SELECT id_product FROM pcs_symphony_reasons_products WHERE id_reason='$id'";
            $listProduct=$this->getReasonsCatalog()->getDb()->fetchCol($productsSelect);
            
            $this->view->typeReason= $typeReason=  $this->translateCombo(array(''=>"Seleccione",0=>"Consulta",1=>"Aclaración"));
            $array=array_flip(Reasons::$subtypes);
            $this->view->subtype=$subtype=$this->translateCombo($array);
            
            $this->view->listProducts=$listProduct;
            $this->view->products=$products;
            $this->view->reason=$reason;
            
            
            
            if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();    
            $name=$params['name'];
            $findSql="SELECT * FROM ".Reasons::TABLENAME." WHERE UPPER(".Reasons::NAME.") = UPPER('".$name."') AND id_reason !='$id'";
            $findQuery=$this->getReasonsCatalog()->getDb()->fetchAll($findSql);
            
            if(count($findQuery)>0 || count($params['productsIds'])==0){
                $error=(count($findQuery)>0)?"The reason already exist":"Seleccione al menos un producto";
                $this->view->errors=$error;
                $this->view->setTpl("Update");
                return;
            }
            else{
                try
                {
                    $this->getReasonsCatalog()->beginTransaction();

                    ReasonsFactory::populate($reason, $params);
                    $partialities=($params['partialities'])?"1":"0";
                    $finantialMovements=($params['financial_movement'])?"1":"0";
                    if($params['type']==1)// si es aclaraciones 
                    $reason->setSubType ('');
                    $reason->setPartialities($partialities);
                    $reason->setFinancialMovement($finantialMovements);
                    
                    $this->getReasonsCatalog()->update($reason);
                    //elimina todos y vuelve a crear todos
                    $delete="DELETE FROM pcs_symphony_reasons_products WHERE id_reason='$id'";
                    $this->getReasonsCatalog()->getDb()->query($delete);
                    foreach($params['productsIds'] as $id){
                       $insert="INSERT INTO pcs_symphony_reasons_products(id_reason,id_product) VALUES(".$reason->getIdReason().",$id)";
                       $this->getReasonsCatalog()->getDb()->query($insert);
                    }



                    $this->getReasonsCatalog()->commit();
                    $this->setFlash('ok', $this->i18n->_("The Reason was updated correctly"));
                    $this->_redirect('reasons/list');
                }
                catch(Exception $e)
                {
                    $this->getReasonsCatalog()->rollBack();
                    $this->setFlash('error', $this->i18n->_($e->getMessage()));
                }
            }    

        }
        $this->view->setTpl("Update");
    }
    
    
     /**
     *
     * @module Channel
     * @action Create
     */
    public function createAction()
    {
        $form = $this->getForm();
        $products=ProductsQuery::create()->actives()->find();
        $this->view->typeReason= $typeReason=  $this->translateCombo(array(''=>"Seleccione",0=>"Consulta",1=>"Aclaración"));
        $array=array_flip(Reasons::$subtypes);
//        print_r($array);
        $this->view->subtype=$subtype=$this->translateCombo($array);
        
        $this->view->products=$products;
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           
           // validar que el nombre no exista
            $params['name']=TRIM($params['name']);
            $name=$params['name'];
            $findSql="SELECT * FROM ".Reasons::TABLENAME." WHERE UPPER(".Reasons::NAME.") = UPPER('".$name."')";
            $findQuery=$this->getReasonsCatalog()->getDb()->fetchAll($findSql);
            
            if(count($findQuery)>0 || count($params['productsIds'])==0){
                $error=(count($findQuery)>0)?"The reason already exist":"Please select at least one product";
                $this->view->errors=$error;
                $this->view->tmpName=$name;
                $this->view->tmpType=$params['type'];
                $this->view->tmpSubtype=$params['subtype'];
                $this->view->tmpMovments=$params['movments'];
                $this->view->setTpl("Create");
                return;
            }
            else
        {
        
           try
           {
               $this->getReasonsCatalog()->beginTransaction();

               $reason = ReasonsFactory::createFromArray($params);
               $reason->setStatus(Reasons::$Status['Active']);
               $partialities=($params['partialities'])?"1":"0";
               $finantialMovements=($params['financial_movement'])?"1":"0";
               $reason->setPartialities($partialities);
               $reason->setFinancialMovement($finantialMovements);
               $this->getReasonsCatalog()->create($reason);
               foreach($params['productsIds'] as $id){
                   $insert="INSERT INTO pcs_symphony_reasons_products(id_reason,id_product) VALUES(".$reason->getIdReason().",$id)";
                   $this->getReasonsCatalog()->getDb()->query($insert);
                   
               }
               
               
//               $this->newLogForCreate($reason);

               $this->getReasonsCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Reason was created correctly"));
               $this->_redirect('reasons/list');
               
           }
           catch(Exception $e)
           {
               $this->getReasonsCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        }
        
//        $this->_redirect('reasons/list');
    }

    /**
     * Metodo
     * {@inheritDoc}
     * @see \Application\Controller\CrudController::updateAction()
     */
        public function updateAction() // ESTE NO FUNCIONA
    {
            
            $id = $this->getRequest()->getParam('id');
            $reason = ReasonsQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Reasons with id {$id}"));
            $products=ProductsQuery::create()->actives()->find();
            $productsSelect="SELECT id_product FROM pcs_symphony_reasons_products WHERE id_reason='$id'";
            $listProduct=$this->getReasonsCatalog()->getDb()->fetchCol($productsSelect);
            
            
            $this->view->listProducts=$listProduct;
            $this->view->products=$products;
            $this->view->reason=$reason;
            
            
            
            if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();    
            $name=$params['name'];
            $findSql="SELECT * FROM ".Reasons::TABLENAME." WHERE UPPER(".Reasons::NAME.") LIKE UPPER('%".$name."%')";
            $findQuery=$this->getReasonsCatalog()->getDb()->fetchAll($findSql);
            
            if(count($findQuery)>0 || count($params['productsIds'])==0){
                $error=(count($findQuery)>0)?"The reason already exist":"Please select at least one product";
                $this->view->errors=$error;
                $this->view->setTpl("Update");
            }

            

            try
            {
                $this->getReasonsCatalog()->beginTransaction();

                ReasonsFactory::populate($reason, $params);
                $partialities=($params['partialities'])?"1":"0";
                $reason->setPartialities($partialities);
                $this->getReasonsCatalog()->update($reason);
                print_r($reason);
                //elimina todos y vuelve a crear todos
                $delete="DELETE FROM pcs_symphony_reasons_products WHERE id_reason='$id'";
                $this->getReasonsCatalog()->getDb()->query($delete);
                foreach($params['productsIds'] as $id){
                   $insert="INSERT INTO pcs_symphony_reasons_products(id_reason,id_product) VALUES(".$reason->getIdReason().",$id)";
                   $this->getReasonsCatalog()->getDb()->query($insert);
                }
                
                

                $this->getReasonsCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Reason was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getReasonsCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
                    $this->_redirect('reasons/list');

        }
        $this->view->setTpl("Update");
    }
    
    /**
     * @module Channel
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $reason = ReasonsQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Reasons with id {$id}"));

        try
        {
            $this->getReasonsCatalog()->beginTransaction();

            $reason->setStatus(Reasons::$Status['Inactive']);
            $this->getReasonsCatalog()->update($reason);
//            $this->newLogForDelete($channel);

            $this->getReasonsCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Reasons was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getReasonsCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('reasons/list');
    }

    /**
     * @module Channel
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $reason = ReasonsQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Reason with id {$id}"));

        try
        {
            $this->getReasonsCatalog()->beginTransaction();

            $reason->setStatus(Reasons::$Status['Active']);
            $this->getReasonsCatalog()->update($reason);
//            $this->newLogForReactivate($reason);

            $this->getReasonsCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Reason was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getReasonsCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('reasons/list');
    }
    
     /**
     * @module Channel
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $channel = ReasonsQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Reason with id {$id}"));
//        $this->view->channelLogs = $logs = ChannelLogQuery::create()->whereAdd('id_channel', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }
    
    /**
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getReasonsCatalog(){
        return $this->getContainer()->get('ReasonsCatalog');
    }
    
     /**
     * @param Channel $channel
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function newLogForCreate(Reasons $reasons){
        return $this->newLog($reasons, \Application\Model\Bean\ReasonslogLog::$EventTypes['Create'] );
    }

    /**
     *
     * @return Application\Form\ChannelForm
     */
    protected function getForm()
    {
        $form = new ReasonsForm();
        $submit = new Zend_Form_Element_Submit("send");
        $submit->setLabel($this->i18n->_("Save"));
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setLabel($this->i18n->_("Cancel"));
        $form->addElement($submit)
            ->addElement($cancel)
            ->setMethod('post');

        $form->twitterDecorators();

        return $form;
    }
    
   
    private function utf8_encode_array($array) {
        foreach($array as $key => $value)
       {
           if(is_array($value))
               $array[$key] = self::utf8_encode_array($value);
           else
               $array[$key] = utf8_encode($value);
       }
       return $array;
    }   



    public function cleanCaracteres($String) {
    $String=  strtolower(trim($String));
    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
    $String = str_replace(array('Á','À','Â','Ã','Ä'),"a",$String);
    $String = str_replace(array('Í','Ì','Î','Ï'),"i",$String);
    $String = str_replace(array('í','ì','î','ï'),"i",$String);
    $String = str_replace(array('é','è','ê','ë'),"e",$String);
    $String = str_replace(array('É','È','Ê','Ë'),"e",$String);
    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"o",$String);
    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
    $String = str_replace(array('ñ', 'Ñ'),"n",$String);
    $String = str_replace(" ","_",$String);   
    
    return $String;
}
    
    
}
