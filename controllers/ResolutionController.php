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

use Application\Model\Catalog\ResolutionCatalog;
use Application\Model\Factory\ResolutionFactory;
use Application\Model\Bean\Resolution;
use Application\Query\ResolutionQuery;
use Application\Form\ResolutionForm;
use Application\Model\Bean\ResolutionLog;
use Application\Model\Factory\ResolutionLogFactory;
use Application\Model\Catalog\ResolutionLogCatalog;
use Application\Query\ResolutionLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class ResolutionController extends CrudController
{

    /**
     * @module Resolution
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Resolution
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->assignCombos();
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = ResolutionQuery::create()->filter($post)->count();
        $this->view->resolutions = $resolutions = ResolutionQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Resolution
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('resolution', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Resolution
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $resolution = ResolutionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Resolution with id {$id}"));

        $url = $this->generateUrl('resolution', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($resolution->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Resolution
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
               $this->getResolutionCatalog()->beginTransaction();

               $resolution = ResolutionFactory::createFromArray($form->getValues());
               $resolution->setStatus(Resolution::$Status['Active']);
               $this->getResolutionCatalog()->create($resolution);
               $this->newLogForCreate($resolution);

               $this->getResolutionCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Resolution was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getResolutionCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('resolution/list');
    }

    /**
     * @module Resolution
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
            $resolution = ResolutionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Resolution with id {$id}"));

            try
            {
                $this->getResolutionCatalog()->beginTransaction();

                ResolutionFactory::populate($resolution, $form->getValues());
                $this->getResolutionCatalog()->update($resolution);
                $this->newLogForUpdate($resolution);

                $this->getResolutionCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Resolution was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getResolutionCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('resolution/list');
    }

    /**
     * @module Resolution
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $resolution = ResolutionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Resolution with id {$id}"));

        try
        {
            $this->getResolutionCatalog()->beginTransaction();

            $resolution->setStatus(Resolution::$Status['Inactive']);
            $this->getResolutionCatalog()->update($resolution);
            $this->newLogForDelete($resolution);

            $this->getResolutionCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Resolution was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getResolutionCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('resolution/list');
    }

    /**
     * @module Resolution
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $resolution = ResolutionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Resolution with id {$id}"));

        try
        {
            $this->getResolutionCatalog()->beginTransaction();

            $resolution->setStatus(Resolution::$Status['Active']);
            $this->getResolutionCatalog()->update($resolution);
            $this->newLogForReactivate($resolution);

            $this->getResolutionCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Resolution was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getResolutionCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('resolution/list');
    }

    /**
     * @module Resolution
     * @action Traking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $resolution = ResolutionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Resolution with id {$id}"));
        $this->view->resolutionLogs = $logs = ResolutionLogQuery::create()->whereAdd('id_resolution', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Resolution $resolution
     * @return \Application\Model\Bean\ResolutionLog
     */
    protected function newLogForCreate(Resolution $resolution){
        return $this->newLog($resolution, \Application\Model\Bean\ResolutionLog::$EventTypes['Create'] );
    }

    /**
     * @param Resolution $resolution
     * @return \Application\Model\Bean\ResolutionLog
     */
    protected function newLogForUpdate(Resolution $resolution){
        return $this->newLog($resolution, \Application\Model\Bean\ResolutionLog::$EventTypes['Update'] );
    }

    /**
     * @param Resolution $resolution
     * @return \Application\Model\Bean\ResolutionLog
     */
    protected function newLogForDelete(Resolution $resolution){
        return $this->newLog($resolution, ResolutionLog::$EventTypes['Delete'] );
    }

    /**
     * @param Resolution $resolution
     * @return \Application\Model\Bean\ResolutionLog
     */
    protected function newLogForReactivate(Resolution $resolution){
        return $this->newLog($resolution, ResolutionLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\ResolutionLog
     */
    private function newLog(Resolution $resolution, $eventType){
        $now = \Zend_Date::now();
        $log = ResolutionLogFactory::createFromArray(array(
            'id_resolution' => $resolution->getIdResolution(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('ResolutionLogCatalog')->create($log);
        return $log;
    }

    /**
     *
     */
    private function assignCombos(){
        $this->view->statuses = $this->toFilterSelect(Resolution::$Status);
        $this->view->types = $this->toFilterSelect(Resolution::$Types);
    }

    /**
     * @return \Application\Model\Catalog\ResolutionCatalog
     */
    protected function getResolutionCatalog(){
        return $this->getContainer()->get('ResolutionCatalog');
    }

    /**
     *
     * @return Application\Form\ResolutionForm
     */
    protected function getForm()
    {
        $form = new ResolutionForm();
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
