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

use Application\Model\Catalog\ImpactCatalog;
use Application\Model\Factory\ImpactFactory;
use Application\Model\Bean\Impact;
use Application\Query\ImpactQuery;
use Application\Form\ImpactForm;
use Application\Model\Bean\ImpactLog;
use Application\Model\Factory\ImpactLogFactory;
use Application\Model\Catalog\ImpactLogCatalog;
use Application\Query\ImpactLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class ImpactController extends CrudController
{

    /**
     * @module Impact
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Impact
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = ImpactQuery::create()->filter($post)->count();
        $this->view->impacts = $impacts = ImpactQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(Impact::$Status);
    }

    /**
     * @module Impact
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('impact', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Impact
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $impact = ImpactQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Impact with id {$id}"));

        $url = $this->generateUrl('impact', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($impact->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Impact
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
               $this->getImpactCatalog()->beginTransaction();

               $impact = ImpactFactory::createFromArray($form->getValues());
               $this->getImpactCatalog()->create($impact);
               $this->newLogForCreate($impact);

               $this->getImpactCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Impact was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getImpactCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('impact/list');
    }

    /**
     * @module Impact
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
            $impact = ImpactQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Impact with id {$id}"));

            try
            {
                $this->getImpactCatalog()->beginTransaction();

                ImpactFactory::populate($impact, $form->getValues());
                $this->getImpactCatalog()->update($impact);
                $this->newLogForUpdate($impact);

                $this->getImpactCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Impact was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getImpactCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('impact/list');
    }

    /**
     * @module Impact
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $impact = ImpactQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Impact with id {$id}"));

        try
        {
            $this->getImpactCatalog()->beginTransaction();

            $impact->setStatus(Impact::$Status['Inactive']);
            $this->getImpactCatalog()->update($impact);
            $this->newLogForDelete($impact);

            $this->getImpactCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Impact was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getImpactCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('impact/list');
    }

    /**
     * @module Impact
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $impact = ImpactQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Impact with id {$id}"));

        try
        {
            $this->getImpactCatalog()->beginTransaction();

            $impact->setStatus(Impact::$Status['Active']);
            $this->getImpactCatalog()->update($impact);
            $this->newLogForReactivate($impact);

            $this->getImpactCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Impact was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getImpactCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('impact/list');
    }

    /**
     * @module Impact
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $impact = ImpactQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Impact with id {$id}"));
        $this->view->impactLogs = $logs = ImpactLogQuery::create()->whereAdd('id_impact', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Impact $impact
     * @return \Application\Model\Bean\ImpactLog
     */
    protected function newLogForCreate(Impact $impact){
        return $this->newLog($impact, \Application\Model\Bean\ImpactLog::$EventTypes['Create'] );
    }

    /**
     * @param Impact $impact
     * @return \Application\Model\Bean\ImpactLog
     */
    protected function newLogForUpdate(Impact $impact){
        return $this->newLog($impact, \Application\Model\Bean\ImpactLog::$EventTypes['Update'] );
    }

    /**
     * @param Impact $impact
     * @return \Application\Model\Bean\ImpactLog
     */
    protected function newLogForDelete(Impact $impact){
        return $this->newLog($impact, ImpactLog::$EventTypes['Delete'] );
    }

    /**
     * @param Impact $impact
     * @return \Application\Model\Bean\ImpactLog
     */
    protected function newLogForReactivate(Impact $impact){
        return $this->newLog($impact, ImpactLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\ImpactLog
     */
    private function newLog(Impact $impact, $eventType){
        $now = \Zend_Date::now();
        $log = ImpactLogFactory::createFromArray(array(
            'id_impact' => $impact->getIdImpact(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('ImpactLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\ImpactCatalog
     */
    protected function getImpactCatalog(){
        return $this->getContainer()->get('ImpactCatalog');
    }

    /**
     *
     * @return Application\Form\ImpactForm
     */
    protected function getForm()
    {
        $form = new ImpactForm();
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
