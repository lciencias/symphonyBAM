<?php

use Application\Model\Factory\RequiredDocumentLogFactory;

use Application\Model\Bean\RequiredDocumentLog;

use Application\Model\Bean\RequiredDocument;

use Application\Model\Factory\RequiredDocumentFactory;

use Application\Query\RequiredDocumentQuery;

use Application\Controller\CrudController;
/**
 * 
 * @author joseluis
 *
 */
final class RequiredDocumentController extends CrudController{
	/**
	 * 
	 */
	public function indexAction(){
		return $this->_redirect("required-document/list");
	}
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::newAction()
	 */
	public function newAction(){
		$url = $this->generateUrl('company', 'create');
		$this->view->setTpl('Form');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::listAction()
	 */
	public function listAction(){
		$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
		if( $this->getRequest()->isPost() ){
			$this->view->post = $post = $this->getRequest()->getParams();
		}
		$total = RequiredDocumentQuery::create()->filter($post)->count();
		$this->view->requiredDocuments = RequiredDocumentQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::deleteAction()
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getRequiredDocumentCatalog()->beginTransaction();
		try {
			$requiredDocument = RequiredDocumentQuery::create()->findByPK($pk);
			$requiredDocument->setStatus(RequiredDocument::$Status['Inactive']);
			$this->getRequiredDocumentCatalog()->update($requiredDocument);
			$this->newLogForDelete($requiredDocument);
			$this->getRequiredDocumentCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getRequiredDocumentCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('required-document/list');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::editAction()
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$requiredDocument = RequiredDocumentQuery::create()->findByPK($pk);
		$this->view->requiredDocument = $requiredDocument->toArray();
		$this->view->setTpl('Form');
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::createAction()
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$requiredDocument = RequiredDocumentFactory::createFromArray($params);
			$this->getRequiredDocumentCatalog()->beginTransaction();
			try {
				$this->getRequiredDocumentCatalog()->create($requiredDocument);
				$this->newLogForCreate($requiredDocument);
				$this->getRequiredDocumentCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido creada correctamente'));
			}catch (Exception $e){
				$this->getRequiredDocumentCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('required-document/list');
		}
		
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::updateAction()
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$requiredDocument = RequiredDocumentQuery::create()->findByPK($params['id_required_document']);
			RequiredDocumentFactory::populate($requiredDocument, $params);
			$this->getRequiredDocumentCatalog()->beginTransaction();
			try {
				$this->getRequiredDocumentCatalog()->update($requiredDocument);
				$this->newLogForUpdate($requiredDocument);
				$this->getRequiredDocumentCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido actualizada correctamente'));
			}catch (Exception $e){
				$this->getRequiredDocumentCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('required-document/list');
		}
	}
	/**
	 * 
	 * @return \Application\Model\Catalog\RequiredDocumentCatalog
	 */
	private function getRequiredDocumentCatalog(){
		return $this->getCatalog('RequiredDocumentCatalog');
	}
	/**
	 * Metodo
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getRequiredDocumentCatalog()->beginTransaction();
		try {
			$requiredDocument = RequiredDocumentQuery::create()->findByPK($pk);
			$requiredDocument->setStatus(RequiredDocument::$Status['Active']);
			$this->getRequiredDocumentCatalog()->update($requiredDocument);
			$this->newLogForReactivate($requiredDocument);
			$this->getRequiredDocumentCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getRequiredDocumentCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('required-document/list');
	
		
	}
	/**
	 * @param RequiredDocument $requiredDocument
	 * @return \Application\Model\Bean\RequiredDocumentLog
	 */
	protected function newLogForCreate(RequiredDocument $requiredDocument){
		return $this->newLog($requiredDocument, RequiredDocumentLog::$EventTypes['Create'] );
	}
	
	/**
	 * @param RequiredDocument $requiredDocument
	 * @return \Application\Model\Bean\RequiredDocumentLog
	 */
	protected function newLogForUpdate(RequiredDocument $requiredDocument){
		return $this->newLog($requiredDocument, RequiredDocumentLog::$EventTypes['Update'] );
	}
	
	/**
	 * @param RequiredDocument $requiredDocument
	 * @return \Application\Model\Bean\RequiredDocumentLog
	 */
	protected function newLogForDelete(RequiredDocument $requiredDocument){
		return $this->newLog($requiredDocument, RequiredDocumentLog::$EventTypes['Delete'] );
	}
	
	/**
	 * @param RequiredDocument $requiredDocument
	 * @return \Application\Model\Bean\RequiredDocumentLog
	 */
	protected function newLogForReactivate(RequiredDocument $requiredDocument){
		return $this->newLog($requiredDocument, RequiredDocumentLog::$EventTypes['Reactivate'] );
	}
	
	/**
	 * @return \Application\Model\Bean\RequiredDocumentLog
	 */
	private function newLog(RequiredDocument $requiredDocument, $eventType){
		$now = \Zend_Date::now();
		$log = RequiredDocumentLogFactory::createFromArray(array(
				'id_required_document' => $requiredDocument->getIdRequiredDocument(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('RequiredDocumentLogCatalog')->create($log);
		return $log;
	}
	}