<?php

/**
 * 
 */
use Application\Query\CountryStateQuery;

use Application\Model\Factory\BranchLogFactory;

use Application\Model\Bean\BranchLog;

use Application\Model\Bean\Branch;

use Application\Model\Factory\BranchFactory;

use Application\Query\BranchQuery;

use Application\Controller\CrudController;
/**
 * 
 * @author joseluis
 *
 */
final class BranchController extends CrudController{
	/**
     * @module Branch
     * @action List
	 */
	public function indexAction(){
		return $this->_redirect("branch/list");
	}
	/**
     * @module Branch
     * @action New
	 */
	public function newAction(){
		$url = $this->generateUrl('company', 'create');
		$this->view->branch = new Branch();
		$this->view->states = CountryStateQuery::create()->actives()->find()->toCombo($this->i18n->_('Select One'));
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Branch
     * @action List
	 */
	public function listAction(){
		$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
		
		$this->view->params = $post = $this->getRequest()->getParams();
		$total = BranchQuery::create()->filter($post)->count();
		$this->view->states = CountryStateQuery::create()->actives()->find()->toCombo($this->i18n->_('Select One'));
		$this->view->branches = BranchQuery::create()->filter($post)->page($page, $this->getMaxPerPage())->find();
		$this->view->paginator = $this->createPaginator($total, $page);
		
	}
	
	/**
     * @module Branch
     * @action Delete
	 */
	public function deleteAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getBranchCatalog()->beginTransaction();
		try {
			$branch = BranchQuery::create()->findByPK($pk);
			$branch->setStatus(Branch::$Status['Inactive']);
			$this->getBranchCatalog()->update($branch);
			$this->newLogForDelete($branch);
			$this->getBranchCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getBranchCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('branch/list');
	}
	
	/**
     * @module Branch
     * @action Edit
	 */
	public function editAction(){
		$pk = $this->getRequest()->getParam('id');
		$branch = BranchQuery::create()->findByPK($pk);
		$this->view->branch = $branch;
		$this->view->states = CountryStateQuery::create()->actives()->find()->toCombo($this->i18n->_('Select One'));
		$this->view->setTpl('Form');
	}
	
	/**
     * @module Branch
     * @action Create
	 */
	public function createAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$branch = BranchFactory::createFromArray($params);
			$this->getBranchCatalog()->beginTransaction();
			try {
				$this->getBranchCatalog()->create($branch);
				$this->newLogForCreate($branch);
				$this->getBranchCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido creada correctamente'));
			}catch (Exception $e){
				$this->getBranchCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('branch/list');
		}
		
	}
	
	/**
     * @module Branch
     * @action Update
	 */
	public function updateAction(){
		if($this->getRequest()->isPost()){
			$params = $this->getRequest()->getParams();
			$branch = BranchQuery::create()->findByPK($params['id_branch']);
			BranchFactory::populate($branch, $params);
			$this->getBranchCatalog()->beginTransaction();
			try {
				$this->getBranchCatalog()->update($branch);
				$this->newLogForUpdate($branch);
				$this->getBranchCatalog()->commit();
				$this->setFlash('ok', $this->i18n->_('La sucursal ha sido actualizada correctamente'));
			}catch (Exception $e){
				$this->getBranchCatalog()->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
			$this->_redirect('branch/list');
		}
	}
	/**
	 * 
	 * @return \Application\Model\Catalog\BranchCatalog
	 */
	private function getBranchCatalog(){
		return $this->getCatalog('BranchCatalog');
	}
	/**
     * @module Branch
     * @action Reactivate
	 */
	public function reactivateAction(){
		$pk = $this->getRequest()->getParam('id');
		$this->getBranchCatalog()->beginTransaction();
		try {
			$branch = BranchQuery::create()->findByPK($pk);
			$branch->setStatus(Branch::$Status['Active']);
			$this->getBranchCatalog()->update($branch);
			$this->newLogForReactivate($branch);
			$this->getBranchCatalog()->commit();
			$this->setFlash('ok', $this->i18n->_('La sucursal ha sido desactivada correctamente'));
		}catch (Exception $e){
			$this->getBranchCatalog()->rollBack();
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect('branch/list');
	
		
	}
	/**
	 * @param Branch $branch
	 * @return \Application\Model\Bean\BranchLog
	 */
	protected function newLogForCreate(Branch $branch){
		return $this->newLog($branch, BranchLog::$EventTypes['Create'] );
	}
	
	/**
	 * @param Branch $branch
	 * @return \Application\Model\Bean\BranchLog
	 */
	protected function newLogForUpdate(Branch $branch){
		return $this->newLog($branch, BranchLog::$EventTypes['Update'] );
	}
	
	/**
	 * @param Branch $branch
	 * @return \Application\Model\Bean\BranchLog
	 */
	protected function newLogForDelete(Branch $branch){
		return $this->newLog($branch, BranchLog::$EventTypes['Delete'] );
	}
	
	/**
	 * @param Branch $branch
	 * @return \Application\Model\Bean\BranchLog
	 */
	protected function newLogForReactivate(Branch $branch){
		return $this->newLog($branch, BranchLog::$EventTypes['Reactivate'] );
	}
	
	/**
	 * @return \Application\Model\Bean\BranchLog
	 */
	private function newLog(Branch $branch, $eventType){
		$now = \Zend_Date::now();
		$log = BranchLogFactory::createFromArray(array(
				'id_branch' => $branch->getIdBranch(),
				'id_user' => $this->getUser()->getBean()->getIdUser(),
				'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
				'event_type' => $eventType,
				'note' => '',
		));
		$this->getCatalog('BranchLogCatalog')->create($log);
		return $log;
	}
        
     /**
     * @module Branch
     * @action Sync*/
    public function syncAction(){
        
    }
}