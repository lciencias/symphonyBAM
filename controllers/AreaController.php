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

use Application\Model\Catalog\AreaCatalog;
use Application\Model\Factory\AreaFactory;
use Application\Model\Bean\Area;
use Application\Query\AreaQuery;
use Application\Form\AreaForm;
use Application\Model\Bean\AreaLog;
use Application\Model\Factory\AreaLogFactory;
use Application\Model\Catalog\AreaLogCatalog;
use Application\Query\AreaLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class AreaController extends CrudController
{

    /**
     * @module Area
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Area
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = AreaQuery::create()->filter($post)->count();
        $this->view->areas = $areas = AreaQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->companies = array('' => $this->i18n->_('All')) + \Application\Query\CompanyQuery::create()->find()->toCombo();
        $this->view->statuses = $this->toFilterSelect(Area::$Status);
    }

    /**
     *
     * @module Home
     * @action home
     */
    public function jsonAction()
    {
        $id = $this->getRequest()->getParam('id');
        $firstOption = $this->getRequest()->getParam('firstOption');
        $extraId = $this->getRequest()->getParam('selected_id');

        $areas = AreaQuery::create()
            ->filter(array(Area::ID_COMPANY => $id))
            ->actives()
            ->find();

        if( $extraId ){
            $areas = $areas->merge(AreaQuery::create()->pk($extraId)->find());
        }

        $areas = $areas->map(function (Area $area){
            return array($area->getIdArea() => array(
                'id' => $area->getIdArea(),
                'area' => utf8_encode($area->getName()),
            ));
        });
        if( $firstOption ){
            $areas = array( -1 => array(
                'id' => '',
                'area' => $this->i18n->_("All"),
              )
            ) + $areas;
        }
        die(json_encode(array_values($areas)));
    }

    /**
     * @module Area
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('area', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Area
     * @action Edit
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $area = AreaQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Area with id {$id}"));

        $url = $this->generateUrl('area', 'update', compact('id'));
        $form = $this->getForm($area)
            ->populate($area->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Area
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
               $this->getAreaCatalog()->beginTransaction();

               $area = AreaFactory::createFromArray($form->getValues());
               $this->getAreaCatalog()->create($area);
               $this->newLogForCreate($area);

               $this->getAreaCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("Has been saved successfully"));
           }
           catch(Exception $e)
           {
               $this->getAreaCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('area/list');
    }

    /**
     * @module Area
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $area = AreaQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Area with id {$id}"));

        $form = $this->getForm($area);
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            try
            {
                $this->getAreaCatalog()->beginTransaction();

                AreaFactory::populate($area, $form->getValues());
                $this->getAreaCatalog()->update($area);
                $this->newLogForUpdate($area);

                $this->getAreaCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("Successfully updated Area"));
            }
            catch(Exception $e)
            {
                $this->getAreaCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('area/list');
    }

    /**
     * @module Area
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $area = AreaQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Area with id {$id}"));

        try
        {
            $this->getAreaCatalog()->beginTransaction();

            $area->setStatus(Area::$Status['Inactive']);
            $this->getAreaCatalog()->update($area);
            $this->newLogForDelete($area);

            $this->getAreaCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("Successfully deactivated Area"));
        }
        catch(Exception $e)
        {
            $this->getAreaCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('area/list');
    }

    /**
     * @module Area
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $area = AreaQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Area with id {$id}"));

        try
        {
            $this->getAreaCatalog()->beginTransaction();

            $area->setStatus(Area::$Status['Active']);
            $this->getAreaCatalog()->update($area);
            $this->newLogForReactivate($area);

            $this->getAreaCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("Successfully reactivated Area"));
        }
        catch(Exception $e)
        {
            $this->getAreaCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('area/list');
    }

    /**
     * @module Area
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $area = AreaQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Area with id {$id}"));
        $this->view->areaLogs = $logs = AreaLogQuery::create()->whereAdd('id_area', $id)->addDescendingOrderBy(AreaLog::DATE_LOG)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Area $area
     * @return \Application\Model\Bean\AreaLog
     */
    protected function newLogForCreate(Area $area){
        return $this->newLog($area, \Application\Model\Bean\AreaLog::$EventTypes['Create'] );
    }

    /**
     * @param Area $area
     * @return \Application\Model\Bean\AreaLog
     */
    protected function newLogForUpdate(Area $area){
        return $this->newLog($area, \Application\Model\Bean\AreaLog::$EventTypes['Update'] );
    }

    /**
     * @param Area $area
     * @return \Application\Model\Bean\AreaLog
     */
    protected function newLogForDelete(Area $area){
        return $this->newLog($area, AreaLog::$EventTypes['Delete'] );
    }

    /**
     * @param Area $area
     * @return \Application\Model\Bean\AreaLog
     */
    protected function newLogForReactivate(Area $area){
        return $this->newLog($area, AreaLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\AreaLog
     */
    private function newLog(Area $area, $eventType){
        $now = \Zend_Date::now();
        $log = AreaLogFactory::createFromArray(array(
            'id_area' => $area->getIdArea(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('AreaLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\AreaCatalog
     */
    protected function getAreaCatalog(){
        return $this->getContainer()->get('AreaCatalog');
    }

    /**
     *
     * @return Application\Form\AreaForm
     */
    protected function getForm(Area $area = null)
    {
        $form = new AreaForm(array('area' => $area));
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
