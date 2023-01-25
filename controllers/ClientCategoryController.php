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

use Application\Model\Collection\ClientCategoryCollection;

use Application\Query\TicketTypeQuery;

use Application\Model\Bean\TicketType;

use Application\Query\ClientCategoryResolutionQuery;

use Application\Model\Bean\ClientCategoryResolution;

use Application\Query\ResolutionQuery;

use Application\Query\ClientResolutionQuery;

use Application\Query\DocumentQuery;

use Application\Query\FieldQuery;

use Application\Model\Bean\RequiredDocument;

use Application\Query\RequiredDocumentQuery;

use Application\Model\Factory\RequiredFieldFactory;

use Application\Model\Factory\RequiredDocumentFactory;

use Application\Model\Bean\RequiredField;

use Application\Query\RequiredFieldQuery;

use Application\Query\EscalationQuery;

use Application\Query\ServiceLevelQuery;

use Application\Query\GroupQuery;

use Application\Model\Catalog\ClientCategoryCatalog;
use Application\Model\Factory\ClientCategoryFactory;
use Application\Model\Factory\ClientCategoryLogFactory;
use Application\Model\Bean\ClientCategory;
use Application\Model\Bean\ClientCategoryLog;
use Application\Query\ClientCategoryQuery;
use Application\Query\ClientCategoryLogQuery;
use Application\Query\UserQuery;
use Application\Query;
use Application\Query\CompanyQuery;
use Application\Form\ClientCategoryForm;
use Application\Controller\CrudController;
use Application\Model\Bean\Reasons;
use Application\Query\ProductsQuery;



/**
 *
 * @author chente
 */
class ClientCategoryController extends CrudController
{

    /**
     * @module ClientCategory
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module ClientCategory
     * @action List
     * @return array
     */
    public function listAction()
    {
    	$params = $this->getRequest()->getParams();
    	$this->view->idTicketType = $params['id_ticket_type']; 
    	if (!empty($params['id_ticket_type']))
    		$categories = ClientCategoryQuery::create()->filter($params)->find();
    	else 
    		$categories = new ClientCategoryCollection();
    	$this->view->ticketTypes = TicketTypeQuery::create()->actives()->find()->toCombo($this->i18n->_('None'));
        $this->view->nestedCategories =  $categories->filterRoot()->toNestedArray($categories);
    }

    /**
     * @module ClientCategory
     * @action Create
     * @return array
     */
    public function newAction()
    {
    	$scripts = array('modules/client-category/form.js');
    	$this->view->scripts = $scripts;
        $idParent = $this->getRequest()->getParam('idParent',null);
        $clientCategory = new ClientCategory();
        $idTicketType = $idTicketTypeR = $this->getRequest()->getParam('id_ticket_type',null);
        if($idParent){
            $clientCategoryR = $this->findByID($idParent);
            if($clientCategoryR)
                $idTicketTypeR=$clientCategoryR->getIdTicketType();
        }
        if($idTicketTypeR==4 || $idTicketTypeR==3 || $idTicketTypeR==2){
            $array=array_flip(Reasons::$subtypes);
            $products=ProductsQuery::create()->actives()->find();
            $this->view->subtype  = $this->translateCombo($array);     
            $this->view->products = $products;
            $this->view->listProducts=array();
        }
        if (isset($idTicketType) && !empty($idTicketType))
        	$clientCategory->setIdTicketType($idTicketType);
        elseif (isset($idParent) && !empty($idParent)){
        	$clientCategory->setIdParent($idParent);
        	$clientCategory->setIdTicketType(ClientCategoryQuery::create()->findByPK($idParent)->getIdTicketType());
        }
        else {
        	$this->setFlash('error', $this->i18n->_('There must be a parent for the Client Category or a ticket type selected to be able to create it.'));
        	$this->_redirect('client-category/list');
        }
		$this->view->onsubmit = 'create';
                $this->view->idTicketType=$idTicketType;
		$this->view->groups = GroupQuery::create()->actives()->find()->toCombo();
		$this->view->serviceLevels = ServiceLevelQuery::create()->actives()->find()->toCombo();
		$this->view->escalations = EscalationQuery::create()->actives()->find()->toCombo();
		$this->view->fields = FieldQuery::create()->actives()->find()->toCombo();
		$this->view->documents = DocumentQuery::create()->actives()->find()->toCombo();
        $this->view->category = $clientCategory->toArray();
        $this->view->setTpl("New");
        $this->view->requiredFields = array();
        $this->view->requiredDocuments = array();
        $this->view->favorableResolutions = ClientResolutionQuery::create()->favorable()->actives()->find()->toCombo();
        $this->view->unfavorableResolutions = ClientResolutionQuery::create()->unfavorable()->actives()->find()->toCombo();
        $this->view->clientCategoryResolutions = array();
    }

    /**
     * @module ClientCategory
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $clientCategory = $this->findByID($id);
        $scripts = array('modules/client-category/form.js');
        // aclaraciones
        if($clientCategory->getIdTicketType() >= 2 && $clientCategory->getIdTicketType() <=4){
            $array=array_flip(Reasons::$subtypes);
            $products=ProductsQuery::create()->actives()->find();
            $productsSelect="SELECT id_product FROM pcs_symphony_client_categories_products WHERE id_client_category='$id'";
            $listProduct=$this->getClientCategoryCatalog()->getDb()->fetchCol($productsSelect);
            
            $this->view->subtype=$subtype=$this->translateCombo($array);     
            $this->view->products=$products;
            $this->view->listProducts=$listProduct;
        }
        $this->view->scripts = $scripts;
		$this->view->onsubmit = 'update';
		$this->view->groups = GroupQuery::create()->find()->toCombo();
		$this->view->serviceLevels = ServiceLevelQuery::create()->find()->toCombo();
		$this->view->escalations = EscalationQuery::create()->find()->toCombo();
        $this->view->category = $clientCategory->toArray();
        $this->view->requiredFields = RequiredFieldQuery::create()->addColumn(RequiredField::ID_FIELD)->whereAdd(RequiredField::ID_CLIENT_CATEGORY, $id)->fetchCol();
        $this->view->favorableResolutions = ClientResolutionQuery::create()->favorable()->actives()->find()->toCombo();
        $this->view->unfavorableResolutions = ClientResolutionQuery::create()->unfavorable()->actives()->find()->toCombo();
        $this->view->clientCategoryResolutions = ClientCategoryResolutionQuery::create()
        ->addColumn(ClientCategoryResolution::ID_CLIENT_RESOLUTION)
        ->whereAdd(ClientCategoryResolution::ID_CLIENT_CATEGORY, $id)
        ->fetchCol();
        $this->view->requiredDocuments = RequiredDocumentQuery::create()
        ->addColumn(RequiredDocument::ID_DOCUMENT)->whereAdd(RequiredDocument::ID_CLIENT_CATEGORY, $id)
        ->fetchCol();
        
        $this->view->fields = FieldQuery::create()->actives()->find()->toCombo();
        $this->view->documents = DocumentQuery::create()->actives()->find()->toCombo();
        $this->view->setTpl("New");
    }

    /**
     * @module ClientCategory
     * @action Create
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $params['id_parent'] = $params['id_parent'] == 0 ? null : $params['id_parent']; 
           try
           {
               $this->getClientCategoryCatalog()->beginTransaction();
               $clientCategory = $this->createClientCategory($params);
               $this->saveRequiredFields($params['requiredFields'], $clientCategory->getIdClientCategory());
               $this->saveRequiredDocuments($params['requiredDocuments'], $clientCategory->getIdClientCategory());
               $this->saveResolutions($params['resolutions'], $clientCategory->getIdClientCategory());
               if($clientCategory->getIdTicketType() >= 2 && $clientCategory->getIdTicketType() <=4){
                    $delete="DELETE FROM pcs_symphony_client_categories_products WHERE id_client_category='".$clientCategory->getIdClientCategory()."'";
                    $this->getClientCategoryCatalog()->getDb()->query($delete);
                    foreach($params['productsIds'] as $id){
                       $insert="INSERT INTO pcs_symphony_client_categories_products(id_client_category,id_product) VALUES(".$clientCategory->getIdClientCategory().",$id)";
                       $this->getClientCategoryCatalog()->getDb()->query($insert);
                    }
                } 
               $this->getClientCategoryCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The ClientCategory was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getClientCategoryCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('client-category/list/id_ticket_type/'.$clientCategory->getIdTicketType());
    }

    /**
     *
     * @throws Exception
     */
    public function uploadAction()
    {
        if( $this->getRequest()->isPost() )
        {
            $file = new \Application\File\FileUploader('file');
            if( $file->isUpload() )
            {
                $file->saveFile("/tmp/", false);
                $reader = new \EasyCSV\Reader("/tmp/".$file->getFileName());
                $checker = new \EasyCSV\Checker(array(
                    "number","company","name","parent_number","escalation","group","service_level","note"
                ));
                $checker->addRequired('number')
                    ->addRequired('company')
                    ->addRequired('escalation')
                    ->addRequired('group')
                    ->addRequired('service_level')
                ;
                try {
                    $checker->check($reader);
                } catch (\EasyCSV\ValidationException $e) {
                    $this->view->errors = $e->getErrors();
                    return ;
                }

                $clientCategoryCatalog = $this->getCatalog('ClientCategoryCatalog');
                try
                {
                    $clientCategoryCatalog->beginTransaction();

                    $clientCategories = array();
                    foreach ($reader as $line => $row) {
                        $row = array_map('trim', $row);

                        $company = Query\CompanyQuery::create()->filter(array('name' => $row['company']))->findOneOrThrow("La empresa no existe");
                        $escalation = Query\EscalationQuery::create()->filter(array('name' => $row['escalation']))->findOneOrThrow("El escalamiento no existe");
                        $group = Query\GroupQuery::create()->filter(array('name' => $row['group']))->findOneOrThrow("El grupo no existe");
                        $serviceLevel = Query\ServiceLevelQuery::create()->filter(array('name' => $row['service_level']))->findOneOrThrow("El nivel de servicio no existe");

                        $clientCategory = $this->createClientCategory(array(
                            'id_company' => $company->getIdCompany(),
                            'id_escalation' => $escalation->getIdEscalation(),
                            'id_group' => $group->getIdGroup(),
                            'id_parent' => isset($clientCategories[$row['parent_number']]) ? $clientCategories[$row['parent_number']] : null,
                            'id_service_level' => $serviceLevel->getIdServiceLevel(),
                            'name' => $row['name'],
                            'note' => $row['note'],
                        ));
                        $clientCategories[$row['number']] = $clientCategory->getIdClientCategory();
                    }

                    $clientCategoryCatalog->commit();
                }
                catch (\Exception $e) {
                    $clientCategoryCatalog->rollBack();
                    throw $e;
                }

            }
        }
    }

    /**
     * @module ClientCategory
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $clientCategory = $this->findByID($id);

        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            $params['id_parent'] = $params['id_parent'] == 0 ? null : $params['id_parent'];
            try
            {
                $partialities=($params['partialities'])?"1":"0";
                $finantialMovements=($params['financial_movement'])?"1":"0";
                $this->getClientCategoryCatalog()->beginTransaction();

                ClientCategoryFactory::populate($clientCategory, $params);
                $clientCategory->setPartialities($partialities);
                $clientCategory->setFinancialMovement($finantialMovements);
                
                
                $this->getClientCategoryCatalog()->update($clientCategory);
                $this->saveRequiredFields($params['requiredFields'], $id);
                $this->saveRequiredDocuments($params['requiredDocuments'], $id);
                $this->saveResolutions($params['resolutions'], $id);
                
                if($clientCategory->getIdTicketType() >= 2 && $clientCategory->getIdTicketType() <=4){
                    $delete="DELETE FROM pcs_symphony_client_categories_products WHERE id_client_category='$id'";
                    $this->getClientCategoryCatalog()->getDb()->query($delete);
                    if(count($params['productsIds']) > 0){
                    	foreach($params['productsIds'] as $id){
                       	$insert="INSERT INTO pcs_symphony_client_categories_products(id_client_category,id_product) VALUES(".$clientCategory->getIdClientCategory().",$id)";
                       	$this->getClientCategoryCatalog()->getDb()->query($insert);
                    	}
                    }
                }
                $this->newLogForUpdate($clientCategory);
                $this->getClientCategoryCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The ClientCategory was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getClientCategoryCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('client-category/list/');
    }
    /**
     * It needs an opened transaction
     * @param unknown_type $requiredFieldsArray
     * @param unknown_type $idClientCategory
     */
	private function saveRequiredFields($requiredFieldsArray, $idClientCategory){
		$requiredFields = RequiredFieldQuery::create()->whereAdd(RequiredField::ID_CLIENT_CATEGORY, $idClientCategory)->find();
		while ($requiredField = $requiredFields->read()) {
			$this->getRequiredFieldCatalog()->deleteById($requiredField->getIdRequiredField());
		}
		if (is_array($requiredFieldsArray)){
			foreach ($requiredFieldsArray as $key => $idField){
				$requiredField = new RequiredField();
				$requiredField->setIdClientCategory($idClientCategory);
				$requiredField->setIdField($idField);
				$this->getRequiredFieldCatalog()->create($requiredField);
			}	
		}
	}
	/**
	 * It needs an opened transaction
	 * @param unknown_type $requiredDocumentsArray
	 * @param unknown_type $idClientCategory
	 */
	private function saveRequiredDocuments($requiredDocumentsArray, $idClientCategory){
		$requiredDocuments = RequiredDocumentQuery::create()->whereAdd(RequiredDocument::ID_CLIENT_CATEGORY, $idClientCategory)->find();
		while ($requiredDocument = $requiredDocuments->read()) {
			$this->getRequiredDocumentCatalog()->deleteById($requiredDocument->getIdRequiredDocument());
		}
		if (is_array($requiredDocumentsArray)){
			foreach ($requiredDocumentsArray as $key => $idDocument){
				$requiredDocument = new RequiredDocument();
				$requiredDocument->setIdClientCategory($idClientCategory);
				$requiredDocument->setIdDocument($idDocument);
				$this->getRequiredDocumentCatalog()->create($requiredDocument);
			}
		}
	}
	/**
	 * It needs an opened transaction
	 * @param unknown_type $requiredDocumentsArray
	 * @param unknown_type $idClientCategory
	 */
	private function saveResolutions($resolutionsArray, $idClientCategory){
		$resolutions = ClientCategoryResolutionQuery::create()->whereAdd(ClientCategoryResolution::ID_CLIENT_CATEGORY, $idClientCategory)->find();
		while ($resolution = $resolutions->read()) {
			$this->getClientCategoryResolutionCatalog()->deleteById($resolution->getIdClientCategoryResolution());
		}
		if (is_array($resolutionsArray)){
			foreach ($resolutionsArray as $key => $idClientResolution){
				$clientCategoryResolution = new ClientCategoryResolution();
				$clientCategoryResolution->setIdClientCategory($idClientCategory);
				$clientCategoryResolution->setIdClientResolution($idClientResolution);
				$this->getClientCategoryResolutionCatalog()->create($clientCategoryResolution);
			}
		}
	}
    /**
     * @module ClientCategory
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $clientCategory = $this->findByID($id);

        try
        {
            $this->getClientCategoryCatalog()->beginTransaction();

            $clientCategory->setStatus(ClientCategory::$Status['Inactive']);
            $this->getClientCategoryCatalog()->update($clientCategory);
            $this->newLogForDelete($clientCategory);

            $this->getClientCategoryCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Client Category was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getClientCategoryCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('client-category/list/');
    }

    /**
     * @module ClientCategory
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $clientCategory = $this->findByID($id);

        try
        {
            $this->getClientCategoryCatalog()->beginTransaction();

            $clientCategory->setStatus(ClientCategory::$Status['Active']);
            $this->getClientCategoryCatalog()->update($clientCategory);
            $this->newLogForReactivate($clientCategory);

            $this->getClientCategoryCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Client Category was successfully activated"));
        }
        catch(Exception $e)
        {
            $this->getClientCategoryCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('client-category/list/');
    }

    /**
     * @module ClientCategory
     * @action Tracking
     */
    protected function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $clientCategory = $this->findByID($id);
        $this->view->clientCategoryLogs = ClientCategoryLogQuery::create()->whereAdd(ClientCategoryLog::ID_CLIENT_CATEGORY, $id)->find();
        $this->view->users = UserQuery::create()->find()->toCombo();
    }

    /**
     *
     * @param array $params
     * @return ClientCategory
     */
    protected function createClientCategory($params)
    {
        $clientCategory = ClientCategoryFactory::createFromArray($params);
        $clientCategory->setStatus(ClientCategory::$Status['Active']);
        $clientCategory->setIsLeaf(true);
        if( $clientCategory->getIdParent() ){
            $parentClientCategory = $this->findByID($clientCategory->getIdParent());
            $parentClientCategory->setIsLeaf(false);
            $this->getClientCategoryCatalog()->update($parentClientCategory);
        }

        $this->getClientCategoryCatalog()->create($clientCategory);
        $this->newLogForCreate($clientCategory);

        return $clientCategory;
    }

    /**
     * @param ClientCategory $clientCategory
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    protected function newLogForCreate(ClientCategory $clientCategory){
        return $this->newLog($clientCategory, \Application\Model\Bean\ClientCategoryLog::$EventTypes['Create'] );
    }

    /**
     * @param ClientCategory $clientCategory
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    protected function newLogForUpdate(ClientCategory $clientCategory){
        return $this->newLog($clientCategory, \Application\Model\Bean\ClientCategoryLog::$EventTypes['Update'] );
    }

    /**
     * @param ClientCategory $clientCategory
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    protected function newLogForDelete(ClientCategory $clientCategory){
        return $this->newLog($clientCategory, ClientCategoryLog::$EventTypes['Delete'] );
    }

    /**
     * @param ClientCategory $clientCategory
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    protected function newLogForReactivate(ClientCategory $clientCategory){
        return $this->newLog($clientCategory, ClientCategoryLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\ClientCategoryLog
     */
    private function newLog(ClientCategory $clientCategory, $eventType){
        $now = \Zend_Date::now();
        $log = ClientCategoryLogFactory::createFromArray(array(
            'id_client_category' => $clientCategory->getIdClientCategory(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('ClientCategoryLogCatalog')->create($log);
        return $log;
    }

    /**
     *
     * @param int $id
     * @return ClientCategory
     */
    private function findByID($id){
        return ClientCategoryQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("Not exists the ClientCategory with id: ").$id);
    }

    /**
     * @return \Application\Model\Catalog\ClientCategoryCatalog
     */
    protected function getClientCategoryCatalog(){
        return $this->getContainer()->get('ClientCategoryCatalog');
    }
    
    /**
     * @return \Application\Model\Catalog\RequiredFieldCatalog
     */
    protected function getRequiredFieldCatalog(){
    	return $this->getContainer()->get('RequiredFieldCatalog');
    }
    
    /**
     * @return \Application\Model\Catalog\RequiredDocumentCatalog
     */
    protected function getRequiredDocumentCatalog(){
    	return $this->getContainer()->get('RequiredDocumentCatalog');
    }
    
    /**
     * @return \Application\Model\Catalog\ClientCategoryResolutionCatalog
     */
    protected function getClientCategoryResolutionCatalog(){
    	return $this->getContainer()->get('ClientCategoryResolutionCatalog');
    }

    /**
     * @return \Application\Service\ClientCategoryService
     */
    protected function getClientCategoryService(){
        return $this->getContainer()->get('ClientCategoryService');
    }

    /**
     * @param array $options
     * @return Application\Form\ClientCategoryForm
     */
    protected function getForm($options = array())
    {
        $form = new ClientCategoryForm($options);
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

}
