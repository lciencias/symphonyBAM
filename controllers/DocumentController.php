<?php

/**
 * 
 */
use Application\Model\Factory\DocumentLogFactory;

use Application\Model\Bean\DocumentLog;

use Application\Model\Bean\Document;

use Application\Model\Factory\DocumentFactory;

use Application\Query\DocumentQuery;

use Application\Controller\CrudController;
/**
 * 
 * @author joseluis
 *
 */
final class DocumentController extends CrudController{
	/**
     * @module Document
     * @action List
	 */
	public function indexAction(){
		return $this->_redirect("document/list");
	}
	/**
     * @module Document
     * @action New
	 */
	public function newAction(){
		$url = $this->generateUrl('company', 'create');
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Document
     * @action List
	 */
	public function listAction(){
		$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
			$this->view->post = $post = $this->getRequest()->getParams();
		$total = DocumentQuery::create()->filter($post)->count();
		$this->view->documents = DocumentQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);
		
	}
	
	/**
     * @module Document
     * @action Delete
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getDocumentCatalog()->beginTransaction();
		try {
			$document = DocumentQuery::create()->findByPK($pk);
			$document->setStatus(Document::$Status['Inactive']);
			$this->getDocumentCatalog()->update($document);
			$this->newLogForDelete($document);
			$this->getDocumentCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getDocumentCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('document/list');
	}
	
	/**
     * @module Document
     * @action Edit
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$document = DocumentQuery::create()->findByPK($pk);
		$this->view->document = $document->toArray();
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Document
     * @action Create
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$document = DocumentFactory::createFromArray($params);
			$this->getDocumentCatalog()->beginTransaction();
			try {
				$this->getDocumentCatalog()->create($document);
				$this->newLogForCreate($document);
				$this->getDocumentCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido creada correctamente'));
			}catch (Exception $e){
				$this->getDocumentCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('document/list');
		}
		
	}
	
	/**
     * @module Document
     * @action Update
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$document = DocumentQuery::create()->findByPK($params['id_document']);
			DocumentFactory::populate($document, $params);
			$this->getDocumentCatalog()->beginTransaction();
			try {
				$this->getDocumentCatalog()->update($document);
				$this->newLogForUpdate($document);
				$this->getDocumentCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido actualizada correctamente'));
			}catch (Exception $e){
				$this->getDocumentCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('document/list');
		}
	}
	/**
	 * 
	 * @return \Application\Model\Catalog\DocumentCatalog
	 */
	private function getDocumentCatalog(){
		return $this->getCatalog('DocumentCatalog');
	}
	/**
     * @module Document
     * @action Reactivate
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getDocumentCatalog()->beginTransaction();
		try {
			$document = DocumentQuery::create()->findByPK($pk);
			$document->setStatus(Document::$Status['Active']);
			$this->getDocumentCatalog()->update($document);
			$this->newLogForReactivate($document);
			$this->getDocumentCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getDocumentCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('document/list');
	
		
	}
	/**
	 * @param Document $document
	 * @return \Application\Model\Bean\DocumentLog
	 */
	protected function newLogForCreate(Document $document){
		return $this->newLog($document, DocumentLog::$EventTypes['Create'] );
	}
	
	/**
	 * @param Document $document
	 * @return \Application\Model\Bean\DocumentLog
	 */
	protected function newLogForUpdate(Document $document){
		return $this->newLog($document, DocumentLog::$EventTypes['Update'] );
	}
	
	/**
	 * @param Document $document
	 * @return \Application\Model\Bean\DocumentLog
	 */
	protected function newLogForDelete(Document $document){
		return $this->newLog($document, DocumentLog::$EventTypes['Delete'] );
	}
	
	/**
	 * @param Document $document
	 * @return \Application\Model\Bean\DocumentLog
	 */
	protected function newLogForReactivate(Document $document){
		return $this->newLog($document, DocumentLog::$EventTypes['Reactivate'] );
	}
	
	/**
	 * @return \Application\Model\Bean\DocumentLog
	 */
	private function newLog(Document $document, $eventType){
		$now = \Zend_Date::now();
		$log = DocumentLogFactory::createFromArray(array(
				'id_document' => $document->getIdDocument(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('DocumentLogCatalog')->create($log);
		return $log;
	}
}