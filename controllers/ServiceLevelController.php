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

use Application\Model\Catalog\ServiceLevelCatalog;
use Application\Model\Factory\ServiceLevelFactory;
use Application\Model\Bean\ServiceLevel;
use Application\Query\ServiceLevelQuery;
use Application\Form\ServiceLevelForm;
use Application\Model\Bean\ServiceLevelLog;
use Application\Model\Factory\ServiceLevelLogFactory;
use Application\Model\Catalog\ServiceLevelLogCatalog;
use Application\Query\ServiceLevelLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class ServiceLevelController extends CrudController
{

    /**
     * @module Service Level
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Service Level
     * @action List
     * @return array
     */
    public function listAction()
    {
        $post = $this->getRequest()->getParams();
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
        $total = ServiceLevelQuery::create()->filter($post)->count();
        $this->view->serviceLevels = $serviceLevels = ServiceLevelQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->statuses = $this->toFilterSelect(ServiceLevel::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Service Level
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('service-level', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Service Level
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the ServiceLevel with id {$id}"));

        $url = $this->generateUrl('service-level', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($serviceLevel->toArray())
            ->setAction($url);

        $this->view->post = $post = $serviceLevel->toArray();
        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Service Level
     * @action Create
     * @return array
     */
    public function createAction()
    {
        $form = $this->getForm();
        if( $this->getRequest()->isPost() ){
           $params = $this->getRequest()->getParams();
           if( !$form->isValid($params) ){
               $this->view->setTpl("New");
               $this->view->form = $form;
               return;
           }
           try
           {
               $this->getServiceLevelCatalog()->beginTransaction(); 
               
               $resolution = explode(':', $params['resolution_time']);
               $resolutionHrs = (($resolution[0]*24)+$resolution[1]);
               $resolutionMin = ($resolutionHrs*60)+$resolution[2];
            
               $response = explode(':', $params['response_time']);
               $responseHrs = (($response[0]*24)+$response[1]);
               $responseMin = ($responseHrs*60)+$response[2];

               $register = ServiceLevelQuery::create()->whereAdd(ServiceLevel::NAME, trim($params['name']))->fetchAll();
               if(count($register) == 0){
	               $data = array(
    	                'name' => $params['name'],
        	            'resolution_time' =>  $resolutionMin,
            	        'response_time' => $responseMin,
                	    'note' =>  $params['note'],
                    	'status' => $params['status']
                	);
               		if( $resolutionMin <= 0 || $responseMin <= 0 ){
                    	throw new Exception("Resolution or Response Time is invalid");
               		}
               		$serviceLevel = ServiceLevelFactory::createFromArray($data);
               		$this->getServiceLevelCatalog()->create($serviceLevel);
               		$this->newLogForCreate($serviceLevel);
               		$this->getServiceLevelCatalog()->commit();
               		$this->setFlash('ok', $this->i18n->_("The Service level was created correctly"));
               }else{
               		$this->setFlash('error', $this->i18n->_("The name already exists"));
               }
           }
           catch(Exception $e)
           {
               $this->getServiceLevelCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('service-level/list');
    }

    /**
     * @module Service Level
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $form = $this->getForm();
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();

            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            $id = $this->getRequest()->getParam('id');
            $serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the ServiceLevel with id {$id}"));

            try
            {
                $this->getServiceLevelCatalog()->beginTransaction();
                
             
                $resolution = explode(':', $params['resolution_time']);
                $resolutionHrs = (($resolution[0]*24)+$resolution[1]);
                $resolutionMin = ($resolutionHrs*60)+$resolution[2];
                
                $response = explode(':', $params['response_time']);
                $responseHrs = (($response[0]*24)+$response[1]);
                $responseMin = ($responseHrs*60)+$response[2];

                $data = array(
                    'name' => $params['name'],
                    'resolution_time' =>  $resolutionMin,
                    'response_time' => $responseMin,
                    'note' =>  $params['note'],
                    'status' => $params['status']
                );

                if( $resolutionMin <= 0 || $responseMin <= 0 ){
                    throw new Exception("Resolution or Response Time is invalid");
                }

                ServiceLevelFactory::populate($serviceLevel, $data);
                $this->getServiceLevelCatalog()->update($serviceLevel);
                $this->newLogForUpdate($serviceLevel);

                $this->getServiceLevelCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Service level was updated correctly"));
            }
            catch(\Exception $e)
            {
                $this->getServiceLevelCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('service-level/list');
    }

    /**
     * @module Service Level
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the ServiceLevel with id {$id}"));

        try
        {
            $this->getServiceLevelCatalog()->beginTransaction();

            $serviceLevel->setStatus(ServiceLevel::$Status['Inactive']);
            $this->getServiceLevelCatalog()->update($serviceLevel);
            $this->newLogForDelete($serviceLevel);

            $this->getServiceLevelCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Service level was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getServiceLevelCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('service-level/list');
    }

    /**
     * @module Service Level
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the ServiceLevel with id {$id}"));

        try
        {
            $this->getServiceLevelCatalog()->beginTransaction();

            $serviceLevel->setStatus(ServiceLevel::$Status['Active']);
            $this->getServiceLevelCatalog()->update($serviceLevel);
            $this->newLogForReactivate($serviceLevel);

            $this->getServiceLevelCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Service level was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getServiceLevelCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('service-level/list');
    }

    /**
     * @module Service Level
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the ServiceLevel with id {$id}"));
        $this->view->serviceLevelLogs = $logs = ServiceLevelLogQuery::create()->whereAdd('id_service_level', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param ServiceLevel $serviceLevel
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    protected function newLogForCreate(ServiceLevel $serviceLevel){
        return $this->newLog($serviceLevel, \Application\Model\Bean\ServiceLevelLog::$EventTypes['Create'] );
    }

    /**
     * @param ServiceLevel $serviceLevel
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    protected function newLogForUpdate(ServiceLevel $serviceLevel){
        return $this->newLog($serviceLevel, \Application\Model\Bean\ServiceLevelLog::$EventTypes['Update'] );
    }

    /**
     * @param ServiceLevel $serviceLevel
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    protected function newLogForDelete(ServiceLevel $serviceLevel){
        return $this->newLog($serviceLevel, ServiceLevelLog::$EventTypes['Delete'] );
    }

    /**
     * @param ServiceLevel $serviceLevel
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    protected function newLogForReactivate(ServiceLevel $serviceLevel){
        return $this->newLog($serviceLevel, ServiceLevelLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\ServiceLevelLog
     */
    private function newLog(ServiceLevel $serviceLevel, $eventType){
        $now = \Zend_Date::now();
        $log = ServiceLevelLogFactory::createFromArray(array(
            'id_service_level' => $serviceLevel->getIdServiceLevel(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('ServiceLevelLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\ServiceLevelCatalog
     */
    protected function getServiceLevelCatalog(){
        return $this->getContainer()->get('ServiceLevelCatalog');
    }

    /**
     *
     * @return Application\Form\ServiceLevelForm
     */
    protected function getForm()
    {
        $form = new ServiceLevelForm();
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
