<?php

/**
 * 
 */
use Application\Model\Factory\FieldLogFactory;

use Application\Model\Bean\FieldLog;

use Application\Model\Bean\Field;

use Application\Model\Factory\FieldFactory;

use Application\Query\FieldQuery;

use Application\Controller\CrudController;
/**
 * 
 * @author joseluis
 *
 */
final class FieldController extends CrudController{
	/**
     * @module Field
     * @action List
	 */
	public function indexAction(){
		return $this->_redirect("field/list");
	}
	/**
     * @module Field
     * @action New
	 */
	public function newAction(){
		$scripts = array('modules/field/form.js');
		$this->view->scripts = $scripts;
		$url = $this->generateUrl('company', 'create');
		$this->view->reguralExpressions = $this->getReguralExpressionsCombo();
		$this->view->setTpl('Form');
	}
	/**
	 * 
	 * @param array $header
	 */
	private function getReguralExpressionsCombo($header = null){
		$reguralExpressions = array_flip(Field::$RegEx);
		foreach ($reguralExpressions as $key => $text){
			$reguralExpressions[$key] = $this->i18n->_($text);
		}
		return $reguralExpressions;
	}
	/**
     * @module Field
     * @action List
	 */
	public function listAction(){
		$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
			$this->view->post = $post = $this->getRequest()->getParams();
		$total = FieldQuery::create()->filter($post)->count();
		$this->view->fields = FieldQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);
		
	}
	
	/**
     * @module Field
     * @action Delete
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getFieldCatalog()->beginTransaction();
		try {
			$field = FieldQuery::create()->findByPK($pk);
			$field->setStatus(Field::$Status['Inactive']);
			$this->getFieldCatalog()->update($field);
			$this->newLogForDelete($field);
			$this->getFieldCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('The Field was disabled'));
		}catch (Exception $e){
			$this->getFieldCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('field/list');
	}
	
	/**
     * @module Field
     * @action Edit
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$field = FieldQuery::create()->findByPK($pk);
		$this->view->field = $field->toArray();
		$scripts = array('modules/field/form.js');
		$this->view->scripts = $scripts;
		$this->view->reguralExpressions = $this->getReguralExpressionsCombo();
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Field
     * @action Create
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			if (empty($params['reg_ex'])){
				unset($params['reg_ex']);
			}
			$field = FieldFactory::createFromArray($params);
			$this->getFieldCatalog()->beginTransaction();
			try {
				$this->getFieldCatalog()->create($field);
				$this->newLogForCreate($field);
				$this->getFieldCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('The Field was created'));
			}catch (Exception $e){
				$this->getFieldCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('field/list');
		}
		
	}
	
	/**
     * @module Field
     * @action Update
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			if (empty($params['reg_ex'])){
				unset($params['reg_ex']);
			}
			$field = FieldQuery::create()->findByPK($params['id_field']);
			FieldFactory::populate($field, $params);
			$this->getFieldCatalog()->beginTransaction();
			try {
				$this->getFieldCatalog()->update($field);
				$this->newLogForUpdate($field);
				$this->getFieldCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('The Field was updated'));
			}catch (Exception $e){
				$this->getFieldCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('field/list');
		}
	}
	/**
	 * 
	 * @return \Application\Model\Catalog\FieldCatalog
	 */
	private function getFieldCatalog(){
		return $this->getCatalog('FieldCatalog');
	}
	/**
     * @module Field
     * @action Reactivate
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getFieldCatalog()->beginTransaction();
		try {
			$field = FieldQuery::create()->findByPK($pk);
			$field->setStatus(Field::$Status['Active']);
			$this->getFieldCatalog()->update($field);
			$this->newLogForReactivate($field);
			$this->getFieldCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('The Field was reactivated'));
		}catch (Exception $e){
			$this->getFieldCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('field/list');
	}
	/**
	 * @param Field $field
	 * @return \Application\Model\Bean\FieldLog
	 */
	protected function newLogForCreate(Field $field){
		return $this->newLog($field, FieldLog::$EventTypes['Create'] );
	}
	
	/**
	 * @param Field $field
	 * @return \Application\Model\Bean\FieldLog
	 */
	protected function newLogForUpdate(Field $field){
		return $this->newLog($field, FieldLog::$EventTypes['Update'] );
	}
	
	/**
	 * @param Field $field
	 * @return \Application\Model\Bean\FieldLog
	 */
	protected function newLogForDelete(Field $field){
		return $this->newLog($field, FieldLog::$EventTypes['Delete'] );
	}
	
	/**
	 * @param Field $field
	 * @return \Application\Model\Bean\FieldLog
	 */
	protected function newLogForReactivate(Field $field){
		return $this->newLog($field, FieldLog::$EventTypes['Reactivate'] );
	}
	
	/**
	 * @return \Application\Model\Bean\FieldLog
	 */
	private function newLog(Field $field, $eventType){
		$now = \Zend_Date::now();
		$log = FieldLogFactory::createFromArray(array(
				'id_field' => $field->getIdField(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('FieldLogCatalog')->create($log);
		return $log;
	}
}