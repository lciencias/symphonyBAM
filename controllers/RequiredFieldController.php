<?php

use Application\Query\CategoryQuery;

use Application\Model\Factory\RequiredFieldLogFactory;

use Application\Model\Bean\RequiredFieldLog;

use Application\Model\Bean\RequiredField;

use Application\Model\Factory\RequiredFieldFactory;

use Application\Query\RequiredFieldQuery;

use Application\Controller\CrudController;
/**
 *
 * @author joseluis
 *
 */
final class RequiredFieldController extends CrudController{
	/**
	 *
	 */
	public function indexAction(){
		return $this->_redirect("required-field/list");
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
		$total = RequiredFieldQuery::create()->filter($post)->count();
		
		$this->view->categories = CategoryQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);

	}

	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::deleteAction()
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getRequiredFieldCatalog()->beginTransaction();
		try {
			$requiredField = RequiredFieldQuery::create()->findByPK($pk);
			$requiredField->setStatus(RequiredField::$Status['Inactive']);
			$this->getRequiredFieldCatalog()->update($requiredField);
			$this->newLogForDelete($requiredField);
			$this->getRequiredFieldCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getRequiredFieldCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('required-field/list');
	}

	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::editAction()
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$requiredField = RequiredFieldQuery::create()->findByPK($pk);
		$this->view->requiredField = $requiredField->toArray();
		$this->view->setTpl('Form');
	}

	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::createAction()
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$requiredField = RequiredFieldFactory::createFromArray($params);
			$this->getRequiredFieldCatalog()->beginTransaction();
			try {
				$this->getRequiredFieldCatalog()->create($requiredField);
				$this->newLogForCreate($requiredField);
				$this->getRequiredFieldCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido creada correctamente'));
			}catch (Exception $e){
				$this->getRequiredFieldCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('required-field/list');
		}

	}

	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::updateAction()
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$requiredField = RequiredFieldQuery::create()->findByPK($params['id_required_field']);
			RequiredFieldFactory::populate($requiredField, $params);
			$this->getRequiredFieldCatalog()->beginTransaction();
			try {
				$this->getRequiredFieldCatalog()->update($requiredField);
				$this->newLogForUpdate($requiredField);
				$this->getRequiredFieldCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido actualizada correctamente'));
			}catch (Exception $e){
				$this->getRequiredFieldCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('required-field/list');
		}
	}
	/**
	 *
	 * @return \Application\Model\Catalog\RequiredFieldCatalog
	 */
	private function getRequiredFieldCatalog(){
		return $this->getCatalog('RequiredFieldCatalog');
	}
	/**
	 *
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getRequiredFieldCatalog()->beginTransaction();
		try {
			$requiredField = RequiredFieldQuery::create()->findByPK($pk);
			$requiredField->setStatus(RequiredField::$Status['Active']);
			$this->getRequiredFieldCatalog()->update($requiredField);
			$this->newLogForReactivate($requiredField);
			$this->getRequiredFieldCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getRequiredFieldCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('required-field/list');


	}
	/**
	 * @param RequiredField $requiredField
	 * @return \Application\Model\Bean\RequiredFieldLog
	 */
	protected function newLogForCreate(RequiredField $requiredField){
		return $this->newLog($requiredField, RequiredFieldLog::$EventTypes['Create'] );
	}

	/**
	 * @param RequiredField $requiredField
	 * @return \Application\Model\Bean\RequiredFieldLog
	 */
	protected function newLogForUpdate(RequiredField $requiredField){
		return $this->newLog($requiredField, RequiredFieldLog::$EventTypes['Update'] );
	}

	/**
	 * @param RequiredField $requiredField
	 * @return \Application\Model\Bean\RequiredFieldLog
	 */
	protected function newLogForDelete(RequiredField $requiredField){
		return $this->newLog($requiredField, RequiredFieldLog::$EventTypes['Delete'] );
	}

	/**
	 * @param RequiredField $requiredField
	 * @return \Application\Model\Bean\RequiredFieldLog
	 */
	protected function newLogForReactivate(RequiredField $requiredField){
		return $this->newLog($requiredField, RequiredFieldLog::$EventTypes['Reactivate'] );
	}

	/**
	 * @return \Application\Model\Bean\RequiredFieldLog
	 */
	private function newLog(RequiredField $requiredField, $eventType){
		$now = \Zend_Date::now();
		$log = RequiredFieldLogFactory::createFromArray(array(
				'id_required_field' => $requiredField->getIdRequiredField(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('RequiredFieldLogCatalog')->create($log);
		return $log;
	}
}