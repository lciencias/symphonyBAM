<?php

/**
 * 
 */
use Application\Model\Factory\ClientResolutionLogFactory;

use Application\Model\Bean\ClientResolutionLog;

use Application\Model\Bean\ClientResolution;

use Application\Model\Factory\ClientResolutionFactory;

use Application\Query\ClientResolutionQuery;

use Application\Controller\CrudController;
/**
 * 
 * @author joseluis
 *
 */
final class ClientResolutionController extends CrudController{
	/**
     * @module Client Resolution
     * @action List
	 */
	public function indexAction(){
		return $this->_redirect("client-resolution/list");
	}
	/**
     * @module Client Resolution
     * @action Create
	 */
	public function newAction(){
		$url = $this->generateUrl('company', 'create');
		$this->view->types = $this->getResolutionTypeCombo('Select One');
		$this->view->setTpl('Form');
	}
	
	/**
	 * @module Client Resolution
     * @action List
	 */
	public function listAction(){
		$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
		$this->view->params = $this->getRequest()->getParams();
		$total = ClientResolutionQuery::create()->filter($post)->count();
		$this->view->clientResolutions = ClientResolutionQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);
		$this->view->types = $this->getResolutionTypeCombo('All');
	}
	/**
	 * 
	 * @param array $header
	 */
	private function getResolutionTypeCombo($header = null){
		$types = ClientResolution::getTypesCombo($header);
		foreach ($types as $key => $type){
			$types[$key] = $this->i18n->_($type);
		}
		return $types;
	}
	/**
     * @module Resolution
     * @action Delete
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getClientResolutionCatalog()->beginTransaction();
		try {
			$clientResolution = ClientResolutionQuery::create()->findByPK($pk);
			$clientResolution->setStatus(ClientResolution::$Status['Inactive']);
			$this->getClientResolutionCatalog()->update($clientResolution);
			$this->newLogForDelete($clientResolution);
			$this->getClientResolutionCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('The Resolution was disabled'));
		}catch (Exception $e){
			$this->getClientResolutionCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('client-resolution/list');
	}
	
	/**
     * @module Client Resolution
     * @action Edit
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$clientResolution = ClientResolutionQuery::create()->findByPK($pk);
		$this->view->clientResolution = $clientResolution->toArray();
		$this->view->types = $this->getResolutionTypeCombo('Select One');
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Client Resolution
     * @action Create
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$clientResolution = ClientResolutionFactory::createFromArray($params);
			$this->getClientResolutionCatalog()->beginTransaction();
			try {
				$this->getClientResolutionCatalog()->create($clientResolution);
				$this->newLogForCreate($clientResolution);
				$this->getClientResolutionCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('The resolution was created'));
			}catch (Exception $e){
				$this->getClientResolutionCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('client-resolution/list');
		}
		
	}
	
	/**
     * @module Client Resolution
     * @action Update
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$clientResolution = ClientResolutionQuery::create()->findByPK($params['id_client_resolution']);
			ClientResolutionFactory::populate($clientResolution, $params);
			$this->getClientResolutionCatalog()->beginTransaction();
			try {
				$this->getClientResolutionCatalog()->update($clientResolution);
				$this->newLogForUpdate($clientResolution);
				$this->getClientResolutionCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('The Resolution was updated'));
			}catch (Exception $e){
				$this->getClientResolutionCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('client-resolution/list');
		}
	}
	/**
	 * 
	 * @return \Application\Model\Catalog\ClientResolutionCatalog
	 */
	private function getClientResolutionCatalog(){
		return $this->getCatalog('ClientResolutionCatalog');
	}
	/**
     * @module Client Resolution
     * @action Reactivate
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getClientResolutionCatalog()->beginTransaction();
		try {
			$clientResolution = ClientResolutionQuery::create()->findByPK($pk);
			$clientResolution->setStatus(ClientResolution::$Status['Active']);
			$this->getClientResolutionCatalog()->update($clientResolution);
			$this->newLogForReactivate($clientResolution);
			$this->getClientResolutionCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('The Resolution was reactivated'));
		}catch (Exception $e){
			$this->getClientResolutionCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('client-resolution/list');
	
		
	}
	/**
	 * @param ClientResolution $clientResolution
	 * @return \Application\Model\Bean\ClientResolutionLog
	 */
	protected function newLogForCreate(ClientResolution $clientResolution){
		return $this->newLog($clientResolution, ClientResolutionLog::$EventTypes['Create'] );
	}
	
	/**
	 * @param ClientResolution $clientResolution
	 * @return \Application\Model\Bean\ClientResolutionLog
	 */
	protected function newLogForUpdate(ClientResolution $clientResolution){
		return $this->newLog($clientResolution, ClientResolutionLog::$EventTypes['Update'] );
	}
	
	/**
	 * @param ClientResolution $clientResolution
	 * @return \Application\Model\Bean\ClientResolutionLog
	 */
	protected function newLogForDelete(ClientResolution $clientResolution){
		return $this->newLog($clientResolution, ClientResolutionLog::$EventTypes['Delete'] );
	}
	
	/**
	 * @param ClientResolution $clientResolution
	 * @return \Application\Model\Bean\ClientResolutionLog
	 */
	protected function newLogForReactivate(ClientResolution $clientResolution){
		return $this->newLog($clientResolution, ClientResolutionLog::$EventTypes['Reactivate'] );
	}
	
	/**
	 * @return \Application\Model\Bean\ClientResolutionLog
	 */
	private function newLog(ClientResolution $clientResolution, $eventType){
		$now = \Zend_Date::now();
		$log = ClientResolutionLogFactory::createFromArray(array(
				'id_client_resolution' => $clientResolution->getIdClientResolution(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('ClientResolutionLogCatalog')->create($log);
		return $log;
	}
}