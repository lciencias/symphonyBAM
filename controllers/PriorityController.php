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

use Application\Model\Catalog\PriorityCatalog;
use Application\Model\Factory\PriorityFactory;
use Application\Model\Bean\Priority;
use Application\Query\PriorityQuery;
use Application\Form\PriorityForm;
use Application\Model\Bean\PriorityLog;
use Application\Model\Factory\PriorityLogFactory;
use Application\Model\Catalog\PriorityLogCatalog;
use Application\Query\PriorityLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class PriorityController extends CrudController
{

    /**
     * @module Priority
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Priority
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = PriorityQuery::create()->filter($post)->count();
        $this->view->priorities = $priorities = PriorityQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(Priority::$Status);
    }

    /**
     * @module Priority
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('priority', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Priority
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $priority = PriorityQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Priority with id {$id}"));

        $url = $this->generateUrl('priority', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($priority->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Priority
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
               $this->getPriorityCatalog()->beginTransaction();

               $priority = PriorityFactory::createFromArray($form->getValues());
               $this->getPriorityCatalog()->create($priority);
               $this->newLogForCreate($priority);

               $this->getPriorityCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Priority was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getPriorityCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('priority/list');
    }

    /**
     * @module Priority
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
            $priority = PriorityQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Priority with id {$id}"));

            try
            {
                $this->getPriorityCatalog()->beginTransaction();

                PriorityFactory::populate($priority, $form->getValues());
                $this->getPriorityCatalog()->update($priority);
                $this->newLogForUpdate($priority);

                $this->getPriorityCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Priority was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getPriorityCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('priority/list');
    }

    /**
     * @module Priority
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $priority = PriorityQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Priority with id {$id}"));

        try
        {
            $this->getPriorityCatalog()->beginTransaction();

            $priority->setStatus(Priority::$Status['Inactive']);
            $this->getPriorityCatalog()->update($priority);
            $this->newLogForDelete($priority);

            $this->getPriorityCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Priority was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getPriorityCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('priority/list');
    }

    /**
     * @module Priority
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $priority = PriorityQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Priority with id {$id}"));

        try
        {
            $this->getPriorityCatalog()->beginTransaction();

            $priority->setStatus(Priority::$Status['Active']);
            $this->getPriorityCatalog()->update($priority);
            $this->newLogForReactivate($priority);

            $this->getPriorityCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Priority was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getPriorityCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('priority/list');
    }

    /**
     * @module Priority
     * @action Traking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $priority = PriorityQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Priority with id {$id}"));
        $this->view->priorityLogs = $logs = PriorityLogQuery::create()->whereAdd('id_priority', $id)->addDescendingOrderBy(PriorityLog::DATE_LOG)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Priority $priority
     * @return \Application\Model\Bean\PriorityLog
     */
    protected function newLogForCreate(Priority $priority){
        return $this->newLog($priority, \Application\Model\Bean\PriorityLog::$EventTypes['Create'] );
    }

    /**
     * @param Priority $priority
     * @return \Application\Model\Bean\PriorityLog
     */
    protected function newLogForUpdate(Priority $priority){
        return $this->newLog($priority, \Application\Model\Bean\PriorityLog::$EventTypes['Update'] );
    }

    /**
     * @param Priority $priority
     * @return \Application\Model\Bean\PriorityLog
     */
    protected function newLogForDelete(Priority $priority){
        return $this->newLog($priority, PriorityLog::$EventTypes['Delete'] );
    }

    /**
     * @param Priority $priority
     * @return \Application\Model\Bean\PriorityLog
     */
    protected function newLogForReactivate(Priority $priority){
        return $this->newLog($priority, PriorityLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\PriorityLog
     */
    private function newLog(Priority $priority, $eventType){
        $now = \Zend_Date::now();
        $log = PriorityLogFactory::createFromArray(array(
            'id_priority' => $priority->getIdPriority(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('PriorityLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\PriorityCatalog
     */
    protected function getPriorityCatalog(){
        return $this->getContainer()->get('PriorityCatalog');
    }

    /**
     *
     * @return Application\Form\PriorityForm
     */
    protected function getForm()
    {
        $form = new PriorityForm();
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
